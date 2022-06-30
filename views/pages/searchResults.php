<?php 
    $page = $_SERVER['QUERY_STRING'];
    parse_str($page, $params);
    $string = $params["string"];

    $searchStringItems = getItemsBySearchString($string);
    $itemCount = countItemsBySearchString($string);

    

?>



<div class="container">
    <h3>Rezultati pretrage za: <b><?php echo $string;?></b></h3>
    <input type="hidden" id="searchStr" value="<?php echo $string;?>">

    <div class="row" id="displayData">
        <?php 
            foreach($searchStringItems as $item):
        ?>
        <div class="col-4">
        <a href="index.php?page=newsArticle&id=<?= $item->idNews ?>"><h3><?= $item->newsTitle ?></h3></a>
        <a href="index.php?page=newsArticle&id=<?= $item->idNews ?>"><img src="<?= $item->imgSrc ?>" alt="Photo of news item <?= $item->newsTitle ?>" class="img-fluid"></a>
            <p><?= substr($item->newsText, 0, 70)?>...</p>

        </div>
        <?php endforeach; ?>
    </div>
        
    <div class="row">
            <div class="col-12">
                <div>
                    <?php
            
             $totalPages = countTotalPages($itemCount); 
             
            ?>
                    <ul class="pagination" id="paginationList">

                        <?php
                        for($i = 0; $i < $totalPages; $i++):
                    ?>

                        <?php if($i==0): ?>

                        <li class="page-item">
                            <a class="page-link pageNr active" href="#" data-limit="<?=$i?>"><?=($i+1)?></a>
                        </li>

                        <?php endif; ?>

                        <?php if($i>0): ?>

                        <li class="page-item">
                            <a class="page-link pageNr" href="#" data-limit="<?=$i?>"><?=($i+1)?></a>
                        </li>

                        <?php endif; ?>

                        <?php
                        endfor;
                    
                    ?>

                    </ul>
                </div>
            </div>
        </div>



</div>