<?php 
    session_start();
    include_once("../config/connection.php");
    include_once("functions.php");
    global $conn;

    header("Content-type: appication/json");
try{
    if(!isset($_SESSION['user'])){
        echo json_encode(["message"=>"Samo ulogovani korisnici mogu glasati", "error"=>true]);
    }
    else{

        $userID = $_SESSION['user']->userID;
        $questionnaireID = $_POST['questionnaire'];
        $answerID = $_POST['answer'];
        
        if(checkUserVote($userID, $questionnaireID)){
            //vracam da je vec glasano pa saljem ocene
            $results = getVotingResults($questionnaireID);
            echo json_encode(["message"=>"Vec ste glasali", "error"=>false, "data"=>$results]);
            
        }
        else{
            if(addVotingResult($userID, $questionnaireID, $answerID)){
                $results = getVotingResults($questionnaireID);
                echo json_encode(["message"=>"Hvala na glasanju", "error"=>false, "data"=>$results]);
                //cuvam glas pa saljem ocene

            }
            else http_response_code(500);
        }
        




        
    }
}

catch(exception $ex){
    echo $ex;
}

?>
