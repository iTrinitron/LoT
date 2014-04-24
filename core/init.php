<?php 

#starting the users session
session_start();

//Blog needs this?
ob_start();

require 'db/database.php';
require 'classes/users.php';
require 'classes/general.php';
require 'classes/article.php';
require 'classes/admin.php';
require 'classes/page.php';

//Power necessary to be an Admin
$ADMIN_POWER = 300;
$DEFAULT_PAGE = "home";

$database = new Database();							//Create Database
$db = $database->open_db_connection();	//Connect to the Database

$users 		= new Users($db);
$general 	= new General($db);
$page			= new LoT_Page($DEFAULT_PAGE);
 
if ($general->logged_in() === true)  { // check if the user is logged in
  $user_id = $_SESSION['id']; // getting user's id from the session.
  $users->user_id = $user_id;
  $user = $users->userdata($user_id); // getting all the data about the logged in user.

  //Decide whether or not to create an admin object
  if($user['access'] >= $ADMIN_POWER) {
    $admin  = new Admin($user_id, $db);
  }
}


$errors 	= array();

/* ------------------------------------------------- */
/* THIS CODE DEALS WITH PAGE NAVIGATION AND SECURITY */

//Parse the GET vraiables
if(isset($_GET['page'])) {
	$current_page = $_GET['page'];
	$page->setPage($current_page);
}

/* BENCHMARK */
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$startTime = $time;

$colleges = array(
	"None",
	"Muir",
	"Warren",
	"Revelle",
	"Sixth",
	"Marshall",
	"ERC",
	"UCLA"
);


?>
