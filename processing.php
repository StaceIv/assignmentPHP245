<?php

/*
    1 - Make sure everything is filled out.
    2 - Valid phone number input.
    3 - valid email, URL, and IP
        use PHP filter_var
    4 - At least 2 preferred comm
        methods should be checked off.
    5 - Only M.Word or PDF can be uploaded.
    6 - Max filesize is 2 megabytes.
    7 - Display what the errors are. 
        invalid phone, email, name, etc...
*/


/*Check if fields are empty or not.*/
    
    $nameErr = $phoneErr = $addressErr = $emailErr = $webURLErr = $webIPErr = $genderErr = ""; 
    $name = $phone = $address = $email = $webURL = $webIP = $gender = "";    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["fullName"])) {
            $nameErr = "Name is required";
        } else {
            $name = test_input($_POST["fullName"]);
            if(!preg_match("/^[a-zA-Z'-]+$/",$name)) { die ("Invalid Name.");}
        }

        if (empty($_POST["address"])) {
            $addressErr = "An address is required";
        } else {
            $address = test_input($_POST["address"]);
        }

        if (empty($_POST["phone"])) {
            $phoneErr = "A phone number is required";
        } else {
            $phone = test_input($_POST["phone"]);
            if(!preg_match("/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i",$phone)) { die ("Invalid Phone Number.");}
        }

    /*    if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
        }*/

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $email = test_input($_POST["email"]);
        } else {
            $emailErr = "Invalid email address";
        }

        if (empty($_POST["webURL"])) {
            $webURLErr = "A website URL is required";
        } else {
            $webURL = test_input($_POST["webURL"]);
        }

        if (empty($_POST["webIP"])) {
            $webIPErr = "An IP address is required";
        } else {
            $webIP = test_input($_POST["webIP"]);
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

 //   public function printResults(){
        
        echo "<h2>Your Input:</h2>";
        echo "Full Name: ";
        echo $name;
        echo "<br>";

        echo "Address: ";
        echo $address;
        echo "<br>";

        echo "Phone Number: ";
        echo $phone;
        echo "<br>";

        echo "Email: ";
        echo $email;
        echo "<br>";

        echo "Gender: ";
        echo $gender;
        echo "<br>";

        echo "Website URL: ";
        echo $webURL;
        echo "<br>";

        echo "Website IP Address: ";
        echo $webIP;
        echo "<br>";

        echo "Preferred Communication: ";
        echo $comm;
        echo "<br>";

//    }
     
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        
    </body>
</html>
