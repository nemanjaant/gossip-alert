<section id="topNews">
    <div class="text-center mb-5">
        <h3 class="leadingHeadings">Najpopularnije vesti!</h3>
    </div>
  <?php 
  
    global $conn;
    $query = "SELECT n.idNews, n.newsTitle, nii.imgSrc , AVG(rate) AS avg FROM news n INNER JOIN newsintroimages nii ON n.idNews=nii.idNews INNER JOIN user_rate_news urn ON n.idNews=urn.idNews INNER JOIN categories_menu cm ON n.idCategory=cm.idCategory WHERE cm.idCategory!=5 GROUP BY n.idNews, n.newsTitle, nii.imgSrc ORDER BY avg DESC LIMIT 4 ";

    $data=$conn->query($query);
    $result = $data->fetchAll();
    
  ?>
    <div id="topNewsSection">
    <div class="slidercontainer">
  <div class="slider">
    <div class="slider__slides">
      <div class="slider__slide active">
        <div class="row text-center">
        <a href="index.php?page=newsArticle&id=<?= $result[0]->idNews ?>"><h3><?= $result[0]->newsTitle ?></h3></a>
        <a href="index.php?page=newsArticle&id=<?= $result[0]->idNews ?>"><img class="introImgs" src="<?= $result[0]->imgSrc ?>" alt="<?= $result[0]->newsTitle ?>"></a>
        </div>
      </div>
      <?php
      
        for($i=1; $i<count($result); $i++):
          
      ?>

      <div class="slider__slide">
        <div class="row text-center">
        <a href="index.php?page=newsArticle&id=<?= $result[$i]->idNews ?>"><h3><?= $result[$i]->newsTitle ?></h3></a>
        <a href="index.php?page=newsArticle&id=<?= $result[$i]->idNews ?>"><img class="introImgs" src="<?= $result[$i]->imgSrc ?>" alt="<?= $result[$i]->newsTitle ?>"></a>
        
      </div>
      </div>
    <?php
        endfor;
      ?>
      
    </div>
    <div id="nav-button--prev" class="slider__nav-button"></div>
    <div id="nav-button--next" class="slider__nav-button"></div>
    <div class="slider__nav">
      <div class="slider__navlink active"></div>
      <div class="slider__navlink"></div>
      <div class="slider__navlink"></div>
      <div class="slider__navlink"></div>
    </div>
  </div>
</div>








      

</div>
    </section>