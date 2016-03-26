<?php
/*
    Assignment Two for CIS 245. 
    UFV Winter 2016, Due March 25th, 2016
    Anastasija Ivanovic - 300125976
*/

    $nameErr = $phoneErr = $addressErr = $emailErr = $webURLErr = $webIPErr = $genderErr = $upFileErr = $commErr = ""; 
    $name = $phone = $address = $email = $webURL = $webIP = $gender = $upFile = $comm = "";    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $errors = FALSE;
        /*
            VALIDATE NAME. Checks to see if a name was entered. If not
            then it prints a message telling the user they must enter a name.
            It also checks that only alphanumeric characters
            have been enteredd in the name space.
        */
        if (empty($_POST["fullName"])) {
            $nameErr = "Name is required";
            $errors = TRUE;
        } else {
            $name = test_input($_POST["fullName"]);
            if(!preg_match ("/^[a-zA-Z\s]+$/",$name)) { 
                $nameErr = "Invalid Name";
                $errors = TRUE;
            }
        }

        /*
            VALIDATE ADDRESS. Check that an address has been entered.
        */
        if (empty($_POST["address"])) {
            $addressErr = "An address is required";
            $errors = TRUE;
        } else {
            $address = test_input($_POST["address"]);
        }

        /*
            VALIDATE PHONE NUMBER. Checks to see that the field has not been
            left blank. If a number has been enetered, it checks to see
            that the correct format has been used.
        */
        if (empty($_POST["phone"])) {
            $phoneErr = "A phone number is required";
            $errors = TRUE;
        } else {
            $phone = test_input($_POST["phone"]);
            if(!preg_match("/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i",$phone)) { 
                $phoneErr = "Invalid Phone Number.";
                $errors = TRUE;
            }
        }

        /*
            VALIDATE EMAIL. If an email has been entered, it checks to see
            that the email is valid.
        */
        if(empty($_POST["email"])){
            $emailErr="Email is Required";
            $errors = TRUE;
        } else {
            $email=test_input($_POST["email"]);
            if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)){
                $emailErr="&nbsp; Invalid email.";
                $errors = TRUE;
            }
        }

        /*
            VALIDATE WEBSITE URL. If a URL has been entered, it checks
            to see that it is valid. Else it will print an error message.
        */
        if (empty($_POST["webURL"])) {
            $webURLErr = "A website URL is required";
            $errors = TRUE;
        } else {
            $webURL = test_input($_POST["webURL"]);
        }

        /*
            Gets IP address by the website input.
        */
        $webIP = gethostbyname($webURL);

        /*
            VALIDATE GENDER. Check to see a gender has been selected.
        */
        $gender = $_POST['gender'];  
        if ($gender == "female") {          
            $gender = "Female.";      
        }else if ($gender == "male"){
            $gender = "Male.";
        } else {
            $genderErr = "Must select a gender.";
            $errors = TRUE;
        }
         
        /*
            VALIDATE COMMUNICATION METHOD.
            Check to see that at least two preferred communication 
            methods have been selected.  
        */
        $boxCount = count($_POST["comm"]);
        if($boxCount < 2){
            $commErr = "Must select at least 2 methods of communication.";
            $errors = TRUE;
        } 

        /*
            VALIDATE FILE UPLOAD.
            The User needs to be able to upload a .pdf or .doc or .docx file
        */
        $upFile = $_FILES['file']['name'];
        $size = $_FILES['file']['size'];
        $type = $_FILES['file']['type'];

        $tmp_name = $_FILES['file']['tmp_name'];

        if(isset($upFile)){
            if(!empty($upFile)){

                //Check file type. Only word docs and pdfs accepted.
                if (($_FILES["file"]["type"] == "application/pdf")
                || ($_FILES["file"]["type"] == "application/doc")
                || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")){

                    //Check Size of file. Must be less than 2 megabytes.
                    if($size < 2097152){
                        $location = "uploads/";
                        if(move_uploaded_file($tmp_name, $location.$upFile)){
                            $fileName = $upFile;
                            $uploaded = "Upload Successful";
                        } else {
                            $upFileErr = "Upload Unsuccessful.";
                            $errors = TRUE;
                        }
                    } else {
                         $upFileErr = "File is too large to upload. 
                                   Must be less than 2 Mb. Please try again.";
                         $errors = TRUE;
                    }
                     
                 } else {
                     $upFileErr = "Only Word documents, or PDF files may be uploaded.";
                     $errors = TRUE;
                 }

            } else {
                $upFileErr = "Please select a file to upload.";
                $errors = TRUE;
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

if($errors == false){
    echo "<h2>Your Input:</h2>";
    echo "Full Name: ";
    echo $name;
    echo "<br><br>";

    echo "Address: ";
    echo $address;
    echo "<br><br>";

    echo "Phone Number: ";
    echo $phone;
    echo "<br><br>";

    echo "Email: ";
    echo $email;
    echo "<br><br>";
    
    echo "Gender: ";
    echo $gender;
    echo "<br><br>";

    echo "Website URL: ";
    echo $webURL;
    echo "<br><br>";

    echo "Website IP Address: ";
    echo $webIP;
    echo "<br><br>";
    
    echo "Preferred Communication: ";
        //Use a for loop to display all the 
        //communications methods chosen.
    foreach($_POST['comm'] as $check){
      echo $check . "<br>";
    }
    echo "<br><br>";

    echo "File uploaded: ";
    echo $fileName . "<br>";
    echo $uploaded . "<br>";
    echo "<br><br>";
}

    include "index.html"
?>