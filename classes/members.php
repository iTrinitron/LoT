<?php
  $pgNum = $_GET['pg'];
  
  if (!(isset($pgNum))) { 
      $pgNum = 1;
  }
  
  $rows = $users->getNumMembers();
   
  //This is the number of results displayed per page 
  $page_rows = 4; 

  //This tells us the page number of our last page 
  $last = ceil($rows/$page_rows); 
  
  if ($pagenum < 1) { 
    $pgNum = 1; 
  } 
  elseif ($pagenum > $last) { 
    $pgNum = $last; 
  } 
  
  $memberInfo = $users->getMembers(50*($pgNum-1));
?>

<div class="box">
    <div id="search"></div>
    <div id="member">
        <div id="member_headers">
            <div class="name">Name</div>
            <div class="summoner">Summoner</div>
            <div class="college">College</div>
            <div class="points">Points</div>
        </div>
        
        <?php 
        for($i = 0; $i < count($memberInfo); ++$i) {
		  $name = $memberInfo[$i]["name"];
		  $summoner = $memberInfo[$i]["summoner"];
		  $college = $memberInfo[$i]["college"];
		  
            echo '<div class="member">';
                echo '<div class="name">' . $name . '</div>';
                echo '<div class="summoner">' . $summoner . '</div>';
                echo '<div class="college">' . $college . '</div>';
                echo '<div class="points">-</div>';
            echo '</div>';
        }
        
        echo '<a href="' . $CURRENT_URL . '&pg=2">hello</a>';
        echo $pgNum;
        
        if($pgNum != 1) {
            echo " <a href='{$CURRENT_URL}?pagenum=1'> <<-First</a> ";

 echo " ";

 $previous = $pgNum-1;

 echo " <a href='{$CURRENT_URL}&pagenum=$previous'> <-Previous</a> ";

 } 
 
        
        ?>
        
        <div id="pagination">
            <span>1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
        </div>
    </div>
</div>