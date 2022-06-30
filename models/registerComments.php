<?php 
    session_start();
    header("Content-Type: application/json");
    

    if($_SERVER["REQUEST_METHOD"]=="POST"){

        include "functions.php";
        include "../config/connection.php";



        try{
            $userID = (int) $_SESSION['user']->userID;
            $comment = $_POST['comment'];
            $entityID = $_POST['entity'];

            $conn->beginTransaction();


            //unos komentara
            $enterComment = enterComment($comment);

            if($enterComment){
                $idCom = $conn->lastInsertId();

                //povezivanje komentara sa korisnikom koji ga je napravio
                enterCommentUser($idCom, $userID);
     
                //povezivanje komentara sa entitetom na koji se odnosi
                enterCommentEntity($idCom, $entityID);

            }
           $entered = $conn->commit();

           if($entered){
               echo json_encode([
                   "message"=>"Komentar je poslat. Biće objavljen nakon revizije. Hvala."
               ]);
           }
            
        }

        catch(PDOException $ex){
            
            $conn->rollback();
            echo $ex;
            http_response_code(500);
            
        }

    }

    else {
        http_response_code(404);
    }


?>