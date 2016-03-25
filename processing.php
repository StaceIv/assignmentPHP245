<?php
/*
    1 - Make sure everything is filled out. NOT DONE
    2 - Valid phone number input.           
    3 - valid email, URL, and IP            
        use PHP filter_var
    4 - At least 2 preferred comm
        methods should be checked off.
    5 - Only M.Word or PDF can be uploaded.
    6 - Max filesize is 2 megabytes.
    7 - Display what the errors are. 
        invalid phone, email, name, etc...
    PROBLEMS:
        - When submitted blank, it still tries to print input instead
    of giving a red message telling the user they must input required info.
        - How to get file upload for resume?
        - Check if a preferred communication method has been chosen.
            Make sure two are chosen. 
        - When valid email address is entered, it doesn't display when the 
    form is submitted.
        - Email validation doesn't work. Says all emails are invalid.
        - upload resume.
*/

/*Check if fields are empty or not.*/
    
    $nameErr = $phoneErr = $addressErr = $emailErr = $webURLErr = $webIPErr = $genderErr = $resumeFileErr = $commErr = ""; 
    $name = $phone = $address = $email = $webURL = $webIP = $gender = $resumeFile = $comm = "";    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        /*
            VALIDATE NAME. Checks to see if a name was entered. If not
            then it prints a message telling the user they must enter a name.
            It also checks that only alphanumeric characters
            have been enteredd in the name space.
            -----------------------------------------VALIDATION WORKS.
        */
        if (empty($_POST["fullName"])) {
            $nameErr = "Name is required";
        } else {
            $name = test_input($_POST["fullName"]);
            if(!preg_match ("/^[a-zA-Z\s]+$/",$name)) { echo("Invalid Name.");}
        }

        //CHECK ADDRESS
        if (empty($_POST["address"])) {
            $addressErr = "An address is required";
        } else {
            $address = test_input($_POST["address"]);
        }

        /*
            VALIDATE PHONE NUMBER. Checks to see that the field has not been
            left blank. If a number has been enetered, it checks to see
            that the correct format has been used.
            ---------------------VALIDATION WORKS EXCEPT FOR xxx.xxx.xxxx format
        */
        if (empty($_POST["phone"])) {
            $phoneErr = "A phone number is required";
        } else {
            $phone = test_input($_POST["phone"]);
            if(!preg_match("/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i",$phone)) { die ("Invalid Phone Number.");}
        }

        /*
            VALIDATE EMAIL. If an email has been entered, it checks to see
            that the email is valid.
            --------------------------when stacey.ivanovic007@gmail.com is
                                      entered, it said invalid.

            PROBLEM: Email is always invalid.
        
        //If this is empty, error message
        //Else 
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $email = $_POST["email"];
            } else {
                echo("Ivalid email address.");
            }
        }*/

        if(empty($_POST["email"]))
        {
            $emailErr="* Email is Required";
            $valid=false;
        }
        else
        {
            $email=test_input($_POST["email"]);
            if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
            {
                $emailErr="&nbsp;&nbsp; Enter a valid Email ID";
                $valid=false;
            }
        }

        /*
            VALIDATE WEBSITE URL. If a URL has been entered, it checks
            to see that it is valid. Else it will print an error message.

            PROBLEM: URL is always invalid.
        */
        if (empty($_POST["webURL"])) {
            $webURLErr = "A website URL is required";
        } else {
            if (!filter_var($webURL, FILTER_VALIDATE_URL) === false) {
                $webURL = test_input($_POST["webURL"]);
            } else {
                echo("That is not a valid URL");
            }
        }

        /*
            Gets IP address by the website input.
        */
        $webIP = gethostbyname($webURL);

        /*
            Check to see a gender has been selected.
        */
        $gender = $_POST['gender'];  
        if ($gender == "female") {          
            $gender = "Female.";      
        }else if ($gender == "male"){
            $gender = "Male.";
        } else {
            echo("Must select a gender.");
        }
         
        /*
            Check to see that at least two preferred communication 
            methods have been selected.
        */
        //First check to see if anything has been selected.
        //If something has been selected, check to see that 
        //at least two items are selected.
        //Else if nothing has been selected, print that error message.
        if(empty($_POST['comm'])){
                 $commErr = "Must select at least 2 methods of communication.";
        } 

        /*
            The User needs to be able to upload a .pdf or .doc or .docx file

            PROBLEMS:
                - File is not saved to uploads folder when uploaded.
                - Filename doesn't display in return input thing.
        */
        if(isset($_FILES['UploadFileField'])){
            
            $UploadName = $_FILES['UploadFileField']['name'];
            $UploadName = mt_rand(100000, 999999).$UploadName;
            $UploadTmp = $_FILES['UploadFileField']['tmp_name'];
            $UploadType = $_FILES['UploadFileField']['type'];
            $FileSize = $_FILES['UploadFileField']['size'];

            $UploadName = preg_replace("#[^a-z0-9.]#i", "", $UploadName);

            if(($FileSize > 125000)){
                die("Error - File to Big");
            }

            if(!$UploadTmp){
                die("No File Selected, Please Upload Again.");
            } else {
                move_uploaded_file($UploadTmp, "uploads/" . $UploadName);
                echo $UploadName . " has been uploaded.";
            }
        }
    }

    //TEST INPUT
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (empty($phoneErr)) {
     //PRINT INPUT.
        echo $phoneErr ;
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
        //Use a for loop to display all the 
        //communications methods chosen.
        foreach($_POST['comm'] as $check){
                echo $check . "<br>";
        }

        echo "File uploaded: ";
        echo $UploadName;
        echo "<br>";
    }
   /* else
    {
        $html = file_get_html('index.htm');
        echo $html;
    }*/
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