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

//Current URL of this page
$currURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] . "?page=admin";

?>

	<div id="admin">
  <div class="box">
      Welcome to the admin page.  Change this to use JQuery and AJAX to prevent refresh errors.
  </div>

	<!-- Admin: FindUser -->
  <div class="box">
    <div class="title">Find User By</div>
    <div class="clear"></div>
    <div class="command">
      <form class="adminPanel_form">
          Name<br/>
          <input type="text" name="name"/><br/>
          Summoner<br/>
          <input type="text" name="summoner"/><br/>
					Email<br/>
          <input type="text" name="email"/><br/>
          Secret ID<br/>
          <input type="text" name="secretID"/><br/>
          <input type="hidden" name="command" value="findUser"/>
        <input type="submit"/>
      </form>
    </div>
    <div class="description">
	  This command will list out all users that match the above input...Max of 10 users
    </div>
  </div>
  
  <div class="box" id="responseBox">
<?php



//Call the activate function on the email passed in
if(isset($_POST['email'])) {
  $email = $_POST['email'];
  
  if(isset($_POST['command'])) {
    $command = $_POST['command'];
    
    switch($_POST['command']) {
      case 'giveTESPA':
          $users->giveTESPA($email);
          break;
      case 'authorizeEmail':
          $users->activateMan($email);
          break;
    }
  }
}

?>
  </div>
	
	<!--
  <div class="box">
    <div class="title">Store Administration</div>
    
    <a href="<?php echo $currURL; ?>">Link</a>
  </div>

  <div class="box">
    <div class="title">Give Mass Triton Points</div>
    <div class="clear"></div>
    <div class="command">
      <form action="<?php echo $currURL; ?>" method="post">
          Amount<br/>
          <input type="number" name="amount" min="1" max="100"/><br/>
          Email(s)<br/>
          <textarea name="emails"></textarea><br/>
        <input type="hidden" name="command" value="giveTESPA"/>
        <input type="submit"/>
      </form>
    </div>
    <div class="description">
	  This command will give Triton points to all emails listed in the text box and delimit with a '/' (period).<br/>
          Example: [mrchin@ucsd.edu/kehe@ucsd.edu]
    </div>
  </div>

  -->
</div>

<div id="dialog-modal" style="display: none;">
    <p></p>
</div>
<div id="editUser-modal" style="display: none;">
	<form class="adminPanel_form">
		Name: <span id="editUser-name"></span><br/><br/>
		
		<b>Edit Flags</b><br/>
		TeSPA: <input type="checkbox" name="tespa" id="editUser-tespa"/>
		Authorized: <input type="checkbox" name="authorized" id="editUser-email"/>
		<hr/>
		
		<b>Add Triton Points</b><br/>
		Reason<br/>
		<select name="reason">
			<option value="Summer ARAM">Summer ARAM</option>
			<option value="S3 Viewing Party">S3 Viewing Party</option>
			<option value="10/11 ARAM">10/11 ARAM</option>
			<option value="10/26 ARAM">10/26 ARAM</option>
			<option value="11/15 ARAM">11/15 ARAM</option>
			<option value="WGF 2014">WGF 2014</option>
			<option value="2/21 Hexakill">2/21 Hexakill</option>
<option value="2/28 ARAM">2/28 ARAM</option>
		</select>
		<br/>
		Amount<br/>
		<input type="number" name="amount" min="1" max="100"/><br/>
		<hr/>
		
		<input type="hidden" id="editUser-id" name="id" value=""/>
		<input type="hidden" name="command" value="editByID"/>
		<input type="submit"/>
	</form>
</div>