function ajaxCallBack(url, method, data=null, result){
    $.ajax({
        url: url,
        method: method,
        dataType: "json",
        data: data,
        success: result,
        error: function(xhr){
            console.log(xhr);}
    });
}

function showQuestionnaireResults(data){

    let spanTags = document.getElementsByClassName("result");

    for(let i=0; i<spanTags.length; i++){
        spanTags[i].innerText = "Broj glasova: " + data[i].totalVotes;
        spanTags[i].style.display = "block";
    }
    
}

function handlePagination(element){
    let active = $(".active");
    let limit = $(element).data("limit");
    localStorage.setItem("activePage", JSON.stringify(limit));   
    active.removeClass("active");

    return limit;
}


function printData(data){
    let html = "";
        for(let obj of data){
            html += `
            <div class="col-4">
            <a href="index.php?page=newsArticle&id=${obj.idNews}"><h3>${obj.newsTitle}</h3></a>
            <a href="index.php?page=newsArticle&id=${obj.idNews}"><img src="${obj.imgSrc}" alt="Photo of news item ${obj.newsTitle}" class="img-fluid"></a>
            <p>${obj.newsText.substring(0, 70)}...</p>

        </div>`;
            displayData.innerHTML = html;
}}

function printPagination(pageNr){
    
    let html = '';

    //prethodno sacuvani podatak o aktivnoj stranici u LS se dohvata kako bi se u ispisivanju dodala klasa active
    activePage = localStorage.getItem("activePage");
    

    if(activePage=='""'||activePage==null) activePage=0;
    

    for(let i=0; i<pageNr;i++){

        if(i==activePage){
            html+=`
        <li class="page-item">
        <a class="page-link pageNr active" href="#" data-limit="${i}">${i+1}</a>
    </li>`;
        }
        else{
        html+=`
        <li class="page-item">
        <a class="page-link pageNr" href="#" data-limit="${i}">${i+1}</a>
    </li>`;
}
    }
    $("#paginationList").html(html);
}


function showByCategory(data){
    
    
    ajaxCallBack("models/categoriesProcessing/getNewsByCategory.php","POST",data,function(result){
        printData(result.news);
        printPagination(result.pages);
        
    })

        
};

function showBySearchString(data){
    ajaxCallBack("models/categoriesProcessing/getNewsBySearchString.php","POST",data,function(result){
        printData(result.news);
        printPagination(result.pages);
        console.log(result);
    })
}

function change(el) {
    var max_len = 350;
    if (el.value.length > max_len) {
    el.value = el.value.substr(0, max_len);
    }
    document.getElementById('char_cnt').innerHTML = el.value.length;
    document.getElementById('chars_left').innerHTML = max_len - el.value.length;
    return true;
 }