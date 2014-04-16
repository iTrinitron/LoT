<?php

//Only allow Admins on the page
if($user['access'] < 300) {
    echo 'No access';
    exit();
}

//Check if a command was called



//create seeds
//$tournamentObj->createGroupStage();


//$tournamentObj->endGroupStage();
$tournamentObj->createBracket();
?>

<div class="box">
    <?php
    
    //----------------------------Status: NOT STARTED------------------------------------
    if($tournament['status'] == 0) {
        echo ' <div id="create_bracket" class="' . $t_id . '">Create Bracket</div>';
    }
    
    //If the tournament has started
    else if($tournament['status'] == 1) {
        //Print out all of the matches
        echo '<div class="match">';
        echo '<div>';
        echo '<div class="team1">Team1</div>';
        echo '<div class="score1">Score1</div>';
        echo '<div id="winner">Winner</div>';
        echo '</div>';  
            
        echo '<div>';
        echo '<div class="team2">Team2</div>';
        echo '<div class="score2">Score2</div>';
        echo '<div id="update">Update</div>';
        echo '</div>
        </div>';
    }
    else {
        //$tournamentObj->endTournament();
    }
    ?>
</div>