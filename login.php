<?php
    // Start the session
    session_start();
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $servername = "localhost";
        $server_user = "root";
        $server_password = "";
        // Create connection
        $conn = new mysqli($servername, $server_user, $server_password);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_select_db($conn,"editor");

        $username = $_POST['username'];
        $password = $_POST['password'];
        // $sql = "SELECT * FROM users WHERE username = $username";
        // $result = $conn->query($sql);
        $result = mysqli_query($conn, "SELECT * FROM Users WHERE username LIKE '$username'");
        if($result === FALSE) { 
            die(mysqli_error()); // TODO: better error handling
        }
        while($row = mysqli_fetch_array($result)) {
            if ($row['password'] === md5($password)) {
                $_SESSION['session_id'] = $username;
                $_SESSION['session_user_id'] = $row['id'];
                header("Location: /addemp/Online Text Editor/main.php");
                exit();
            }
            else {
                header("Location: /addemp/Online Text Editor/index.php?fail=1");
                exit();
            }
        }
        //Insert values into table
        $sql = "INSERT INTO users (username, password) VALUES('$username', md5('$password'))";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['session_id'] = $username;
            $_SESSION['session_user_id'] = $row['id'];            
            header("Location: /addemp/Online Text Editor/main.php");
            exit();
        } else {
            echo "Error inserting rows: " . $conn->error . "</br>";
        }   
    }
    else {
        echo "401 Authorized Access";
    }
?>