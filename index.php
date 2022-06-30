<?php
    session_start();
    isset($_SESSION['user'])?$user = $_SESSION['user']:$user = null;
    isset($user)?$userId=$user->userID:$userId=null;
    

    include "config/connection.php";
    include "models/functions.php";

    include_once("views/fixed/header.php"); 
    
    
    if(isset($_GET['page'])){
        switch($_GET['page']){
            case 'category':
                include "views/pages/category.php";
                break;
            case 'newsArticle':
                include "views/pages/newsArticle.php";
                break;
            case 'registration':
                include "views/pages/registration.php";
                break;
            case 'login':
                include "views/pages/login.php";
                break;
            case 'loginNotice':
                include "views/pages/loginNotice.php";
                break;
            case 'author':
                include "views/pages/author.php";
                break; 
            case 'searchResults':
                include "views/pages/searchResults.php";
                break;
        
    }
}
    else {
        include "views/fixed/banner.php";
        include "views/fixed/topNews.php";
        include "views/fixed/horoscope.php";
    }

  

    include "views/fixed/footer.php";
    
    
    
    
    ?>

    

    

    

    <?php include_once("views/fixed/footer.php"); ?>
    
    