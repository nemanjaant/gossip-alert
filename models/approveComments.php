<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        header("Content-Type: application/json");

        include_once "../config/connection.php";
        include_once "functions.php";

        try{

            global $conn;

            $commentID = $_POST['id']; 

            $query = "UPDATE comments SET approved=1 WHERE idComment=:id";
            $result = $conn->prepare($query);
            $result->bindParam(":id", $commentID);
            $success=$result->execute();

        
             if($success){
            
            echo json_encode([
                "message"=>"odobreno"
            ]);

            http_response_code(200);
        }
        }
    
        catch(PDOException $exception){
            http_response_code(500);
            
        }
        
    }

    else http_response_code(404);

?>