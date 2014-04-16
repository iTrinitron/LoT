<?php 
class General{
	private $db;
	
	public function __construct($database) {
    $this->db = $database;
  }
	
  #Check if the user is logged in.
  public function logged_in() {
    return(isset($_SESSION['id'])) ? true : false;
  }
  
	/*
	 * Name: get_all_articles()
	 * Author: Michael Chin
	 * Date: 2/1/2014
	 * Description: Accesses the database and pulls all of the articles.
	 *	Returns the information of all the articles in a 2D array.
	 */
	public function get_all_articles($max_articles) {
		$query = $this->db->prepare("SELECT title, author, content, created_at, img FROM `articles` WHERE featured != 1 ORDER BY id DESC LIMIT $max_articles");
    $query->bindValue(1, $max_articles);
    try{
			$query->execute();
		} 
		catch (PDOException $e){
      die($e->getMessage());
		}
		
		//Arrayize the results so they can be used
		$articles;
		for($i=0; $result=$query->fetch(PDO::FETCH_ASSOC); ++$i) {
			$articles[$i] = $result;
		}
		
		return $articles;
	}
	
	public function get_featured_article() {
		$query = $this->db->prepare("SELECT title, author, content, created_at, img FROM `articles` WHERE featured = 1");
		try{
			$query->execute();
		} 
		catch (PDOException $e){
      die($e->getMessage());
		}
		
		return $query->fetch(PDO::FETCH_ASSOC);
	}
	
	/*
	 * Checks to see if a user exists with the ID passed
	 */
	public function user_exists_by_id($id) {
		$query = $this->db->prepare("SELECT id FROM `users` WHERE `id`= ?");
    $query->bindValue(1, $id);

    try {
      $query->execute();
      $rows = $query->fetchColumn();
			
      if($rows){
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
	
	/*
	 * Cuts off a string at a maxLength, and adds ellipses
	 */
	public function summarize($text, $maxChar) {
		//Cannot summarize any further...
		if(strlen($text) < $maxChar) {
			return $text;
		}
		
		//Cut
		$summary = substr($text, 0, $maxChar);
		//If the last char is a space. Remove it!
		$summary = trim($summary);
		//Add Ellipses
		$summary = $summary . "...";
		return $summary;
	}
}

?>