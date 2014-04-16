<?php 

//Code used to bypass UCSD email only
$promo_code = "urg0t";
$acceptedDomains = array(
  "ucsd.edu",
  "ucla.edu"
);

require 'core/init.php';

if(empty($_POST['password']) || empty($_POST['email'])){
        $errors[] = 'All fields are required.';
}
else {
    if(strpos($_POST['email'],'@') == false) {
        $errors[] = 'No email address specified';
    }
    else {
        list($etc, $domain) = explode('@', $_POST['email']);
        if(!in_array($domain, $acceptedDomains) && $_POST['promo'] != $promo_code) {
            $errors[] = 'Your email address is not currently accepted.  Please refer to the "Accepted Domains".';
        }
        #validating user's input with functions that we will create next
        else if (strlen($_POST['password']) < 6){
            $errors[] = 'Your password must be at least 6 characters';
        } 
        else if (strlen($_POST['password']) > 18){
            $errors[] = 'Your password cannot be more than 18 characters long';
        }
        else if ($users->email_exists($_POST['email']) === true) {
            $errors[] = 'That email already exists.';
        }
        if(empty($errors) === true){
            $password 	= $_POST['password'];
            $verify_password = $_POST['verify_password'];
            $email 		= strtolower(htmlentities($_POST['email']));
            $summoner       = $_POST['summoner'];
            $name           = $_POST['name'];

            if($password != $verify_password) {
                echo "Passwords do not match";
                exit();
            }

            $users->register($email, $password, $summoner, $name);// Calling the register function, which we will create soon.
            echo true;
        }
    }
}

if(empty($errors) === false){
        echo implode('</p><p>', $errors);
}
?>