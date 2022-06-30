<?php 

    if($_SERVER["REQUEST_METHOD"]=="GET"){

     $query="SELECT * FROM news";
     $data = $conn->query($query)->fetchAll();   
        
                

?>

<h1>
            
    </h1>
<table class="table m-5">
    <thead>
        <tr>
            <th>Redni broj</th>
            <th>Naslov</th>
            <th>izmeni</th>
            <th>obrisi</th>
        </tr>

    </thead>
    <tbody>

        <?php
        $order=1;
  foreach($data as $obj):

?>
    <tr>
        <td><?=$order++?></td>
        <td><a href="index.php?page=newsArticle&id=<?=$obj->idNews ?>" class="admLinks" target="_blanc"><?=$obj->newsTitle ?></a></td>
        <td><a href="admin.php?page=updateForm&id=<?=$obj->idNews ?>" target="_blanc">[izmeni]</a></td>
        <td><a data-entity="<?=$obj->idNews?>" class="deletion">[X]</a></td>
    </tr>



        <?php
    endforeach;


?>
    </tbody>

</table>

<?php

}


    else {
        http_response_code(404);}
        
   

?>