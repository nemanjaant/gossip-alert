<?php 

    if(isset($_GET['id'])){

        
        
        $newsId = $_GET['id'];
        $query="SELECT * FROM news WHERE idNews=:id";
        $result = $conn->prepare($query);
        $result->bindParam(":id",$newsId);

        $result->execute();
        $data = $result->fetch();
       
        
           
            

      ?>     
<input type="hidden" id="entity" value="<?=$data->idNews?>">
        <div class="col-6 m-5">
            <h3>Trenutni naslov: <?= $data->newsTitle ?></h3>
            <h4>Novi naslov:</h4>
            <input type="text" id="newTitle">
            <input type="submit" id="updateTitle" value="promeni">
        
        </div>
        <div class="col-6 m-5">
            <h3>Tekst vesti: </h3>
            <textarea id="newDesc" cols="90" rows="15"><?= $data->newsText ?></textarea>
            <br>
            <input type="submit" id="updateDesc" value="promeni">
        
        </div>
            

    <?php } 

    else {
        
        http_response_code(404);
    }

?>