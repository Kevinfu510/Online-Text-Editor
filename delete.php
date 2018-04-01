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

    if (isset($_POST['id']) && isset($_SESSION['session_user_id'])) {
        //Create new Note File
        $user_id = $_SESSION['session_user_id'];
        $id = $_POST['id'];
        $sql = "DELETE FROM files WHERE id='$id' AND user_id=$user_id";
        if ($conn->query($sql) === TRUE) {
            $myArray = "Deleted row";
            echo json_encode($myArray);    
        } else {
            $myArray = "Error Selecting rows: " . mysqli_error($conn);
            echo json_encode($myArray);
        }
    }    
    $conn->close();
?>