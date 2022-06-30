<?php

if(isset($userId)):?>
    <input type='hidden' value='<?=$userId?>'id='user'>
<?php
endif;
?>

<div class="row" id="entityMeta">
        <h1 class='text-center my-3'><?=$data->newsTitle?></h1>
    <div data-entity="<?=$newsId?>" class="row" id="entityDiv">
        <div class="col-lg-6 col-sm-12">
            <img src="<?=$data->imgSrc?>" alt="image of <?=$data->newsTitle?>" class="img img-fluid">
        </div>

        <div id="content" class="col-lg-6 col-sm-12">
            <span class="date"><?= date_format(date_create($data->date),"d/m/Y") ?></span>
            <p class="mt-4">
                <?= $data->newsText ?>
            </p>
        </div>



    </div>

</div>