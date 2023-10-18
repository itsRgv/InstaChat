<?php
session_start();
// echo "This data is coming from php file";
include_once "config.php";
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    //let's check if user email is valid or not
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // let's check that if this email already exist in database or not

        $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {   //if email already exists
            echo "$email - This email already exists";
        } else {
            //let's check user upload file or not
            if (isset($_FILES['image'])) { //if file is uploaded
                $img_name = $_FILES['image']['name']; // getting user uploaed img name
                $img_type = $_FILES['image']['type']; //getting user uploaded ing type
                $tmp_name = $_FILES['image']['tmp_name']; //this temporary name is used to save file in our folder

                // let's explode image and the last extensions like jpg png
                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);   // here we get the extension of the user uploaded image file

                $extensions = ['png', 'jpeg', 'jpg']; // these are the allowed extensions
                if (in_array($img_ext, $extensions) === true) { // if user uploaded image matches the allowed extensions
                    $time = time(); // this will return the current time
                    // we need this time because when you are uploading user img in our folder we rename user file with current time
                    // such that all the files have unique name
                    //let's move the user uploaded image to our particular folder
                    $new_img_name = $time . $img_name;

                    if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) { // if user uploaded image move to our folder successfully
                        $status = "Active now"; //once user signed up then his status will be active now
                        $random_id = rand(time(), 10000000); //creaating random id for user

                        //let's insert all user data inside table
                        $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                            VALUES ({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$password}', '{$new_img_name}', '{$status}')");
                        if ($sql2) {  // if data is inserted
                            $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                            if (mysqli_num_rows($sql3) > 0) {
                                $row = mysqli_fetch_assoc($sql3);
                                $_SESSION['unique_id'] = $row['unique_id']; //using this session we used user's unique id in other php file
                                echo "success";
                            }
                        }
                    }
                }
            } else {
                echo "Please select an image";
            }
        }
    } else {
        echo "$email is not a valid email!";
    }
} else {
    echo "All input are required!";
}
