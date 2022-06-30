<?php 

    if($_SERVER["REQUEST_METHOD"]=="GET"){

         
      $query = "SELECT * FROM visitormessages WHERE readCheck=0";
      global $conn;
      $result = $conn->query($query);
      $messages=$result->fetchAll();

     ?>

<table class="table w-100">
    <thead>
        <tr>
            <th>Ime i prezime</th>
            <th>mejl</th>
            <th>poruka</th>
        </tr>
    </thead>
    <tbody>

     <?php 

        foreach($messages as $message):
    ?> 
        <tr>
            <td class="w-20"><?=$message->name ?> <?=$message->surname ?></td>
            <td><?=$message->email?></td>
            <td class="w-50"><?=$message->message?></td>
            <td><button class="btn btn-success readMsg" data-msgid="<?=$message->idMessage?>">pročitano</button></td>
        </tr>

 <?php     
        endforeach;
    }

    else {
        http_response_code(404);
    }

    

?>