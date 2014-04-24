<?php

//Max length of summaries on Articles displayed on the home page
$MAX_SUMMARY_LEN = 500;

//Get a random image from the directory
$dire="css/home_photos/";
$images = glob($dire. '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
//Randomize the array
shuffle($images);

$picture = array( 
    array_pop($images),
    array_pop($images),
    array_pop($images)
);

$stream_list = "";

//Get current time
$currentTime = new DateTime(date('Y-m-d H:i:s'));
//Add 5 minutes
$currentTime->sub(new DateInterval('PT' . 5 . 'M'));
//Set it as the check time
$checkTime = $currentTime->format('Y-m-d H:i');

//Max number of streams
$max_streams = 7;

//Check the database
$query = $db->prepare("SELECT * FROM streams ORDER BY timestamp LIMIT $max_streams");
$query->execute();

$streamData = $query->fetch();

//Does not
if($streamData['timestamp'] > $checkTime) {
    $i=0;
    do {
        $stream[$i]['img'] = $streamData['img'];
        $stream[$i]['count'] = $streamData['count'];
        $stream[$i]['name'] = $streamData['name'];
        $i++;
    } while($streamData = $query->fetch());
}
//Needs Updating
else {
    $i = 0;
    do {
        $streamList[$i] = $streamData['name'];
        $i++;
    } while($streamData = $query->fetch());
    
    //Put it into readable code for the website
    foreach($streamList as $i) {
        $stream_list = $stream_list . strtolower($i) . ",";
    }
    //Send in the request
    $mycurl = curl_init();
    curl_setopt ($mycurl, CURLOPT_HEADER, 0);
    curl_setopt ($mycurl, CURLOPT_RETURNTRANSFER, 1); 
    //Build the URL 
    $url = "http://api.justin.tv/api/stream/list.json?channel=" . $stream_list; 
    curl_setopt ($mycurl, CURLOPT_URL, $url);
    $web_response =  curl_exec($mycurl); 
    $results = json_decode($web_response); 
    
    //Save the number of streams
    $num_streams = count($streamList);
    
    /* Give the data to the webpage */
    //Print out all online streams
    for($i=0; $i < count($results); ++$i) {
        $stream[$i]['img'] = $results[$i]->channel->screen_cap_url_small;
        $stream[$i]['count'] = $results[$i]->channel_count;
        
        $index = array_search($results[$i]->channel->login, array_map('strtolower', $streamList)); 
        $temp = $streamList[$index];
        $streamList[$index] = $streamList[$i];
        $streamList[$i] = $temp;
        
        //Name
        $stream[$i]['name'] = $temp;
        //Swap $i with the key where this value is
        //
        //$streamList = array_diff($streamList, array($stream[$i]['name']));
    }
    //Print out the rest
    for(; $i < count($streamList); ++$i) {
        $stream[$i]['img'] = "css/img/offline.png";
        $stream[$i]['count'] = 0;
        $stream[$i]['name'] = $streamList[$i];
    }
    
    //Save the data to the database
    for($i=0; $i<$num_streams; ++$i) {
        $query = $db->prepare("UPDATE streams SET img = ?, count = ?, timestamp = ? WHERE name = ? ");
        $query->bindValue(1, $stream[$i]['img']);
        $query->bindValue(2, $stream[$i]['count']);
        $query->bindValue(3, date('Y-m-d H:i:s'));
        $query->bindValue(4, $stream[$i]['name']);
        $query->execute();
    }
}

//Save the number of streams
$num_streams = $i;
//Number of pictures
$NUM_PICTURES = 3;

?>

<!-- Three Pictures -->
<div id="picture_container">
    <?php
    //Display the three pictures
    for($i = 0; $i < $NUM_PICTURES; ++$i) {
        if($i == 0) {
            echo '<div id="first_picture_box">';
        }
        else {
            echo '<div class="com_picture_box">';
        }

        echo '<img src="' . $picture[$i] . '" class="com_picture"/>';
        echo '</div>';
    }
    ?>
</div>

<!-- Start Home -->
<div id="home">
    <div id="middle">

		<?php
		
		// postAuthor should be ID not the string... so that if a name changes it 
		
			try {

				$stmt = $db->query('SELECT postID, postTitle, postAuthor, postImg, postCont, postDate FROM blog_posts ORDER BY postID DESC');
				while($row = $stmt->fetch()){
					
					echo '<div class="article">';
					echo '	<div class="article_info">';
					//Event Title
					echo '		<div class="article_title"><a href="?page=viewpost&id='.$row['postID'].'">'.$row['postTitle'].'</a></div>';
					echo '		<div class="article_date">'.$row['postAuthor'].' at ' . date('jS M Y H:i:s', strtotime($row['postDate'])) . ' on ' . date('jS M Y H:i:s', strtotime($row['postDate'])) . '</div>';
					echo '		<a href="?page=viewpost&id='.$row['postID'].'"><div class="article_img"><img src="css/img/article_img/' . $row['postImg'] . '"/></div></a>';
					//Event Summary
					echo '		<div class="article_summary">' . $general->summarize($row['postCont'], $MAX_SUMMARY_LEN) . '</div>';
					echo '		<a href="?page=viewpost&id='.$row['postID'].'"><div class="article_more">Read More ></div></a>';
					echo '	</div>
								</div>';

				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>
        <!-- Link to all news -->
        <!--<div id="past_news">Past News</div>-->
        <div class="clear"></div>
				</div>
	<div id="left">
        <div id="stream_list">
            <div class="title">Featured Streamers</div>
            <?php
            
            //Sort the streams in order of count
            usort($stream, function($a, $b) {
                return $b['count'] - $a['count'];
            });
            
            //Print out the streams
            for($i=0; $i<$num_streams; ++$i) {
                echo '<a href="http://www.twitch.tv/' . $stream[$i]['name'] . '"><div class="stream">';
                echo '<div id="stream_img"><img src="' . $stream[$i]['img'] . '"/></div>';
                echo '<div id="stream_name">' . $stream[$i]['name'];
                //Add appropriate tags
                if($stream[$i]['count'] == 0) {
                    $stream[$i]['count'] = 'offline';
                }
                else {
                    $stream[$i]['count'] = $stream[$i]['count'] . ' viewers';

                }
                echo '<div>' . $stream[$i]['count'] . '</div></div>';

                echo '</div></a>';
            }
            
            ?>
        </div>
    </div>
</div>
