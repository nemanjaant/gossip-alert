<?php 
if(isset($_POST['id'])){

    header("Content-Type: application/json");
    include "../config/connection.php";

    $id=$_POST['id'];
    $query="UPDATE visitormessages SET readCheck=1 WHERE idMessage=:id";
    $result=$conn->prepare($query);
    $result->bindParam(":id", $id);
    $success = $result->execute();

    if($success){
        http_response_code(200);
        echo json_encode(['ok'=>true]);
    }

    else{
        http_response_code(500);
    }

    
  
}

else {
    http_response_code(404);

}



?>