<?php
    header("Content-type: application/json");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include "../../config/connection.php";
        include "../functions.php";

        try{
            $name = $_POST['name'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $passwd = $_POST['passwd'];
           

            $errors=[];

            // provera podataka
            $reName = '/^([A-ZČĆŽŠĐa-zčćžšđ\s*]{3,20})$/';
            $reMail = '/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/';
           $emailCheck = checkEmail($email);
           $usernameCheck = checkUsername($username);


            if(!preg_match($reName, $name)){
                $errors[]="Pogresno uneto ime";
            }
            if(!preg_match($reName, $lastName)){
                $errors[]="Pogresno uneto prezime";
                
            }
            if(!preg_match($reMail, $email)){
                $errors[]="Pogresno unet mejl";
            }
            if($emailCheck) $errors[]="Nalog sa unetim mejlom već postoji";
            if($usernameCheck) $errors[]="Nalog sa unetim korisničkim imenom već postoji";


            if($errors){
                $response = ["message"=>"Neuspešan unos!", "errors"=>$errors];
                echo json_encode($response);
                
            }

            else {

            
                $hashedPasswd = md5($passwd);
                $date = date("Y-m-d H:i:s");
                $token = md5($date.$username);
            
                $userAdded = addUser($name, $lastName, $email, $username, $hashedPasswd, $token, $date);

                
                if($userAdded){

                    emailConfirmation($email, $token);
                    $response = ["message"=>"Potvrdite registraciju putem linka koji je poslat na e-mail adresu. <b>PROVERITE SPAM</b>"];
                    echo json_encode($response);
                    http_response_code(201);
                }
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