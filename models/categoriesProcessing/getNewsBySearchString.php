<?php 

  header("Content-Type: application/json");
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include_once "../../config/connection.php";
        include_once "../functions.php";

        try{

            $limit = (int) $_POST['limit'];
            $searchStr = $_POST['srchStr'];
            
            $searchStringItems = getItemsBySearchString($searchStr, $limit);
            $itemCount = countItemsBySearchString($searchStr);
            $totalPages = countTotalPages($itemCount); 

             
            echo json_encode([
                "news" => $searchStringItems,
                "pages" => $totalPages,
                'limit' => $limit
            ]);

            http_response_code(200);
        }

        catch(PDOException $exception){
            http_response_code(500);
        }
        
    }

    else http_response_code(404);


?>