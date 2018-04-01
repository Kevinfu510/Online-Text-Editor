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
    mysqli_select_db($conn,"editor");
    if (isset($_SESSION['session_user_id'])) {
        $user_id = $_SESSION['session_user_id'];
        $sql = "SELECT * FROM files WHERE user_id = $user_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                //Convert the open variable
                $modified_row['id'] = $row['id'];
                $modified_row['value'] = $row['name'];
                $modified_row['content'] = $row['content'];
                $myArray[] = $modified_row;
            }
        }
        if (isset($myArray)) {
            echo json_encode($myArray);
        }
        else {
            echo '[]';
        }
    }
    else {
        echo json_encode("403");
    }
    $conn->close();
?>