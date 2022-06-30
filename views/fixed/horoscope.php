<?php 

    $result = getHoroscopeDataForTheCurrentWeek();
    
    
    $mondayDate = gmdate("d.m.Y", strtotime('monday this week'));
    $sundayDate = gmdate("d.m.Y.", strtotime('sunday this week'));

?>
<section id="horoscope" class="container">
    <div class="row text-center mb-5">
        <h3 class="leadingHeadings">Horoskop za <?= $mondayDate ?> - <?= $sundayDate ?></h3>
    </div>
    <div class="row">
    <?php 
        foreach($result as $horoscope):
            
    ?>
           
    <div class="col-lg-4 col-sm-6">
        <div class="text-center">
        <h4><?= $horoscope->zodiacName?></h4>
        <img class="img img-fluid" src="<?=$horoscope->zodiakImagePath ?>" alt="Photo of <?= $horoscope->zodiacName  ?> sign">
        </div>
        <div>
        <p><?=$horoscope->horoscopeText?></p>
        </div>
        
    </div>  
           
    <?php 
    
        endforeach;
    ?>
    </div>
</section>