<?php

/* MAKE A FAIL SAFE COMMAND AT THE BOTTOM */

/*
 * File Name: admin.php
 * Authors: Michael Chin, Sam Ko
 * Description: This file parses and contains all of the commands that can be executed by an administrator.
 */
 
//Only allow Admins on the page
if($user['access'] < 300) {
    echo 'No access';
    exit();
}

//Default Page
$admin_page = "find_user";
//Figure out what account tab we are on
if(isset($_GET['admin'])) {
	//Set and tack on the .php
	$admin_page = $_GET['admin'];
}

//Current URL of this page
$currURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] . "?page=admin";

?>

	<div id="admin">
  <div class="box">
      Welcome to the admin page.  Change this to use JQuery and AJAX to prevent refresh errors.
  </div>
		
		<!-- Profile Navbar -->
		<div id="account"">
	<div id="navbar">
		<?php
			echo "<a href='{$page->pageURL}&admin=find_user'><div class='link'>Users</div></a>";
			echo "<a href='{$page->pageURL}&admin=blog'><div class='link'>Blog</div></a>";
		?>
		
	</div>
	</div>
		
	<?php
	
	include("pages/admin_pages/{$admin_page}.php");
	
	?>

	</div>