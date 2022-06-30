<?php 
global $conn;

$query='SELECT * FROM comments c INNER JOIN commentuser cu ON c.idComment=cu.idComment INNER JOIN users u ON cu.idUser=u.userID INNER JOIN commentnews ce ON c.idComment=ce.idComment INNER JOIN news n ON ce.idNews=n.idNews WHERE approved=0'; 

$data = $conn->query($query)->fetchAll();


?>

<table class="table">
    <thead>
        <tr>
            <th>Korisnik</th>
            <th>Komentar</th>
            <th>Stranica</th>
            <th>Odobri</th>
            <th>Obrisi</th>
        </tr>
    </thead>
    <tbody>
        
        <?php 

            foreach($data as $comment):
        
        ?>
        <tr>
            <td><?=$comment->username?></td>
            <td><?=$comment->comment?></td>
            <td><?=$comment->newsTitle?></td>
            <td><button class="btn btn-success approveComment" data-id="<?=$comment->idComment?>">Odobri</button></td>
            <td><button class="btn btn-warning deleteComment" data-id="<?=$comment->idComment?>">Obriši</button></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>