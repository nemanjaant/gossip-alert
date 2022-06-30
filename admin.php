<?php 
    session_start();

    $user = $_SESSION['user'];

    if($user->roleID!=1){
        header("Location: index.php");
    }
    include "config/connection.php";
    include "models/functions.php";
    include_once "views/fixed/header.php";
?>



   <div class="container">
    <div class="row">
        <div class="col-3" id="adminPages">
            <ul>
                <li>
                    <a href="admin.php?page=insert">Unos vesti</a>
                </li>
                <li>
                    <a href="admin.php?page=updateDelete">Menjanje i brisanje vesti</a>
                </li>
                <li>
                    <a href="admin.php?page=insertHoroscope">Unos horoskopa</a>
                </li>
                <li>
                    <a href="admin.php?page=questionnaireManag">Upravljanje anketama</a>
                </li>
                <li>
                    <a href="admin.php?page=comments">Pregled komentara na čekanju</a>
                </li>
                <li>
                    <a href="admin.php?page=messages">Pristigle poruke</a>
                </li>
            
            </ul>
        </div>
        <div class="col-9">
            

            <div class="mb-5">
                <?php 
                    if(isset($_GET['page'])){
                        switch($_GET['page']){
                            case 'insert':
                                include "views/pages/adminPages/insertData.php";
                                break;
                            case 'updateDelete':
                                include "views/pages/adminPages/updateDelete.php";
                                break;
                            case 'insertHoroscope':
                                include "views/pages/adminPages/insertHoroscope.php";
                                break;
                            case 'messages':
                                include "views/pages/adminPages/messages.php";
                                break;
                            case 'questionnaireManag':
                                include "views/pages/adminPages/questionnaireManag.php";
                                break;
                            case 'comments':
                                include "views/pages/adminPages/comments.php";
                                break;
                            case 'updateForm':
                                include "views/pages/adminPages/updateForm.php";
                                break;  
                            
                        }
                    }

                    else{
                        include "views/pages/adminPages/insertData.php";
                    }

                   
                
                ?>
            </div>
        
        </div>
        </div>
        </div>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
</script>
<script type="text/javascript" src="assets/js/functions.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>

