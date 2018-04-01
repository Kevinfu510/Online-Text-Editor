<?php
    session_start();
    header('Content-type:application/json;charset=utf-8');
    $servername = "localhost";
    $username = "root";
    $password = "";
    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Retrive back the updated data
    mysqli_select_db($conn,"editor");

    if (isset($_POST['name']) && isset($_SESSION['session_user_id'])) {
        //Create new Note File
        $user_id = $_SESSION['session_user_id'];
        $name = $_POST['name'];
        $empty = '';
        $sql = "INSERT INTO files (user_id, name, content) VALUES($user_id, '$name', '$empty')";
        if ($conn->query($sql) === TRUE) {
            $myArray = "Rows inserted successfully.";
            echo json_encode($myArray);

        } else {
            $myArray = "Error inserting rows: " . $conn->error;
            echo json_encode($myArray);
        }
    }    
    $conn->close();
?>