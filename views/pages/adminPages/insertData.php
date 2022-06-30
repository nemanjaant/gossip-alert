
<h2 class="text-center">Dodaj vest</h2>
<hr>

<form id="insertForm">
    

    <div class="form-row mb-5">
        <div class="form-group col-8">
            <label for="">Naslov</label>
            <input type="text" name="title" id="title" class="form-control" />
        </div>
    </div>
    <?php 
$categories = getParentCategories();
   
    
?>
    <div class="form-row mb-5">
        <div class="form-group col-6">
            <label for="">Kategorija</label>
            <select name="ddlCategory" id="ddlCategory" class="form-control">
                <option disabled selected>-izaberite-</option>
                <?php foreach($categories as $cat): ?>
                
                <option value="<?=$cat->idCategory?>"><?=$cat->categoryName?></option>
                
                 <?php endforeach; ?>
            </select>
        </div>
    
        
            <div class="form-group col-6">
                <label for="">Potkategorija</label>
                <select name="ddlTypes" id="subcategories" class="form-control">

                </select>
            </div>
        
    </div>

    <div class="form-row mb-5">
        <div class="form-group col-6">
            <label>Naslovna slika</label>
            <input type="file" class="form-control" id="imageTitle"/>
        </div>
        <div class="form-group col-6">
            <label>Slika za vest</label>
            <input type="file" class="form-control" id="imageNews"/>
        </div>
    </div>
    
    <div class="form-group">
        <label for="newsText">Tekst</label>
        <textarea name="newsText" id="newsText" class="form-control" rows="15"></textarea>
    </div>
    <div id="errors">

    </div>
    <div class="form-group text-center">
        <input type="button" value="Unos" id="btnInsert" class="btn btn-primary mt-5">
    </div>

</form>