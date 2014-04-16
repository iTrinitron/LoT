<?php

//Include the initialize
require 'core/init.php';

//Parse the Commandsr
switch($_POST['command']) {
  case 'findUser':
    findUser();
    break;
	case 'editByID':
		editByID();
		break;
}

/*
 * 
 */
function findUser() {
  //Flag to tell us whether we have found users
  $foundUsers = false;
  $type;
  $results;
  //Reference to the global admin object
  global $admin;
  
  //Check by Name
  if(isset($_POST['name'])) {
    if($results = $admin->findUserBy("name", $_POST['name'])) {
      $foundUsers = true;
      $type = "name";
    }
  }
	//Check by Summoner
  if(!$foundUsers && isset($_POST['summoner'])) {
    if($results = $admin->findUserBy("summoner", $_POST['summoner'])) {
      $foundUsers = true;
      $type = "summoner";
    }
  }
  //Check by Email
  if(!$foundUsers && isset($_POST['email'])) {
    if($results = $admin->findUserBy("email", $_POST['email'])) {
      $foundUsers = true;
      $type = "email";
    }
  }
  //Check by Secret ID
  if(!$foundUsers && isset($_POST['secretID'])) {
    if($results = $admin->findUserBy("secret_id", $_POST['secretID'])) {
      $foundUsers = true;
      $type = "secretID";
    }
  }
  
  //None Found
  if(!$foundUsers) {
    echo "No Users Found.";
  }
  else {
    
    echo "Found Users By: {$type} <br/>";
    echo "<table border='1px'> 
            <tr><td>ID</td><td>Email</td><td>Name</td><td>Summoner</td><td>Secret_ID</td><td>TESPA Member?</td><td>Email Authorized?</td><td></td></tr>";
    foreach($results as $foundUser) {
      echo "<tr class='adminRow'>";
      foreach($foundUser as $userAttr) {
        echo "<td>{$userAttr}</td>";
      }
			//
			$name = "'" . $foundUser[2] . "'";
			$tespa = $foundUser[5];
			$email = $foundUser[6];
			echo '<td><button onclick="editUserById(' . $foundUser[0] . ',' .  $name . ',' . $tespa . ',' . $email . ')">Edit</button></td>';
      echo "</tr>";
    }
  }
}

/*
 * 
 */
function editByID() {
	global $general, $admin, $users;
	$messageLog = "";
	
	if(!isset($_POST['id']) || !isset($_POST['reason']) || !isset($_POST['amount'])) {
		$messageLog = "A field was not properly set. No command passed.";
	}
	else {
		$id = $_POST['id'];
		if(!$general->user_exists_by_id($id)) {
			$messageLog = "The user you are trying to edit does not exist.";
		}
		else {
			$amount = $_POST['amount'];
			$reason = $_POST['reason'];
			
			if($amount > 0) {
				$admin->addTransactionToID($id, $amount, $reason);
				$messageLog = $messageLog . "<br/>Added " . $amount . " to the user's Triton Point balance";
			}
			
			//Checkboxes either don't send or send the data...resulting in this if..else
			//
			//Check if TeSPA is true -- give TeSPA membership
			$messageLog = $messageLog . "<br/>Set to user's TeSPA to ";
			if(isset($_POST['tespa'])) {
				$users->editTESPA($id, 1);
				$messageLog = $messageLog . "1.";
			}
			else {
				$users->editTESPA($id, 0);
				$messageLog = $messageLog . "0.";
			}
			
			if(isset($_POST['authorized'])) {
					$users->activateMan($id);
					$messageLog = $messageLog . "<br/>Activated the user's account.";
				
			}
		}
	}
	
	echo $messageLog;
}

//$admin->addTransactionToID();
?>