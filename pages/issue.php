<?php

/*
 * Name: issue.php
 * Author: Michael Chin
 * Date: 12/20/2013
 * Description: Protects unfinished pages from being displayed to the public.
 */

$isDev = false;

if(!$isDev) {
  echo '<div class="box" style="text-align: center;">
         <img height="600px" src="css/img/pagenotready.jpg"/>
       </div>';
  exit();
}
else {
  echo 'This is a dev page';
}

?>