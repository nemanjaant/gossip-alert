<?php 

    include_once("../config/connection.php");

    global $conn;

    

    if(isset($_POST["btn"])){

        header("Content-Type: application/json");

        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $infoagreement = $_POST["infoagreement"];
        $message = $_POST["message"];

        $nameAndSurnameReg = "/^[A-Za-z]{1,20}(\s[A-Za-z]{1,20})*$/";
        $emailReg = "/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/";

        $valid = true;

        if(!preg_match($nameAndSurnameReg, $name)){

            $valid = false;

        }

        if(!preg_match($nameAndSurnameReg, $surname)){

            $valid = false;

        }

        if($valid){

            $query = "INSERT INTO visitormessages (name, surname, email, message) VALUES (:name, :surname, :email, :message)";
            $data = $conn -> prepare($query);
            $data-> bindParam(":name", $name);
            $data-> bindParam(":surname", $surname);
            $data-> bindParam(":email", $email);
            $data-> bindParam(":message", $message);

            $entered = $data->execute();

            if($entered){
                echo json_encode(["message"=>"Poruka je uspešno dostavljena."]);
            }

            else{
                http_response_code(500);

            }

            
        }


    }

    else{
        http_response_code(404);
    }

    $conn->beginTransaction();

        $query = 'INSERT INTO bamentity (title, typeID, description) VALUES (:title, :type, :description)';

       

        

?>