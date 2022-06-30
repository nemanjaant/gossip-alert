<?php 

  header("Content-Type: application/json");
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include_once "../../config/connection.php";
        include_once "../functions.php";

        try{

            $limit = (int) $_POST['limit'];
            $id = $_POST['id'];
            
            
            
            $isNotParent = checkParentId($id);
            

            if($isNotParent){
                $categoryItems = getNewsByCategory($id, $limit);
                $itemCount = countItemsByCategory($id);
            }
            else{
                $categoryItems = getNewsByParentCategory($id, $limit);
                $itemCount = countItemsByParentCategory($id);
               

            }
            $totalPages = countTotalPages($itemCount); 

             
            echo json_encode([
                "news" => $categoryItems,
                "pages" => $totalPages,
                "parent" => $isNotParent
            ]);

            http_response_code(200);
        }

        catch(PDOException $exception){
            http_response_code(500);
        }
        
    }

    else http_response_code(404);


?>