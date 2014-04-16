<?php

/*
 * File: article.php
 * Author(s): Michael Chin, Sam Ko
 * Description: This class serves as an object for an Article.
 */
class Article {
  private $title;
  private $author;
  private $content;
  private $visibility;
  private $featured;
  private $dateCreated;
  private $dateUpdated;
  
  public function __construct($database) {
    $this->db = $database;
  }
  
  /*
   * Function: createArticle
   * Description: Creates an article based on passed in parameters.  Inserts it into the DB.
   * Parameters:
   *   t - title
   *   a - author
   *   c - content
   *   v - visibility
   *   f - featured
   */
  public function createArticle($t, $a, $c, $v, $f) {
    date_default_timezone_set('PST');
    
    
    $date = date("Y-m-d H:i:s");
    $this->title = $t;
    $this->author = $a;
    $this->content = $c;
    $this->visibility = $v;
    $this->featured = $f;
    $this->dateCreated = $date;

    $query = $this->db->prepare("INSERT INTO articles (title, author, content, created_at, featured, visibility) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bindValue(1, $this->title);
    $query->bindValue(2, $this->author);
    $query->bindValue(3, $this->content);
    $query->bindValue(4, $date);
    $query->bindValue(5, $this->featured);
    $query->bindValue(6, $this->visibility);
    
    try {
      $query->execute();
    }
    catch(PDOException $e) {
      return $e->getMessage();
    }
    
    return "success";
  }
  
  /*
   * Function: getArticle
   * Description: Returns an article's information selected by it's ID
   * Parameters:
   * id - Database unique ID
   */
  public function getArticle($id) {
      $article;
      $query = $this->db->prepare("SELECT title, author, content, created_at, last_updated, featured, visibility FROM articles WHERE id = ?");
      $query->bindValue(1, $id);
      try {
          $query->execute();
      }
      catch(PDOException $e) {
          die($e->getMessage());
      }
      
      $result = $query->fetch();
      $article['author'] = $result['author'];
      $article['content'] = $result['content'];
      $article['date_created'] = $result['date_created'];
      $article['last_updated'] = $result['last_updated'];
      $article['featured'] = $result['featured'];
      $article['visibility'] = $result['visibility'];
      
      return $article;
  }
  
  /*
   * Function: updateArticle
   * Description: Updates an article's information based on it's ID
   * t - title
   * c - content
   * v - visibility
   * f - featured
   * id - Database unique ID
   */
  public function updateArticle($t, $c, $v, $f, $id) {
      $date = date("Y-m-d H:i:s");
      
      $query = $this->db->prepare("UPDATE articles SET title=?, content=?, visibility=?, featured=?, last_updated=? WHERE id=?");

      $query->bindValue(1, $this->title);
      $query->bindValue(2, $this->content);
      $query->bindValue(3, $this->visibility);
      $query->bindValue(4, $this->featured);
      $query->bindValue(5, $date);   
      $query->bindValue(6, $id);
      
      try {
          $query->execute();

          $this->title = $t;
          $this->content = $c;
          $this->visibility = $v;
          $this->featured = $f;
          $this->dateUpdated = $date;
      }
      catch(PDOException $e) {
          die($e->getMessage());
      }
      
      return true;          
             
  }
  public function deleteArticle($id) {
    $query = $this->db->prepare("DELETE FROM articles WHERE id=?");

    $query->bindValue(1, $id);

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






