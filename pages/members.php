<?php
  /*
   * Page: members.php
   * Author(s): Michael Chin
   * Description: Displays the member list
   */

  //Figure out what page we are on...default to 1
  if(!(isset($_GET['pgNum']))) 
    $pgNum = 1;
  else
    $pgNum = $_GET['pgNum'];
  
  //Number of Members
  $rows = $users->getNumMembers();
  //This is the number of results displayed per page 
  $rowsPerPage = 50; 
  //This tells us the page number of our last page 
  $last = ceil($rows/$rowsPerPage); 
  
  //Don't let the page number break the bounds
  if ($pgNum < 1) 
    $pgNum = 1; 
  elseif ($pgNum > $last) 
    $pgNum = $last; 
  
  $memberInfo = $users->getMembers($rowsPerPage*($pgNum-1));
?>

<!-- Pagination Box -->
<div class="box">
  <div id="pagination">
    <?php
      if($pgNum != 1) {
        echo " <a href='{$page->pageURL}&pgNum=1'>First</a> ";
        echo " ";
        $previous = $pgNum-1;
        echo " <a href='{$page->pageURL}&pgNum=$previous'> | Previous</a>";       
      }
			echo "<span style='font-size: 10px; color: gray;'> [Page {$pgNum}] </span>";
      //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
      if ($pgNum != $last) {
        $next = $pgNum+1;
        echo " <a href='{$page->pageURL}&pgNum=$next'>Next | </a> ";
        echo " ";
        echo " <a href='{$page->pageURL}&pgNum=$last'>Last</a> ";   
      } 
    ?>
  </div>
</div>

<!-- Member List -->
<div class="box">
  <div id="member">
    <div id="member_headers">
      <div class="name">Name</div>
      <div class="summoner">Summoner</div>
      <div class="college">College</div>
    </div>    
    <?php 
      for($i = 0; $i < count($memberInfo); ++$i) {
        $name = $memberInfo[$i]["name"];
				$summoner = $memberInfo[$i]["summoner"];
				$college = $memberInfo[$i]["college"];
		  
        echo '<div class="member">';
        echo '  <div class="name">' . $name . '</div>';
        echo '  <div class="summoner">' . $summoner . '</div>';
        echo '  <div class="college">' . $college . '</div>';
        echo '</div>';
     }
        
   ?>
 </div>
</div>