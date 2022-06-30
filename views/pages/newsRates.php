<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<?php
    if(isset($user)){
        echo '<input type="hidden" id="user" value="'.$user->userID.'">';
    }

    $averageRate = avgRate($newsId);
    
    if($averageRate->avg!=0){
        $value = round($averageRate->avg, 2);
        $rateString = "Ocena vesti: ".$value;

    }

    else $rateString = "Još uvek nema ocena...";

    
?>

<div class="row my-2" id="rateDiv">
        <div class="col-2">
        <p id="averageRateTxt"><?= $rateString ?> </p>
        </div>
            <div class="col-3">
            <ul class="reviewStars">
                <?php
                    for($i=0; $i<5; $i++){
                        $val = $i+1;
                        echo '<li class="mx-2"><span class="star" data-rate="'.$val.'"> 	
                        &#9734;</span></li>';
                    }
                
                ?>
            </ul>
        </div>


    </div>