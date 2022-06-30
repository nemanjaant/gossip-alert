<?php

header("Content-Type: application/json");
include "../config/connection.php";
include "functions.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $title = $_POST['title'];
    $responses = $_POST['responses'];
    
    
    try {
       

        global $conn;

        $conn->beginTransaction();

        $query = 'INSERT INTO questionnaires  VALUES (NULL, :question, 0)';

        $data = $conn->prepare($query);
        $data->bindParam(":question", $title);

        $data->execute();

        $id = $conn->lastInsertId();

        //povezivanje sa responses tabelom
        foreach($responses as $response){
        $queryResp = "INSERT INTO responses VALUES (NULL, ?, ?)";
        $data = $conn->prepare($queryResp);
        $data->bindParam(1, $id);
        $data->bindParam(2, $response);

        $data->execute();
    }


        $conn->commit();
        echo json_encode([
            'message'=> "Zapis je uspesno unet u bazu.",
            
        
        ]);
        http_response_code(201);
    }
    catch(PDOException $ex){
        $conn->rollback();
        echo json_encode(['message'=> $ex->getMessage()]);
        http_response_code(500);
    }
} else {
    http_response_code(404);
}

?>