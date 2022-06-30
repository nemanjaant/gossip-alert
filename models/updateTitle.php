<?php

header("Content-Type: application/json");
include "../config/connection.php";
include "functions.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

   
    
    try {

        $id= $_POST['id'];
        $title = $_POST['title'];

        global $conn;

        $query = "UPDATE news SET newsTitle = :title WHERE idnews=:id";

        $result = $conn->prepare($query);
        $result->bindParam(":title", $title);
        $result->bindParam(":id", $id);

        $result->execute();

        
        echo json_encode([
            'message'=> "Zapis je uspesno azuriran."
        
        ]);
        http_response_code(201);
    }
    catch(PDOException $ex){
        
        echo json_encode(['message'=> $ex->getMessage()]);
        http_response_code(500);
    }
} else {
    http_response_code(404);
}

?>