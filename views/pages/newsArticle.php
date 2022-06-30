<?php 

    if(!(isset($_GET['id']))){

        header("Location: 404.php");
        exit;

    }
        

    else{

        $newsId = $_GET['id'];
       

        try{

            $query="SELECT n.idNews, n.newsText, n.newsTitle, n.date, imgSrc FROM news n INNER JOIN newsimages ni ON n.idNews=ni.idNews WHERE n.idNews=:idnews";
            $result = $conn->prepare($query);
            $result->bindParam(":idnews", $newsId);
            $result -> execute();
            $data = $result->fetch();
            
            
        }

        catch(PDOException $ex){
            echo "<p>Podaci trenutno nisu dostupni</p>";
        }

    }

 ?>


<div class="container my-5" id="entity">

    <?php
        include "newsMeta.php";
        include "newsRates.php";
        include "newsComments.php";
    ?>

</div>
