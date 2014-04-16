<?php

//Stop
require("pages/issue.php");

//Import the tournament classse
require('classes/store.php');

/*
 * Author(s): Michael Chin
 * File: store.php
 * Description: Page that allows users to navigate through a list of products available for
 *              purchase.
 */
$store = new Store($db);
$products = $store->getAllProducts();
?>

<div id="store">
  <div class="box">
    <div id="wallet">
      <div class="title">Current Balance</div>
	   3256 TP
    </div>
	<div id="purchase_history">
	  View Purchase History
	</div>
	<div id="product_list">
	  <?php
	  
	  for($i=0; $i<5; ++$i) {
	    echo '<div class="product">';
		  echo '<div class="product_wrap"><img class="product_img" src="css/img/rp.jpg"/></div>';
		  echo '<div class="title">RP Card</div>';
		  echo '<div class="price">1000</div>';
	    echo '</div>';
      }
	  ?>
	  <div class="clear"></div>
	</div>
  </div>
</div>