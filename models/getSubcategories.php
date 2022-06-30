<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        header("Content-Type: application/json");

        include_once "../config/connection.php";
        include_once "functions.php";

        try{

            global $conn;

            $category = $_POST['category']; 

            $query = "SELECT * FROM categories_menu WHERE idParent=:id";
            $result = $conn->prepare($query);
            $result->bindParam(":id", $category);
            $result->execute();
            $data = $result->fetchAll();

            echo json_encode([
                "subcategories"=>$data
            ]);

            http_response_code(200);
        }
       
    
        catch(PDOException $exception){
            echo $exception;
            http_response_code(500);
            
        }
        
    }

    else http_response_code(404);

?>