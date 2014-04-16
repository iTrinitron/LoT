<?php

//Include the initialize page
require 'core/init.php';

?>

<html>
	<!-- Head -->
	<head>
		<!-- Allow for weird characters to display correctly -->
		<meta charset="UTF-8">

		<meta name="keywords" content="League of Legends, League, LoL, LoT, League of Tritons, UCSD">
		<meta name="description" content="League of Legends at UC San Diego">
		<meta name="author" content="Michael Chin">

		<!-- Title of Website -->
		<title><?php echo $page->title; ?></title>

		<!-- Force Favicon Refresh -->
		<link rel="shortcut icon" href="favicon.ico" />
		<!-- Main Stylesheet -->
		<link rel="stylesheet" type="text/css" href="css/index.css" >
		<link rel="stylesheet" href="css/jquery-ui-1.10.3.custom.css" /

		<!-- JQuery -->
		<script src="js/jquery-1.9.1.js"></script>
		<!--<script src="js/jquery-ui-1.10.3.custom.js"></script>-->
		<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>-->
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<!-- Import Form-Handling JS -->
		<script src="js/form.js"></script>
		<script src="js/form_plugin.js"></script>
	<!-- Format TextArea -->
	<script src="libraries/ckeditor/ckeditor.js"></script>



<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45568944-1', 'leagueoftritons.org');
  ga('send', 'pageview');

</script>
	</head>
    
    <!-- Body -->
    <body>
       <!-- Login -->
        <div id="top_bar">
            <div id="content">
                <div id="title">
									<?php
                    if($general->logged_in()) {
											echo 'Welcome <a href="?page=account&user=' . $user['id'] . '"><u>' . $user['summoner'] . '</u></a>!';
                    }
                    else {
                      echo '<a href="?page=home">League of Tritons</a>';
                    }	
                    ?>
                    - <span style="color: red;">BETA</span>
                </div>
				
                <div id="sponsor">
                    <a href="http://tespa.org/"><img id="tespa" src="css/img/tespa.png"/></a>
                </div>
                <div id="belowTop_bar">
				  
				  <?php
                    if(!$general->logged_in()) {
                        echo '<a href="?page=login"><div class="login">login</div></a>';
						echo '<a href="?page=register"><div class="login">signup</div></a>';
                    }
                    else {
                        if($user['access'] > 900) {
                            echo '<a href="?page=admin"><div class="login">admin</div></a>';
                        }
                        echo '<a href="?page=account"><div class="login">account</div></a> <span id="logout"><div class="login">logout</div></span>';
                    }
                    ?>
                </div>
            </div> <!-- content -->
        </div> <!-- top_bar -->
        
        <!-- Wrapper -->
        <div id="wrapper">
            <!-- Container -->
            <div id="container">
                <!-- Header -->
                <?php include('header.php'); ?>
                
                <!-- Main Content -->
                <div id="content">

                    <?php include('pages/' . $page->page . '.php'); ?>

                    <div class="clear"></div>
                </div> <!-- content -->
                
                <div id="footer">
                    <a href="http://michaelrchin.com/">Michael Chin</a> &copy; 2013
                </div>
            </div> <!-- container -->
        </div> <!-- wrapper -->
        
        <?php
        
        /* Benchmark */
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $finish = $time;
        $total_time = round(($finish - $startTime), 4);
        
        ?>
        
            <?php 
            if ($general->logged_in() === true) {
            if($user['access'] > 900) {echo '<div class="box">Benchmark: Page generated in '.$total_time.' seconds. </div>';} 
            }
            ?>

    </body>
</html>