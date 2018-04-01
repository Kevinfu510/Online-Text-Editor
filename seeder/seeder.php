<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully.</br>";

    // Create database
    $sql = "CREATE DATABASE editor";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully.</br>";
    } else {
        echo "Error creating database: " . $conn->error . "</br>";
    }

    mysqli_select_db($conn,"editor");
    echo "Succesfully selected DB</br>";

    //Create table
    $sql = "CREATE TABLE files (id INT(5) NOT NULL AUTO_INCREMENT, user_id INT(5) references users(id),name VARCHAR(62) NOT NULL,content VARCHAR(16777215) NOT NULL,PRIMARY KEY (id))";
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully.</br>";
    } else {    
        echo "Error creating Table: " . $conn->error . "</br>";
    }

    //Create table
    $sql = "CREATE TABLE users (id INT(5) NOT NULL AUTO_INCREMENT,username VARCHAR(62) NOT NULL UNIQUE,password CHAR(32) NOT NULL,PRIMARY KEY (id))";
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully.</br>";
    } else {    
        echo "Error creating Table: " . $conn->error . "</br>";
    }

    //Insert values into table
    $sql = "INSERT INTO users (username, password) VALUES('admin', md5('admin'))";
    if ($conn->query($sql) === TRUE) {
        echo "Rows inserted successfully.</br>";
    } else {
        echo "Error inserting rows: " . $conn->error . "</br>";
    }


    //Insert values into table
    $sql = "INSERT INTO files (user_id, name, content) VALUES(1, 'file1', 'this is a sample text don\'t mind me')";
    if ($conn->query($sql) === TRUE) {
        echo "Rows inserted successfully.</br>";
    } else {
        echo "Error inserting rows: " . $conn->error . "</br>";
    }

    //Insert values into table
    $sql = "INSERT INTO files (user_id, name, content) VALUES(1, 'Test File!', 'THIS PROJECT IS GONNA BE SO GOOD TO MAKE!')";
    if ($conn->query($sql) === TRUE) {
        echo "Rows inserted successfully.</br>";
    } else {
        echo "Error inserting rows: " . $conn->error . "</br>";
    }

    //Insert values into table
    $sql = "INSERT INTO files (user_id, name, content) VALUES(1, 'What I am doing', 'Still waiting for spice and wolf season 3')";
    if ($conn->query($sql) === TRUE) {
        echo "Rows inserted successfully.</br>";
    } else {
        echo "Error inserting rows: " . $conn->error . "</br>";
    }

    //Insert values into table
    $sql = "INSERT INTO files (user_id, name, content) VALUES(1, 'Welp running out of ideas', 'Lorem Ipsum and then some')";
    if ($conn->query($sql) === TRUE) {
        echo "Rows inserted successfully.</br>";
    } else {
        echo "Error inserting rows: " . $conn->error . "</br>";
    }



    $conn->close();

?>
