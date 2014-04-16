<?php

Class Admin {
  private $user_id;
  private $db;
    
  public function __construct($user_id, $database) {
    $this->db = $database;
    $this->user_id = $user_id;
  }

  /*
   * Function Name: FindUserBy()
   * Date: 1/27/2014
   * 
   * Description: Takes in a column to search by, and the value to wildcard by. Returns an array 
   *  containing all users similar to the passed in RealName.
   * 
   * Operations:
   * --Max of 10 Users
   * --Returns false if no array was found
   * --Returns false if no value was passed
   * --Dies if the SQL messes up
   */
  public function findUserBy($type, $value) {
    //Stop empty parameters
    if($value == "") {
      return false;
    }
    
    $MAX_RESULTS = 10; //Max number of results to return
    $foundUsers = array();
    $value = "%{$value}%"; //Add wildcards
    
    //SQL
    $query = $this->db->prepare("SELECT id, email, name, summoner, secret_id, tespa, authorized FROM `users` WHERE `$type` LIKE ? LIMIT ?");
    $query->bindValue(1, $value);
    $query->bindValue(2, $MAX_RESULTS, PDO::PARAM_INT);
    
    //Query the SQL
    try {
      $query->execute();
    } 
    catch (PDOException $e){
      die($e->getMessage());
    }
    
    //Place the Results into an Array
    for($i=0; $result = $query->fetch(); ++$i) {
      //Divide by two because SQL returns two rows per column [0] = email, [email] = email
      for($j = 0; $j < count($result)/2; ++$j) {
        $foundUsers[$i][$j] = $result[$j];
      }
    }
    
    //Do not return an empty Array
    if(count($foundUsers) <= 0) {
      return false;
    }
    
    //Return the Array
    return $foundUsers;
  }
  
   /*
   * Function Name: FindExactUserBy()
   * Date: 3/6/2014
   * 
   * Description: Takes in a column to search by, and the value to search by. Returns an array 
   *  containing all information on one user that matches
   * 
   * Operations:
   * --Max of 1 Users
   * --Returns false if no array was found
   * --Returns false if no value was passed
   * --Dies if the SQL messes up
   */
  public function findExactUserBy($type, $value) {
    //Stop empty parameters
    if($value == "") {
      return false;
    }
    
    //SQL
    $query = $this->db->prepare("SELECT id, email, name, summoner, secret_id, tespa, authorized FROM `users` WHERE `$type` = ?");
    $query->bindValue(1, $value);
    
    //Query the SQL
    try {
      $query->execute();
    } 
    catch (PDOException $e){
      die($e->getMessage());
    }
	
	$userData = $query->fetch();
    
    //Do not return an empty Array
    if(count($userData) <= 0) {
      return false;
    }
    
    //Return the Array
    return $userData;
  }
	
	/*
   * Name: addTP()
   * Author: Sam Ko
   * Date: 1/28/2014
   * Description: Add Triton Points to the transaction list
   *  --Can either be positive or negative $quantity
   *  --
   */
  public function addTransactionToID($id, $quantity, $comment) {
    $query = $this->db->prepare("INSERT INTO transactions (user_id, value, comment, admin) VALUES (?, ?, ?, ?)");
    $query->bindValue(1, $id);
    $query->bindValue(2, $quantity);
    $query->bindValue(3, $comment);
		$query->bindValue(4, $this->user_id);
    try {
      $query->execute();
    }	
    catch(PDOException $e) {
      die($e->getMessage());
    }
    
    return true;
  }
}

?>