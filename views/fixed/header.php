<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gossip alert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src=
"https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <link rel='shortcut icon' href='assets/images/icon.ico'/>
</head>
<body>
<header class="container">
        <div class="row p-5">
            <div class="col-4">
        <div id="logo">
        <a href="index.php"><img src="assets/images/logo/logo.jpg" alt="Logo of Gossip Alert" class="img-fluid"></a>
        </div>
        </div>
        
        <div class="col-8">
            <div class="row">
        <div id="searchAndLog">
            <div class="row">
                <div class="col-lg-8">
                    <div class="input-group mb-3">
                    <a href="index.php?page=searchResults"  id="searchLnk"><span class="input-group-text">&#128269;</span></a> 
                        <input type="text" class="form-control" placeholder="pretraži vest" aria-label="Username" aria-describedby="basic-addon1" id="search">
                      </div>
                </div>
                <div class="col-lg-4">
                <ul id="loginRegulate">
                <?php 

                    if(isset($user->userID)){
                        echo '
                        <li>'.userCheck($user).'</li>
                        <li><a href="models/accessRegulation/logout.php">logout</a></li>';
                    }
                
                else echo '<li><a href="https://nemanjaant.com/index.php?page=login">logovanje</a></li>
                <li><a href="https://nemanjaant.com/index.php?page=registration">registracija</a></li>';
                
                ?>   
                </ul>
                    
                </div>
            </div>
            </div>
        </div>
        <?php include_once("nav.php"); ?>
        </div>
        </div>
    </header>