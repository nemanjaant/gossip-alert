<?php 

    if($_SERVER["REQUEST_METHOD"]=="POST"){

        include "../config/connection.php";
        include "functions.php";

        $id = $_POST['id'];

        global $conn;

        try{
            $conn->beginTransaction();

            
            $queryC = "DELETE FROM newsimages WHERE idnews=:id";
            $del = $conn->prepare($queryC);
            $del->bindParam(":id", $id);
            $del->execute();

            $queryF = "DELETE FROM newsintroimages WHERE idnews=:id";
            $del = $conn->prepare($queryF);
            $del->bindParam(":id", $id);
            $del->execute();

            $queryD = "DELETE FROM commentnews WHERE idnews=:id";
            $del = $conn->prepare($queryD);
            $del->bindParam(":id", $id);
            $del->execute();
            
            $queryG = "DELETE FROM user_rate_news WHERE idnews=:id";
            $del = $conn->prepare($queryG);
            $del->bindParam(":id", $id);
            $del->execute();

            $queryE = "DELETE FROM news WHERE idnews=:id";
            $del = $conn->prepare($queryE);
            $del->bindParam(":id", $id);
            $del->execute();


            $success = $conn->commit();
                
            if( $success){
                echo json_encode([
                "msg"=>"obrisano"
            ]);
            }
            else{
                echo json_encode([
                "msg"=>"nije obrisano"
            ]);
            }
            
        }


        catch(PDOException $ex){

            $conn->rollback();
            echo json_encode([
                "msg"=>$ex
            ]);
            http_response_code(500);
        }






}


    else {
        http_response_code(404);
    }
        
   

?>