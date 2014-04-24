<?php 

class LoT_Page {
	public $page;
	public $pageURL;
	public $title; 
	
	/*
	 * Sets the default page.
	 */
	public function __construct($page) {
		$this->page = $page;
	}
	
	public function setPage($page) {
		//Create the appropriate file path
    $file_path = "pages/" . strtolower($_GET['page']) . ".php";
		
		//Make sure the page they are accessing exists
    if(file_exists($file_path)) {
			$this->page = $page;
			$this->pageURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?page=$page";
    }
		//ERROR: The page you are looking for does not exist
		else {
			
		}
	}
}

?>