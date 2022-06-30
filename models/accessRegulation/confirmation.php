<?php 

    if(isset($_GET['token'])){
        include "../../config/connection.php";
        global $conn;
        

        $token = $_GET['token'];
        $query = "UPDATE users SET active=1 WHERE token=:token";
        $result = $conn->prepare($query);
        $result->bindParam(":token", $token, PDO::PARAM_STR);
        $success = $result->execute();

        if($success){
            
            echo "<p class='alert alert-success'>USPESNA REGISTRACIJA</p>";
        }

    }

?>