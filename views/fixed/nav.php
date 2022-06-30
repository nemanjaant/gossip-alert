
                

              

<nav id="navigation" class="mt-4">

         
                
<?php

try{

$queryLinks = "SELECT * FROM categories_menu WHERE idParent=0";        
$resultLinks = $conn->query($queryLinks);  
        
echo "<ul>";
foreach($resultLinks as $row)
{ 
    echo "<li><a href='".$row->path."&id=".$row->idCategory."'>".$row->categoryName."</a>"; 
    loadMenu($row->idCategory, $conn); 
    echo "</li>"; 
}         

echo "</ul>";
}

catch(PDOException $ex){
    
echo "<p>Pristup je trenutno onemogucen<p>";
}

?>

</nav>