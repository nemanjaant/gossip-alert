<?php
    
    session_start();
    header("Content-type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){


        include "../../config/connection.php";
        include "../functions.php";

        try{

            $credential = $_POST['credential'];
            $passwd = $_POST['passwd'];
            $encriptedPasswd = md5($passwd);

            //provera mejla
            
            $userObject = loginCheck($credential, $encriptedPasswd);
            
            
            if($userObject){

                if($userObject->active==true){

                $_SESSION['user'] = $userObject;
                

                echo json_encode(["success"=>true]); 
                http_response_code(202);
            }

                else{
                    echo json_encode(["success"=>false,"message"=>"Vaš nalog je privremeno blokiran."]);
                }
            
            }

            else{

                
                echo json_encode(["success"=>false,"message"=>"Pogrešni podaci za logovanje ili niste potvrdili svoj nalog putem mejla."]);
                  

            }
        }
        catch(PDOException $exception){
            echo $exception;
            http_response_code(500);
        }
    }
    else{
        http_response_code(404);
    }
?>
