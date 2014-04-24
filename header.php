<?php 

//The links on the navbar
$pages = array("home", "members", "store", "pictures", "compete", "about");

?>

<!-- Top Bar -->
<div id="header">
    <!-- Site Logo -->
    <a href="?page=home">
        <div id="logo" style="line-height: 109px;">
            <img src="css/img/logo.png"/>
        </div>
    </a>

    <!-- Navbar -->
    <div id="right">
        <div id="bottom">
            <div id="navbar">
                <?php
                //Create the navbar
                foreach($pages as $i) {
				  if($i == "compete") {
				    $fireUrl = "'fire.png'";
				    echo '<a href="?page=' . $i . '"><div class="link" style="color: #F58B0D;">' . $i . '</div></a>';
				  }
				  else {
                    echo '<a href="?page=' . $i . '"><div class="link">' . $i . '</div></a>';
			      }
                }
                ?>
            </div>
            <!-- FB Logo -->
            <div id="icon">
                <!--<a href="https://www.facebook.com/groups/LeagueOfTritons/" target="blank"><img src="css/img/fb_icon.png"/></a>-->
            </div>
        </div>
    </div> <!-- right -->
</div> <!-- header -->