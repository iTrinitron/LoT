<?php 

class Users{
  private $db;
  public $user_id;

  public function __construct($database) {
    $this->db = $database;
  }

  public function email_exists($email) {
    $query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `email`= ?");
    $query->bindValue(1, $email);

    try {
      $query->execute();
      $rows = $query->fetchColumn();

      if($rows == 1){
        return true;
      }
      else{
        return false;
      }
    } 
    catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  public function email_confirmed($email) {

          $query = $this->db->prepare("SELECT authorized FROM `users` WHERE `email`= ?");
          $query->bindValue(1, $email);

          try{

                  $query->execute();
                  $rows = $query->fetchColumn();

                  if($rows == 1){
                          return true;
                  }else{
                          return false;
                  }

          } catch (PDOException $e){
                  die($e->getMessage());
          }

  }

  //This works to my specifications
  public function register($email, $password, $summoner, $name){
          $time 		= time();
          $ip 		= $_SERVER['REMOTE_ADDR'];
          $email_code = sha1($email + microtime());
          $password   = sha1($password);

          //Make a unique secret ID that doesn't exist in the DB that is 7 digits
          do {
              $secret_id = substr(number_format(time() * rand(),0,'',''),0,7);
              $query = $this->db->prepare("SELECT * FROM users WHERE secret_id = $secret_id");
              $query->execute();
              $return = $query->fetch();
          } while(!empty($return));

          $query = $this->db->prepare("INSERT INTO `users` (`email`, `ucsd_email`, `password`, `authorized`, `email_code`, `created_at`, `ip`, `name`, `summoner`, `secret_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");

          $query->bindValue(1, $email);
          $query->bindValue(2, $email);
          $query->bindValue(3, $password);
          $query->bindValue(4, 0);
          $query->bindValue(5, $email_code);
          $query->bindValue(6, $time);
          $query->bindValue(7, $ip);
          $query->bindValue(8, $name);
          $query->bindValue(9, $summoner);
          $query->bindValue(10, $secret_id);

          try{
                  $query->execute();
                  mail($email, 'Please activate your account', "Hello " . $summoner . ",\r\nThank you for registering with us. Please visit the link below so we can activate your account:\r\n\r\nhttp://www.leagueoftritons.org/?page=activate&email=" . $email . "&email_code=" . $email_code . "\r\n\r\n-- League of Tritons", 'From: noreply@leagueoftritons.org');

          }catch(PDOException $e){
                  die($e->getMessage());
          }	
  }

  public function update_profile($id, $name, $summoner, $college, $shirt_size) {
      $query = $this->db->prepare("UPDATE users SET name=?, summoner=?, college=?, shirt_size=? WHERE id=?");
      $query->bindValue(1, $name);
      $query->bindValue(2, $summoner);
      $query->bindValue(3, $college);
      $query->bindValue(4, $shirt_size);
      $query->bindValue(5, $id);

      try{
              $query->execute();

              // mail($email, 'Please activate your account', "Hello " . $username. ",\r\nThank you for registering with us. Please visit the link below so we can activate your account:\r\n\r\nhttp://www.example.com/activate.php?email=" . $email . "&email_code=" . $email_code . "\r\n\r\n-- Example team");
      }catch(PDOException $e){
              die($e->getMessage());
      }
  }

  /* 
   * This function attempts to login a user with an email and password.
   * If the login passes, then the user's id is returned.
   * If the login fails, then false is returned
   */
  public function login($email, $password) {
          $query = $this->db->prepare("SELECT `password`, `id` FROM `users` WHERE `email` = ?");
          $query->bindValue(1, $email);

          try{
                  $query->execute();
                  $data 				= $query->fetch();
                  $stored_password 	= $data['password'];
                  $id 				= $data['id'];

                  #hashing the supplied password and comparing it with the stored hashed password.
                  if($stored_password === sha1($password)){
                          return $id;	
                  }else{
                          return false;	
                  }

          }catch(PDOException $e){
                  die($e->getMessage());
          }
  }

  public function userdata($id) {
		$query = $this->db->prepare("SELECT * FROM `users` WHERE `id`= ?");
		$query->bindValue(1, $id);

		try{

						$query->execute();

						return $query->fetch();

		} catch(PDOException $e){

						die($e->getMessage());
		}
  }

public function activate($email, $email_code) {
    $query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `email` = ? AND `email_code` = ? AND `authorized` = ?");

    $query->bindValue(1, $email);
    $query->bindValue(2, $email_code);
    $query->bindValue(3, 0);

    try{

          $query->execute();
          $rows = $query->fetchColumn();

          if($rows == 1){	
        $query_2 = $this->db->prepare("UPDATE `users` SET `authorized` = ? WHERE `email` = ?");

                          $query_2->bindValue(1, 1);
                          $query_2->bindValue(2, $email);				

                          $query_2->execute();

                          return true;

                  }else{
                          return false;
                  }

          } catch(PDOException $e){
                  die($e->getMessage());
          }
  }
	
  /*
   * Function Name: getMembers()
   */
  public function getMembers($start) {
    //Number of Rows to return
    $numRows = 50;
    $query = $this->db->prepare("SELECT name, summoner, college FROM `users` LIMIT ?, ?");
    $query->bindValue(1, $start, PDO::PARAM_INT);
    $query->bindValue(2, $numRows, PDO::PARAM_INT);
    try {
      $query->execute();
    }
    catch(PDOException $e){
          die($e->getMessage());
   }


    $memberInfo;

		for($i=0; $result = $query->fetch(); ++$i) {
      $memberInfo[$i] = $result;
    }
		
		return $memberInfo;
	}
	
  /*
   * Function Name: activateManual()
   * Authors: Sam Ko, Michael Chin
   * Date: 12/21/2013
   * Description: This function activates an account manually (done by an admin).
   *  It sets their authorized status to 1.
   */
  public function activateMan($id) {
    $query = $this->db->prepare("UPDATE `users` SET `authorized` = 1 WHERE `id` = ?");
    $query->bindValue(1, $id);
    try {
        $query->execute();
    }
    catch(PDOException $e) {
        //print error message
        die($e->getMessage());
    }
    return true; 
  }
  
  /*
   * Function Name: giveTESPA()
   * Authors: Sam Ko, Michael Chin
   * Date: 12/21/2013
   * Description: This function edits the TeSPA membership status of a user
	 *   defined by their email.
   */
  public function editTESPA($id, $state) {
    $query = $this->db->prepare("UPDATE users SET `tespa`=? WHERE `id`=?");
		$query->bindValue(1, $state);
    $query->bindValue(2, $id);

    try {
        $query->execute();
    }
    catch(PDOException $e) {
        //print error message
        die($e->getMessage());
    }
    return true; 
  }
  
  public function getNumMembers() {
      $query = $this->db->prepare("SELECT COUNT(1) FROM `users`");
      $query->execute();
      
      return $query->fetchColumn();
  }
	
	/*
   * Name: addTP()
   * Author: Sam Ko
   * Date: 1/28/2014
   * Description: Add Triton Points to the transaction list
   *  --Can either be positive or negative $quantity
   *  --
   */
  public function addTransaction($quantity, $comment) {
    $query = $this->db->prepare("INSERT INTO transactions (user_id, points, comment) VALUES (?, ?, ?)");
    $query->bindValue(1, $this->user_id);
    $query->bindValue(2, $quantity);
    $query->bindValue(3, $comment);
    try {
      $query->execute();
    }	
    catch(PDOException $e) {
      die($e->getMessage());
    }
    
    return true;
  }
  
  /*
   * Name: deleteTransactionById()
   * Author: Sam Ko
   * Date: 1/28/2014
   * Description: Removes a transaction from the list based on its Id
   *  --
   */
  public function deleteTransactionById($id) {
    $query = $this->db->prepare("DELETE FROM `transactions` WHERE `id`=?");
    $query->bindValue(1, $id);
    try {
      $query->execute();
    }
    catch(PDOExcpetion $e) {
      die($e->getMessage());
    }
    
    return true;
  } 
	
	/*
	 * Name: getAllTransactions()
	 * Author: Michael Chin
	 * Date: 2/21/2014
	 * Description: Return an array of all transactions linked to a user's account
	 */
	public function getAllTransactions($id) {
		$query = $this->db->prepare("SELECT comment, value FROM `transactions` WHERE `user_id`= ?");
		$query->bindValue(1, $id);
		try {
      $query->execute();
    }
    catch(PDOExcpetion $e) {
      die($e->getMessage());
    }
		$transactions;
		
		for($i=0; $result = $query->fetch(); ++$i) {
			$transactions[$i] = $result;
		}
		
		if(empty($transactions)) {
			return false;
		}
		else {
			/* Finish */
			return $transactions;
		}
	}
}



?>