<?php

header("Content-Type: application/json");
include "../config/connection.php";
include "functions.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $parentCategory = $_POST['parentCategory'];
    $subCategory = $_POST['subCategory'];
    
    $title = $_POST['title'];
    $newsText = $_POST['newsText'];
    $imageTitle = $_FILES['imageTitle'];
    $imageText = $_FILES['imageText'];
    
    try {
       $imageTitleName = time()."_".$imageTitle['name'];
        $imageTitleSrc = "assets/images/newsIntro/$imageTitleName";
        
        $imageTextName = time()."_".$imageText['name'];
        $imageTextSrc = "assets/images/news/$imageTextName";
        
        $tmpTitle = $imageTitle['tmp_name'];
        move_uploaded_file($tmpTitle, '../'.$imageTitleSrc);

        $tmpNews = $imageText['tmp_name'];
        move_uploaded_file($tmpNews, '../'.$imageTextSrc);
        

        global $conn;

        $conn->beginTransaction();

        $query = 'INSERT INTO news (newsText, newsTitle, idCategory) VALUES (:newsText, :title, :category)';

        $data = $conn->prepare($query);
        $data->bindParam(":title", $title);
        $data->bindParam(":category", $subCategory);
        $data->bindParam(":newsText", $newsText);

        $data->execute();

        $id = $conn->lastInsertId();

        //povezivanje sa slikama u tekstu

        $queryImg = "INSERT INTO newsimages VALUES (NULL, ?, ?)";
        $data = $conn->prepare($queryImg);
        $data->bindParam(1, $id);
        $data->bindParam(2, $imageTextSrc);

        $data->execute();
 
        //povezivanje sa nalsovnim slikama

        $queryImg = "INSERT INTO newsintroimages VALUES (NULL, ?, ?)";
        $data = $conn->prepare($queryImg);
        $data->bindParam(1, $id);
        $data->bindParam(2, $imageTitleSrc);

        $data->execute();



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