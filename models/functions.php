<?php 
define("CATEGORY_DISPLAY_OFFSET", 6);

function loadMenu($parent,$conn){ 
    $query="SELECT * FROM categories_menu WHERE idParent=$parent"; 
    $result = $conn->query($query); 
    if ($result->rowCount() > 0)
    { 
        echo "<ul>";
     
        foreach($result as $row)
        { 
            echo "<li><a href='".$row->path."&id=".$row->idCategory."'>".$row->categoryName."</a>";
            loadMenu($row->idCategory, $conn);
           
            echo "</li>"; 
        } 
        
        echo "</ul>";
        }     
}

function userCheck($user){

    if(@ $user->roleID==1){
         return '<a href="admin.php" id="adminLink">'.$user->username.'</a>';
     }
     else return @ $user->username;



 }


function loginCheck($credential, $passwd){
        global $conn;

        $query = "SELECT u.* FROM users u JOIN roles r ON u.roleID=r.roleID WHERE (u.email=:credential OR u.username=:credential) AND u.passwd=:passwd  AND active=1";

        $data = $conn -> prepare($query);
        $data->bindParam(":passwd", $passwd);
        $data->bindParam(":credential", $credential);

        
        $data->execute();

        $result = $data->fetch();

        return $result;

        
    }

    function addUser($name, $lastName, $email, $username, $passwd, $token, $registeredOn){
        global $conn;
        

        $query = "INSERT INTO users(firstName, lastName, email, username, passwd, token, registeredOn) VALUES (:fname, :lastName, :email, :username, :passwd, :token, :registeredOn)";

        $data = $conn->prepare($query);

        $data->bindParam(':fname', $name);
        $data->bindParam(':lastName', $lastName);
        $data->bindParam(':email', $email);
        $data->bindParam(':username', $username);
        $data->bindParam(':passwd', $passwd);
        $data->bindParam(':token', $token);
        $data->bindParam(':registeredOn', $registeredOn);

        $result = $data->execute();
        return $result;

    }

    function checkUserVote($userID, $questionnaireID){
        global $conn;

        $query = "SELECT * FROM votes WHERE idQuestionnaire=:idQuestionnaire AND userID=:userID ";
        $result = $conn->prepare($query);
        $result-> bindParam(":idQuestionnaire", $questionnaireID);
        $result-> bindParam(":userID", $userID);
        $result->execute();
        $data = $result->fetch();

        return $data;


    }
    
    function addVotingResult($userID, $questionnaireID, $answerID){
        global $conn;
        $query = "INSERT INTO votes VALUES(NULL, ?, ?, ?)";
        $result = $conn -> prepare($query);
        $result -> bindParam(1, $questionnaireID);
        $result -> bindParam(2, $answerID);
        $result -> bindParam(3, $userID);

        return $result->execute();

        
    }

    function getVotingResults($questionnaireID){
        global $conn;
        $query="SELECT r.idResponse, COUNT(v.idResponse) AS 'totalVotes', response FROM votes v RIGHT JOIN responses r ON v.idResponse=r.idResponse GROUP BY v.idResponse, response ORDER BY r.idResponse";

        $result = $conn -> prepare($query);
        $result->execute();
        $data = $result->fetchAll();

        return $data;
        
    }

    function getNewsByCategory($catId, $limit=0){
        global $conn;
        $offset = CATEGORY_DISPLAY_OFFSET;
        $limit = (int) $limit * $offset;
        
        $query="SELECT * FROM newsintroimages ni INNER JOIN news n ON ni.idNews=n.idNews WHERE idCategory=:cat LIMIT :limit, :offset";


        $result = $conn -> prepare($query);
        $result->bindParam(":cat", $catId);
        $result->bindParam(":limit", $limit, PDO::PARAM_INT);
        $result->bindParam(":offset", $offset, PDO::PARAM_INT);
        $result->execute();
        $data = $result->fetchAll();

        return $data;

    }

    function getNewsByParentCategory($parentId, $limit=0){
        global $conn;
        $offset = CATEGORY_DISPLAY_OFFSET;
        $limit = (int) $limit * $offset;

        $query="SELECT * FROM newsintroimages ni INNER JOIN news n ON ni.idNews=n.idNews WHERE idCategory IN (SELECT idCategory FROM categories_menu WHERE idParent=:parent) LIMIT :limit, :offset";

        $result = $conn -> prepare($query);
        $result->bindParam(":parent", $parentId);
        $result->bindParam(":limit", $limit, PDO::PARAM_INT);
        $result->bindParam(":offset", $offset, PDO::PARAM_INT);
        $result->execute();
        $data = $result->fetchAll();

        return $data;

    }

    function countItemsByCategory($catId){
        global $conn;
        
        $query="SELECT COUNT(*) AS result FROM newsintroimages ni INNER JOIN news n ON ni.idNews=n.idNews WHERE idCategory=:cat";

        $result = $conn -> prepare($query);
        $result->bindParam(":cat", $catId);
        $result->execute();
        $data = $result->fetch();

        return (int) $data->result;
    }

    function countItemsByParentCategory($parentId){
        global $conn;

        $query="SELECT COUNT(*) AS result FROM newsintroimages ni INNER JOIN news n ON ni.idNews=n.idNews WHERE idCategory IN (SELECT idCategory FROM categories_menu WHERE idParent=:parent)";

        $result = $conn -> prepare($query);
        $result->bindParam(":parent", $parentId);
        $result->execute();
        $data = $result->fetch();

        return (int) $data->result;
    }

    function countTotalPages($total){

        $totalPages = ceil( $total / CATEGORY_DISPLAY_OFFSET);

        return $totalPages;

    }

    function checkParentId($id){
        global $conn;

        $query="SELECT idParent FROM categories_menu WHERE idCategory=:id";
        $result = $conn -> prepare($query);
        $result->bindParam(":id", $id);
        $result->execute();
        $data = $result->fetch();

        return (int) $data->idParent;

    }

    function getItemsBySearchString($string, $limit=0){
        global $conn;
        $offset = CATEGORY_DISPLAY_OFFSET;
        $limit = (int) $limit * $offset;
        $string = '%'.$string.'%';

        
        $query = "SELECT * FROM newsintroimages ni INNER JOIN news n ON ni.idNews=n.idNews WHERE n.idCategory!=5 AND (newsText LIKE :pattern1  OR   newsTitle LIKE :pattern2) LIMIT :limit, :offset";
        $result = $conn -> prepare($query);
        $result->bindParam(":pattern1", $string, PDO::PARAM_STR);
        $result->bindParam(":pattern2", $string, PDO::PARAM_STR);
        $result->bindParam(":limit", $limit, PDO::PARAM_INT);
        $result->bindParam(":offset", $offset, PDO::PARAM_INT);
        $result->execute();
        $data = $result->fetchAll();

        return $data;
    }

    function countItemsBySearchString($string, $limit=0){
        global $conn;
        $offset = CATEGORY_DISPLAY_OFFSET;
        $limit = (int) $limit * $offset;
        $string = '%'.$string.'%';

        $limit = (int) $limit * $offset;
        $query = "SELECT COUNT(*) AS result FROM newsintroimages ni INNER JOIN news n ON ni.idNews=n.idNews WHERE n.idCategory!=5 AND (newsText LIKE :pattern1  OR   newsTitle LIKE :pattern2)";
        $result = $conn -> prepare($query);
        $result->bindParam(":pattern1", $string, PDO::PARAM_STR);
        $result->bindParam(":pattern2", $string, PDO::PARAM_STR);
        $result->execute();
        $data = $result->fetch();

        return $data->result;
    }
    
    function avgRate($newsId){
        global $conn;

        $query='SELECT AVG(rate) AS avg FROM user_rate_news WHERE idNews=:id';

        $data = $conn->prepare($query);
        $data->bindParam(':id',$newsId, PDO::PARAM_STR);
        $data->execute();

        $result = $data->fetch();

        return $result;
    }

    function getComments($newsId){
        global $conn;

        $query='SELECT c.*, username FROM comments c INNER JOIN commentuser cu ON c.idComment=cu.idComment INNER JOIN commentnews cn ON c.idComment=cn.idComment INNER JOIN users u ON cu.idUser=u.userID WHERE cn.idNews=:id AND c.approved=1';

        $data = $conn->prepare($query);
        $data->bindParam(":id", $newsId);
        $data->execute();

        $result = $data->fetchAll();

        return $result;
    }

    function checkRate($userID, $entityID){
        global $conn;

        $query = "SELECT rate FROM user_rate_news WHERE idNews=:entityID AND idUser=:userID";
        $data = $conn->prepare($query);
        $data->bindParam(':entityID',$entityID, PDO::PARAM_INT);
        $data->bindParam(':userID',$userID, PDO::PARAM_INT);
        $data->execute();

        $result = $data->fetch();

        if($result) return $result->rate;
        
    }

    function insertRate($userID, $entityID, $rate){

        global $conn;

        $query = "INSERT INTO user_rate_news VALUES(:user, :entity, :rate)";
        $data = $conn->prepare($query);
        $data->bindParam(':user', $userID, PDO::PARAM_INT);
        $data->bindParam(':entity', $entityID, PDO::PARAM_INT);
        $data->bindParam(':rate', $rate, PDO::PARAM_INT);
        
        $success = $data->execute();

        return $success;
    }

    function updateRate($userID, $entityID, $rate){
        global $conn;

        $query = "UPDATE user_rate_news SET rate=:rate WHERE idNews=:entity AND idUser=:user";

        $data = $conn->prepare($query);
        $data->bindParam(':user',$userID, PDO::PARAM_INT);
        $data->bindParam(':entity',$entityID, PDO::PARAM_INT);
        $data->bindParam(':rate', $rate, PDO::PARAM_INT);

        $result = $data -> execute();

        return $result;
    }

    function enterComment($comment){
        global $conn;

        $query="INSERT INTO comments (comment) VALUES(?)";

        $data = $conn->prepare($query);

        $data->bindParam(1, $comment, PDO::PARAM_STR);

        return $data->execute();

    }

    function enterCommentEntity($idCom, $entityID){
        global $conn;

        $query = "INSERT INTO commentnews VALUES (:commentID, :entityID)";
        $data = $conn->prepare($query);
        $data->bindParam(":commentID", $idCom);
        $data->bindParam(":entityID", $entityID);

        return $data->execute();

    }
    function enterCommentUser($idCom, $userID){
        global $conn;

        $query = "INSERT INTO commentuser VALUES (:commentID, :userID)";
        $data = $conn->prepare($query);
        $data->bindParam(":commentID", $idCom);
        $data->bindParam(":userID", $userID);

        return $data->execute();
    }

    function getParentCategories(){
        global $conn;

        $query = "SELECT * FROM categories_menu WHERE idParent=0";
        $data = $conn->prepare($query);
        $data->execute();
        $result=$data->fetchAll();

        return $result;
    }

    function getHoroscopeData(){
        global $conn;
        $query = "SELECT * FROM zodiacs ORDER BY idZodiac";
        $data=$conn->query($query);
        $result = $data->fetchAll();

    return $result;
    }

    function getHoroscopeDataForTheCurrentWeek(){
        global $conn;

        $mondayDate = gmdate("Y-m-d", strtotime('monday this week')+86400);
        $sundayDate = gmdate("Y-m-d", strtotime('sunday this week')+86400);
        $query = "SELECT h.idHoroscope, horoscopeText, zodiacName, zodiakImagePath FROM horoscope h INNER JOIN zodiacs z ON h.idZodiac=z.idZodiac WHERE dateFrom=:df AND dateTo=:dt ORDER BY z.idZodiac";
        $data=$conn->prepare($query);
        $data->bindParam("df", $mondayDate, PDO::PARAM_STR);
        $data->bindParam("dt", $sundayDate, PDO::PARAM_STR);
        $data->execute();
        $result = $data->fetchAll();

        return $result;
    }

    function checkUsername($username){

        global $conn;

        $query = "SELECT username FROM users WHERE username=:username";

        $data = $conn->prepare($query);
        $data->bindParam(":username", $username, PDO::PARAM_STR);
        $data->execute();

        $result = $data->fetch();

        
        return $result;
    }

    function checkEmail($email){

        global $conn;

        $query = "SELECT email FROM users WHERE email=:email";

        $data = $conn->prepare($query);
        $data->bindParam(":email", $email, PDO::PARAM_STR);
        $data->execute();

        $result = $data->fetch();

        return $result;
    }

    function emailConfirmation($email, $token){
        $header = 'Content-type: text/html; charset=utf-8';
        $msg = "Registrovali ste se na Gossip alert. Kliknite <a href='https://nemanjaant.com/models/accessRegulation/confirmation.php?token=$token'>ovde</a> za potvrdu vašeg naloga.";

         mail($email,"Registracija na Gossip alert",$msg, $header);
        
    }







?>