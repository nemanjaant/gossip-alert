<?php 
    session_start();
    header("Content-Type: application/json");
    

    if($_SERVER["REQUEST_METHOD"]=="POST"){

        include "functions.php";
        include "../config/connection.php";



        try{
            $comment = $_POST['id'];

            $conn->beginTransaction();


            $query = "DELETE FROM commentnews WHERE idComment=:id";
            $res = $conn->prepare($query);
            $res->bindParam(":id", $comment);
            $res->execute();

            $query = "DELETE FROM commentuser WHERE idComment=:id";
            $res = $conn->prepare($query);
            $res->bindParam(":id", $comment);
            $res->execute();
            
            $query = "DELETE FROM comments WHERE idComment=:id";
            $res = $conn->prepare($query);
            $res->bindParam(":id", $comment);
            $res->execute();

            
            $deleted = $conn->commit();

           if($deleted){
               echo json_encode([
                   "message"=>"Komentar je obrisan."
               ]);
           }
            
        }

        catch(PDOException $ex){

            $conn->rollback();
            http_response_code(500);
            
        }

    }

    else {
        http_response_code(404);
    }


?>