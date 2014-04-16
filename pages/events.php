<?php

//Grab All Events
$query = $db->prepare("SELECT * FROM events WHERE date BETWEEN '2013-12-14 18:30:00' AND '2014-03-01 00:00:00' ORDER BY date");
try{
    $query->execute();

    }catch(PDOException $e){
    die($e->getMessage());
}	

?>

<div class="box">
    <div class="box_title" style="margin-bottom: 15px;">Winter Quarter (2014)</div>
    <?php
    
    while($event = $query->fetch()) {
        //If the location is an event..link to the facebook
        if(filter_var($event['link'], FILTER_VALIDATE_URL)) {
            $event_link = '<a href="' . $event['link'] . '">';
        }
        //If the location is a tournament..link to the tournament page
        else {
            $event_link = '<a href="?page=t_index&tid=' . $event['link'] . '">';
        }
        
        echo $event_link . '<div class="event">';
        echo '<div class="event_date">' . date("F jS", strtotime($event['date'])) . '</div>';
        echo '<div class="event_title">' . $event['title'] . '</div>';
        echo '<div class="event_img"><img src="css/img/event/' . $event['img'] . '"/></div>';
        echo '</div></a>';
    }
    
    ?>
    
    <div class="clear"></div>
</div>

<?php

//Grab All Events
$query = $db->prepare("SELECT * FROM events WHERE date BETWEEN '2013-08-14 18:30:00' AND '2013-12-14 00:00:00' ORDER BY date");
try{
    $query->execute();

    }catch(PDOException $e){
    die($e->getMessage());
}	

?>

<div class="box">
    <div class="box_title" style="margin-bottom: 15px;">Fall Quarter (2013)</div>
    <?php
    
    while($event = $query->fetch()) {
        //If the location is an event..link to the facebook
        if(filter_var($event['link'], FILTER_VALIDATE_URL)) {
            $event_link = '<a href="' . $event['link'] . '">';
        }
        //If the location is a tournament..link to the tournament page
        else {
            $event_link = '<a href="?page=t_index&tid=' . $event['link'] . '">';
        }
        
        echo $event_link . '<div class="event">';
        echo '<div class="event_date">' . date("F jS", strtotime($event['date'])) . '</div>';
        echo '<div class="event_title">' . $event['title'] . '</div>';
        echo '<div class="event_img"><img src="css/img/event/' . $event['img'] . '"/></div>';
        echo '</div></a>';
    }
    
    ?>
    
    <div class="clear"></div>
</div>