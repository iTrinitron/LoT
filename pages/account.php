<?php 

//Default Page
$account_page = "settings";
//Figure out what account tab we are on
if(isset($_GET['account'])) {
	//Set and tack on the .php
	$account_page = $_GET['account'];
}

//List of pages on the navbar --> [File_name][Title to display]
$account_pages = array (
	array("settings", "Account Settings"),
	array("triton_points", "Triton Points")	
);

?>

<div id="account">
	<!-- Secret ID -->
	<div class="box">
			<div id="secret_id">
				<div class="box_center_title">Secret ID</div>
				<?php echo $user['secret_id']; ?>
			</div>
	</div>
	
	<!-- Profile Navbar -->
	<div id="navbar">
		<?php
			//Print out all of the nav links
			foreach($account_pages as $link) {
				echo "<a href='{$page->pageURL}&account={$link[0]}'><div class='link'>{$link[1]}</div></a>";
				if($link[0] == $account_page) {
					$page_title = $link[1];
				}
			}
		?>
	</div>

	<!-- Content -->
	<div class="box">
		<div id="account_title"><?php echo $page_title; ?></div>
		<?php include("account_pages/" . $account_page . ".php");?>
	</div>
</div>

	<!-- Pop-up Box -->
	<div id="dialog-modal" style="display: none;">
			<p></p>
	</div>