<?php 
    session_start();
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        header("Content-Type: application/json");

        include_once "../config/connection.php";
        include_once "functions.php";

        try{

            $userID = (int) $_SESSION['user']->userID;
            $newsID = (int) $_POST['entity'];
            $rate = (int) $_POST['rate'];

            //provera da li je korisnik vec ocenio entitet
            $rated = checkRate($userID, $newsID);
            $success = false;
            //-ako jeste, update
            if($rated){
                //ako je ocenjen, prvo se ispita da li je korisnik uneo istu ocenu, pri cemu se nece azurirati baza
                if($rated!=$rate){
                    $success = updateRate($userID, $newsID, $rate);
                }

            }
            
            //-ako nije, insert
            else {

                $success = insertRate($userID, $newsID, $rate);

            }

            if($success) {
            $newAvg = round(avgRate($newsID)->avg,2); 
            
            echo json_encode([
                "newAvg"=>$newAvg,
                "success"=>$success
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