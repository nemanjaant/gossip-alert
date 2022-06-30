<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        header("Content-Type: application/json");

        include_once "../config/connection.php";
        include_once "functions.php";

        try{

            global $conn;

            $active = $_POST['active']; 
            $newActive = $_POST['newActive']; 

            $query = "UPDATE questionnaires SET active=0 WHERE idQuestionnaire=:id";
            $result = $conn->prepare($query);
            $result->bindParam(":id", $active);
            $result->execute();

            $query = "UPDATE questionnaires SET active=1 WHERE idQuestionnaire=:newid";
            $result = $conn->prepare($query);
            $result->bindParam(":newid", $newActive);
            $success=$result->execute();

            if($success){
                http_response_code(200);
                echo json_encode(['msg'=>'uspeh']);
            }

        
             
        }
    
        catch(PDOException $exception){
            http_response_code(500);
            
        }
        
    }

    else http_response_code(404);

?>