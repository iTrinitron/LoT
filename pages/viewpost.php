<?php

$stmt = $db->prepare('SELECT postID, postTitle, postAuthor, postImg, postCont, postDate FROM blog_posts WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['postID'] == ''){
	header('Location: ./');
	exit;
}

?>

<div class="box">
	<div id="article">
		<div id="article_title"><?php echo $row['postTitle']; ?></div>
		<div id="article_info"><?php echo "{$row['postAuthor']} at " . date('jS M Y', strtotime($row['postDate'])); ?></div>
		<div id="article_img"><img src="css/img/article_img/<?php echo $row['postImg']; ?>"/></div>
		<div id="article_content">
				<?php echo '<p>'.$row['postCont'].'</p>'; ?>				
		</div>
	</div>
</div>
