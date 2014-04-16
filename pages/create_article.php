<?php

/*
 * File: createArticle.php
 * Author(s): Michael Chin, Sam Ko
 * Descrption: This file allows an administrator to create an article.
 */
echo "HELO";

//Validate the user
if($user['access'] < 300) {
  echo 'No access';
  exit();
}

//Current URL of this page
$currURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] . "?page=" . $current_page;

//Check if an article has been submitted
if(isset($_POST['title'])) {
  //Pull the information from the action
  $title = $_POST['title'];
  $author = $user['name'];
  $content = $_POST['content'];
  $visibility = 0;
  $featured = 0;
  echo "hi";
  $article = new Article($db);
  
  echo $article->createArticle($title, $author, $content, $visibility, $featured);
  echo "hi";
}
?>

<div class="box">
  <form action="<?php echo $currURL; ?>" method="post">
   Title
   <input type="text" name="title"/>
   <textarea class="ckeditor" name="content"></textarea>
   <input type="submit"/>
  </form>
</div>