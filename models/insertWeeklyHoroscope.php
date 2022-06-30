<?php

header("Content-Type: application/json");
include "../config/connection.php";
include "functions.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $zodiac = $_POST['zodiac'];
    $text = $_POST['title'];
   
    
    try {
        

        global $conn;

        $mondayDate = gmdate("Y-m-d", strtotime('monday this week')+86400);
        $sundayDate = gmdate("Y-m-d", strtotime('sunday this week')+86400);
		
		
		//provera da li je vec unet horoskop za odredjeni znak u odredjeno vreme
		$queryCheck = "SELECT * FROM horoscope WHERE dateFrom=:monday AND dateTo=:sunday AND idZodiac=:id";
		$result = $conn -> prepare($queryCheck);
        $result->bindParam(":monday", $mondayDate);
        $result->bindParam(":sunday", $sundayDate);
        $result->bindParam(":id", $zodiac);
        $result->execute();
        $exists = $result->fetch();
		
		if(!$exists){

        $query = 'INSERT INTO horoscope VALUES (NULL,?,?,?,?)';

        $data = $conn->prepare($query);
        $data->bindParam(1, $text);
        $data->bindParam(2, $mondayDate);
        $data->bindParam(3, $sundayDate);
        $data->bindParam(4, $zodiac);

        $data->execute();

        echo json_encode([
            'message'=> "Zapis je uspesno unet u bazu.",
            
        
        ]);
        http_response_code(201);
		}
		
		else{
			echo json_encode([
            'message'=> "Zapis je vec unet u bazu.",
            
        
        ]);
		}
    }
    catch(PDOException $ex){
        
        echo json_encode(['message'=> $ex->getMessage()]);
        http_response_code(500);
    }
} else {
    http_response_code(404);
}

?>