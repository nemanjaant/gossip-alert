<?php 

   
        global $conn;
         
      $query = "SELECT * FROM questionnaires WHERE active=1";
      
      $result = $conn->query($query);
      $questionnaire=$result->fetch();

     ?>

<div class="container mb-5">
    <div class="row">
        <h3>Aktivna anketa: </h3>
        <?php 
        echo "<h4 id='activeQ' data-active=".$questionnaire->idQuestionnaire.">".$questionnaire->question."</h4>";
        
    ?>
    </div>
</div>

<div class="container">

    <div class="row">
        <div class="col-6">
        <form id="newQuestionnaire">
            <div id="insertQuestionnaire">
        <h2>Dodaj novu anketu</h2>
                <div class="form-row">
                    <label>Naziv</label>
                    <input type="text" class="form-control" id="newQuestionnaireName">
                </div>
                <div class="form-row">
                <label>Odgovori na anketu</label>
                <input type="text" class="form-control newResponses">
                <input type="text" class="form-control newResponses">
                <div id="moreResponses">

                </div>
        <button class="btn btn-primary mt-3" id="addResponse">Dodaj odgovor</button>
            </div>


                <button class="btn btn-primary mt-3" id="addnewQuestionnaire">Unesi anketu</button>


            </div>
            </form>
        </div>
        <div class="col-6">
        <h2>Aktiviraj anketu</h2>
        <div class="form-row">
            <select name="nonActive" id="nonActive">
            <?php 
            
            $queryAll = "SELECT * FROM questionnaires WHERE active=0";
            
            $result = $conn->prepare($queryAll);
            $result->execute();

            $inactiveQuestionnaire = $result->fetchAll();

          
            
            foreach($inactiveQuestionnaire as $q):
            ?>

            <option value="<?=$q->idQuestionnaire?>"><?=$q->question?></option>

            <?php endforeach; ?>
            </select>
            </div>
            <button class="btn btn-primary mt-3" id="activate">Aktiviraj</button>
        </div>
    </div>
</div>

