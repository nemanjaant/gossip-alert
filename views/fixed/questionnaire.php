<?php 

    $query = "SELECT question, q.idQuestionnaire, idResponse, response  FROM questionnaires q INNER JOIN responses r ON q.idQuestionnaire=r.idQuestionnaire WHERE active=1";
    $result = $conn->query($query)->fetchAll();
    $i = 1;
?>
<form action="#" id="questionnaireForm" data-formid="<?=$result[0]->idQuestionnaire ?>">
    <legend><?=$result[0]->question?></legend>
    <fieldset>
        <?php
            foreach($result as $question):
        ?>
        <div class="form-group col-12">
            <input type="radio" name="questionVote" value="<?=$question->idResponse?>">
            <label for="questionVote"><?=$question->response?></label>
            <span class="result"></span>
        </div>
        <?php 
            endforeach;
        ?>
        <input type="button" value="GLASAJ" id="voteBtn" class="btn btn-warning mt-3">
    </fieldset>
</form>
<div id="feedbackInfo" class="mt-3">
    
</div>
