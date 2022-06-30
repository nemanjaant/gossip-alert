<?php 
    $mondayDate = gmdate("d.m.Y.", strtotime('monday this week'));
    $sundayDate = gmdate("d.m.Y.", strtotime('sunday this week'));
$horoscope = getHoroscopeData();
   
    
?>
<h2 class="text-center">Dodaj horoskop za sedmicu: od <?php echo $mondayDate.' do '.$sundayDate ?></h2>
<hr>

<form id="insertHoroscope">
    

    <div class="form-row mb-5">
    <div class="form-group col-6">
            <label for="">Znaci</label>
            <select name="ddlZodiacs" id="ddlZodiacs" class="form-control">
                <option disabled selected>-izaberite-</option>
                <?php foreach($horoscope as $hor): ?>
                
                <option value="<?=$hor->idZodiac?>"><?=$hor->zodiacName?></option>
                
                 <?php endforeach; ?>
            </select>
        </div>
    </div>
 
    
    
    <div class="form-group">
        <label for="horoscopeText">Tekst</label>
        <textarea name="horoscopeText" id="horoscopeText" class="form-control" rows="15"></textarea>
    </div>
    <div id="errors">

    </div>
    <div class="form-group text-center">
        <input type="button" value="Unos" id="btnInsertHoroscope" class="btn btn-primary mt-5">
    </div>

</form>