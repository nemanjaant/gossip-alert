<?php 


$page = $_SERVER['QUERY_STRING'];
parse_str($page, $params);
$categoryItems = [];

if(isset($params['id'])){
    $id = $params['id'];

    if ($id==5){
        
        if(!isset($_SESSION['user'])){
            include("loginNotice.php");
        }

        else{

            $categoryItems = getNewsByCategory(5);
        $itemCount = countItemsByCategory(5);
        }
        
    }

    else{
        
    if(isset($params['subcat'])){
        $categoryItems = getNewsByParentCategory($id);
        $itemCount = countItemsByParentCategory($id);
    }

    else{

        $categoryItems = getNewsByCategory($id);
        $itemCount = countItemsByCategory($id);

    }

}
}


if(count($categoryItems)!=0):
    

?>

<div class="container">
    <input type="hidden" id="pageNr" value="<?php echo $id;?>">
<?php 
          if ($id==5):?>
            <h1 class='text-center my-5'>Dobro došli u tajni svet beogradskih poslovnih ljudi</h1>
      <?php  endif;
        ?>
    <div class="row" id="displayData">
        <?php 
            foreach($categoryItems as $item):
        ?>
        <div class="col-4">
        <h3><a href="index.php?page=newsArticle&id=<?= $item->idNews ?>"><?= $item->newsTitle ?></a></h3>
        <a href="index.php?page=newsArticle&id=<?= $item->idNews ?>"><img class="img img-fluid" src="<?= $item->imgSrc ?>" alt="<?= $item->newsTitle ?>"></a>
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
<?php 

endif;

?>
