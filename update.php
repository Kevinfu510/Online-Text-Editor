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

    if (isset($_POST['id']) && isset($_SESSION['session_user_id']) && isset($_POST['content'])) {
        //Create new Note File
        $user_id = $_SESSION['session_user_id'];
        $id = $_POST['id'];
        $content = $_POST['content'];
        $sql = "UPDATE files SET content = '$content' WHERE user_id = $user_id AND id = $id";
        if ($conn->query($sql) === TRUE) {
            $myArray = "Row updated successfully.";
            echo json_encode($myArray);

        } else {
            $myArray = "Error updating row: " . $conn->error;
            echo json_encode($myArray);
        }
    }    
    $conn->close();
?>