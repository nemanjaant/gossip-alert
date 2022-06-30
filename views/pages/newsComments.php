
<div class="row" id="commentSection">
<?php 

    $comments = getComments($newsId);
    //var_dump($comments);
    foreach($comments as $comm):

?>
    <div class="comment col-12">
        <h5><?=$comm->username?></h5>
        <p>
        <?=$comm->comment?>
        </p>
    </div>

 <?php endforeach; 
 
 if($userId!=null):
 
 ?> 
 
    <div class="col-12" id="leaveComment">
    <p>Ostavite komentar</p>
<form>
    <textarea id="userComment"></textarea>
    <p>Uneli ste: <span id="char_cnt">0</span> karakter(a). Dozvoljeno je još <span id="chars_left">350</span>.</p>
</form>
    <div id="received"></div>

       <button type="submit" id="sendComment" class="btn btn-primary">Pošaljite komentar</button> 
    </div>
    

<?php endif; ?>
</div>