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