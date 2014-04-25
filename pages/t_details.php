<?php

$status[0] = "<span style='color: green;'>Registration Pending</span>";
$status[1] = "<span style='color: green;'>Registration Open</span>";
$status[2] = "<span style='color: yellow;'>In Progress</span>";
$status[3] = "<span style='color: red;'>Completed</span>";


//Stream object
require 'classes/stream.php';
$stream = new stream("SoKorean");

?>

<div id="thome">
    <!-- Content to the Left -->
    <div id="thome_left">
        <div class="home_box">
            <div class="tborder">
                <div id="t_name"><?php echo $tournament['name']; ?>
                    <div>Starts: <?php echo date("F jS, o", strtotime($tournament['date'])); ?></div> 
                    <div>Status: <?php echo $status[$tournament['status']]; ?></div>
                    <div>Admins: <?php echo $tournament['admins']; ?></div>
                </div>
                <?php echo $tournament['summary']; ?>
            </div>
        </div>
        
        <div class="home_box">
            <div class="tborder">
                <div class="title">Rules</div>
                <?php echo $tournament['rules']; ?>
            </div>
        </div>
        
        <div class="home_box">
            <div class="tborder">
                <div class="title">Prizes</div>
                <?php echo $tournament['prizes']; ?>
            </div>
        </div>
        
        <div class="home_box">
            <div class="tborder">
                <div class="title">Registration</div>
                If you are new to registering for tournaments on the League of Tritons, please follow
                this step by step guide to enter in your team.<br/>
                <br/>
                <b>1. Register an account on League of Tritons.</b><br/><br/>
                <b>2. Authorize your account, and then login.</b><br/><br/>
                <b>3. Locate to your "account" page in the top-right and record your Secret ID.
                    It should be in <font color="yellow">yellow</font>.</b></br><br/>
                    <b><font color="green">Continue if you are the team leader...</font></b><br/>
                <b>4. If you are the team leader, collect all of your player's respective Secret ID's.</b><br/><br/>
                <b>5. Hit the "Register" tab, and enter in your teammate's Secret ID's.</b><br/><br/>
                <b>6. Hit the submit/register button.</b>
            </div>
        </div>
        
        <?php
        
        ?>
    </div>
    <!-- Content to the right -->
    <div id="thome_right">
        <div class="home_box">
            <div class="tborder">
                <?php
                    $stream->render("392", "350");
                ?>
            </div>
        </div>
    </div>

    <div class="clear"></div>
</div>