<?php

/*
 * Author(s): Michael Chin, Sam Ko
 * File: store.php
 * Description: Class that contains all of the functions that pertain to the Store.
 */
 
class Store {
  private $db;
  public $storeName = "LoT Store";

  /*
   * Internally stores the Database information
   */
  public function __construct($database) {
    $this->db = $database;
  }  
  
  /*
   * Insert a new item into the store with a (Name and Price)
   */
  public function insertNewProduct($name, $price) {
    $query = $this->db->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
	$query->bindValue(1, $name);
	$query->bindValue(2, $price);
	try {
      $query->execute();
    }
    catch(PDOexception $e) {
      die($e->getMessage());
    }
  }
  
  /*
   * Updates the quantity of a product
   */
  public function updateProduct($id, $quantity) {
    $query = $this->db->prepare("UPDATE products(quantity) SET quantity=? WHERE id=?");
	$query->bindValue(1, $quantity);
	$query->bindValue(2, $id);
	try {
      $query->execute();
    }
    catch(PDOexception $e) {
      die($e->getMessage());
    }
    return true;
  }
  
  /*
   * Grabs all of the products and their information from the DB
   */
   public function getAllProducts() {
	$products;
	$query = $this->db->prepare("SELECT id, name, quantity, price FROM products");
	try {
	$query->execute();
	}
	catch(PDOexception $e) {
	  die($e->getMessage());
	}
	while($result = $query->fetch()) {
	$products[$result['id']]['name'] = $result['name'];
	$products[$result['id']]['quantity'] = $result['quantity'];
	$products[$result['id']]['price'] = $result['price'];
     }
	 
	return $products;
   }
}
 
 
 ?>