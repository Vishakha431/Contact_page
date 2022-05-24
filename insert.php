<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['fname']) && isset($_POST['email']) &&
        isset($_POST['mobile']) && isset($_POST['msg'])) {
        
        $username = $_POST['fname'];
        $password = $_POST['email'];
        $gender = $_POST['mobile'];
        $email = $_POST['msg'];
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "igniters";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM contact WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO contact(fname, email, mobile, msg) values(?, ?, ?, ?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->bind_param("i", $mobile);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssis",$fname, $email, $mobile, $msg);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>