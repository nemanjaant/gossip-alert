$(document).ready(function(){
    let nameAndSurnameReg = /^[A-Za-z]{1,20}(\s[A-Za-z]{1,20})*$/;
    let emailReg = /^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/;
    localStorage.setItem("activePage", JSON.stringify(0));
    

    //form processing
    $("#sendbtn").click(function(e){

        e.preventDefault();
        let name = $.trim($("#name").val());
        let surname = $.trim($("#surname").val());
        let email = $("#email").val();
        let infoagreement = $("#infoagreement");
        let message = $("#message").val();
        let errorSpans = $(".error");
      
        $(".error").each(function() {
            this.style.display="none";
            this.innerText="";
          });

        response.innerHTML="";
        

        let valid = true;
        
        if(!nameAndSurnameReg.test(name)){
            valid = false;
            errorSpans[0].style.display='block';
            errorSpans[0].innerText = "Pogrešno uneto ime.";
            
        }

        if(!nameAndSurnameReg.test(surname)){
            valid = false;
            errorSpans[1].style.display='block';
            errorSpans[1].innerText = "Pogrešno uneto prezime.";
        }

        if(!emailReg.test(email)){
            valid = false;
            errorSpans[2].style.display='block';
            errorSpans[2].innerText = "Pogrešno unet mejl.";
            
        }

        if (infoagreement.prop("checked") == false){
            valid = false;
            errorSpans[3].style.display='block';
            errorSpans[3].innerText = "Morate prihvatiti uslove obrade informacija.";
            
        }

        if (message.length==0){
            valid=false;
            errorSpans[4].style.display='block';
            errorSpans[4].innerText = "Poruka ne sme biti prazna.";
            
        }
        else if (message.length > 400){
            valid=false;
            errorSpans[4].style.display='block';
            errorSpans[4].innerText = "Poruka ne sme biti duža od 400 karaktera.";
        }

      

        else{
            infoagreement=true;
        }

        if(valid){
            let data = {
                "name":name,
                "surname":surname,
                "email":email,
                "infoagreement":infoagreement,
                "message":message,
                "btn":true
            }
            ajaxCallBack("models/visitorMessageProcessing.php","POST",data,function(result){
                response.innerHTML=`<p class="alert alert-info mt-3">${result.message}</p>`
            
                userMessages.reset();
            });
        }

        


    });

    //questionnaire
    $("#voteBtn").click(function(e){
        e.preventDefault();
        feedbackInfo.innerHTML = "";
        let answer = $("input[type='radio'][name='questionVote']:checked").val();

        let questionnaireID = $("#questionnaireForm").data("formid");
        
        
        if(answer==undefined){
            feedbackInfo.innerHTML = "<p class='alert alert-danger'>morate da izaberete par</p>";
        }

        else{
            let data = {
                "questionnaire":questionnaireID,
                "answer":answer
            }
            ajaxCallBack("models/questionnaireProcessing.php","POST",data,function(result){
                if(result.error==true){
                    feedbackInfo.innerHTML = `<p class="alert alert-danger">${result.message}</p>`;
                }
                else{
                    //prikaz rezultata
                    feedbackInfo.innerHTML = `<p class="alert alert-success">${result.message}</p>`;
                    
                    showQuestionnaireResults(result.data);
                }
            });
        }

    });

    
    
       //registration
       $(document).on('click', "#btnReg", function () {
        $("#response").html('');

        let errors = new Array();

        let name, lastName, email, username, passwd, passwdAgain;

        name =$.trim($("#regName").val());
        lastName = $.trim($("#regLastName").val());
        email = $.trim($("#regEmail").val());
        username = $.trim($("#regUsrnm").val());
        passwd = $("#regPasswd").val();
        passwdAgain = $("#regPasswdRpt").val();

        if (!nameAndSurnameReg.test(name)) errors.push("Pogresno uneto ime. Morate uneti bar 3 karaktera.");
        if (!nameAndSurnameReg.test(lastName)) errors.push("Pogresno uneto prezime. Morate uneti bar 3 karaktera.");
        if (!emailReg.test(email)) errors.push("Mejl nije unet u ispravnom formatu.");
        if (username.length < 6) errors.push("Korisnicko ime mora da ima barem 6 karaktera.")
        if (passwd.length < 6) errors.push("Lozinka mora da ima barem 6 karaktera.");
        if (passwd != passwdAgain) errors.push("Unete lozinke se ne poklapaju.");


        let html = '';

        if (errors.length > 0) {
            for (er of errors) {
                html += '<p>' + er + "</p>";
            }
            $("#response").html(html);
            $("#response").addClass("alert-danger");
        } else {

            data = {
                name: name,
                lastName: lastName,
                email: email,
                username: username,
                passwd: passwd
            }

            ajaxCallBack("models/accessRegulation/register.php", "post", data, function (result) {
                if (!result.errors) {
                    $('#response').html(`<p class="alert alert-success my-3">${result.message}</p>`);
                } 
                else {
                    
                    let html = `<p class="alert alert-danger mb-3">${result.message} `;
                    for (er of result.errors) {
                        
                        html += er+". ";
                    }
                    html+='</p>';
                   
                    response.innerHTML=html;
                }
            });
        }


    });


//login

$(document).on('click', '#btnLogin', function () {

    $("#response").html("");

    
    let error = new Array();
    let passwd;

    

    credential = $('#logCredential').val();
    passwd = $('#logPasswd').val();

    if (passwd.length < 6) error.push("Lozinka mora da ima barem 6 karaktera.");
    if(credential.length < 6) error.push("Pogresno uneto korisnicko ime ili e-mail.");

    let data = {
        credential:credential,
        passwd:passwd
    }

    if(error.length>0){
        html = '';
        for(er of error){
            html+=`<p class="alert alert-danger my-3">${er}</p>`
        }
        $('#response').html(html);
    }

    else{
        ajaxCallBack("models/accessRegulation/logging.php", "post", data, function (result) {
            
            if(result.success==false) {
                html = `<p class="alert alert-danger my-3">${result.message}</p>`
                $("#response").html(html);
            }

            else if (result.success==true) window.location="index.php";
    
        });
    }

    
});

//prikaz po paginaciji
$(document).on('click', ".pageNr", function (e) {
    e.preventDefault();

    let limit = handlePagination(this);
    
    let id = $("#pageNr").val();
    let searchString = $("#searchStr").val();
    let data = {}

    if(id!=undefined){
         data = {"limit":limit, "id":id};
         console.log(data)
         showByCategory(data);
    }
    else if (searchString!=undefined){
        data = {"limit":limit, "srchStr":searchString}
        showBySearchString(data);
    }
    



});

//pretraga

$(document).on('keypress', '#search', function (e) {
    
    if(e.key==="Enter"){

        let string = $("#search").val();
        window.location="https://nemanjaant.com/index.php?page=searchResults&string="+string;
       
    }
    
});

$(document).on('click', '#searchLnk', function (e) {
    e.preventDefault();

    let string = $("#search").val();
    window.location="https://nemanjaant.com/index.php?page=searchResults&string="+string;
        
       
    });
    
});

//Evidencija ocena za entitet

$(document).on("click", ".star", function(){
    let user, rate;
    
    user = $("#user").val();
    
    if(user==undefined){
        html = `<p class="alert alert-warning mt-2"><a href="index.php?page=login"><b>Ulogujte se</b></a>  da biste ostavili ocenu.</p>`;

        $(".reviewStars").parent().html(html);
    }

    else {
        rate = $(this).data('rate');
        
        entity = $("#entityDiv").data("entity");
        data = {
            entity:entity,
            user:user,
            rate:rate
        }

        ajaxCallBack("models/rateNews.php", "post", data, function(result){
            html = 'Prosečna ocena: ' + result.newAvg;
            $("#averageRateTxt").html(html);
        })
    }
});


//slanje komentara

$(document).on("keyup", "#userComment", function(){
    change(this);
});

$(document).on("click", "#sendComment", function(){
    $("#received").html('');
    let comment = $("#userComment").val();
    let entity = $("#entityDiv").data("entity");
    let data={
        comment:comment,
        entity:entity
    }
    ajaxCallBack("models/registerComments.php", "POST", data, function(result){
        html=`<p class="alert alert-success">${result.message}</p>`;
        $("#received").html(html);
    })
    
});

//odobravanje komentara sa admin stranice

$(document).on("click", ".approveComment", function(){
    let commentID = $(this).data('id');
    data = {
        id:commentID
    }
    ajaxCallBack('models/approveComments.php','post',data,function(){
        
        location.reload();
    });
});

//brisanje komentara sa admin stranice

$(document).on("click", ".deleteComment", function(){
    let commentID = $(this).data('id');
    data = {
        id:commentID
    }
    ajaxCallBack('models/deleteComment.php','post',data,function(){
        location.reload();
    });
});

$(document).on("click", ".readMsg", function(){
    let messageId = $(this).data('msgid');
    data = {
        id:messageId
    }
    ajaxCallBack('models/setReadMsg.php','post',data,function(){
        location.reload();
    });
});

//dodavanje potkategorije kad je izabrana kategorija

$(document).on("change", "#ddlCategory", function(){

    let category = $(this).val();
    let data = {"category":category}
    subcategories.innerHTML="";

    if(category!=5){
        ajaxCallBack("models/getSubcategories.php", "POST", data, function(result){
            options="<option disabled selected>-izaberite-</option>";
            
           for(res of result.subcategories){
                options+=`<option value="${res.idCategory}">${res.categoryName}</option>`
           }

           subcategories.innerHTML = options
           
        });
    }

});


//validacija i slanje podataka za upis u bazu

$(document).on("click", "#btnInsert", function(){
    $("#errors").html("");
    let data = new FormData();
    let errors = new Array();

    let parentCategory=$("#ddlCategory").val();
    let subCategory=$("#subcategories").val();

    if(parentCategory!=5){
        if(subCategory==undefined) errors.push("Nije izabrana kategorija");
    }
    

    title=$("#title").val();
    if(title=="") errors.push("Nije naveden naslov");

   

    let imageTitle=$("#imageTitle")[0].files[0];
    if(imageTitle==undefined) errors.push("Nije navedena naslovna fotografija");

    let imageText=$("#imageNews")[0].files[0];
    if(imageText==undefined) errors.push("Nije navedena fotografija za vest");
    
    
    
    let text=$("#newsText").val();
    if(text.length>600) errors.push("Tekst je duzi od 600 karaktera.");

    if(text.length<100) errors.push("Tekst je prekratak i nedovoljan za vest.");
    
    if(subCategory==null){
        subCategory=parentCategory
    }

    if(errors.length>0){
        html='';
        for(error of errors){
            html+=`<p class="alert alert-danger mt-2">${error}</p>`
        }

        $("#errors").html(html);
    }

    else {
        data.append("parentCategory", parentCategory);
        data.append("subCategory", subCategory);
        data.append("title", title);
       data.append("imageTitle", imageTitle);
       data.append("imageText", imageText);
        data.append("newsText", text);
        
     
        $.ajax({
            url: "models/insertNews.php",
            method: "POST",
            data: data,
            dataType: "json",
            contentType:false,
            processData: false,
            success:function (result) {
                console.log(result);
                insertForm.reset();
                
            },
            error: function (xhr) {
                console.log(xhr);
            }
        });
    }

});

$(document).on("click", ".deletion", function(){
    
    let id = $(this).data('entity');
    let data ={ id:id}
        
    ajaxCallBack('models/deleteNews.php','POST',data, function(result){
        location.reload();
        
    
    });
})

$(document).on("click", "#updateTitle", function(){
    let title = $("#newTitle").val();
    let id = $("#entity").val();
    if(title=='') alert("nedozvoljena vrednost");
    else{
    data = {
        title:title,
        id:id
    }
    
    ajaxCallBack('models/updateTitle.php','post',data, function(){
        
        location.reload();
    });
}
});


$(document).on("click", "#updateDesc", function(){
    let text = $("#newDesc").val();
    let id = $("#entity").val();
    if(text.length>900) alert("Tekst ne moze biti duzi od 900 karaktera.");
    else{
    data = {
        text:text,
        id:id
    }
    
    ajaxCallBack('models/updateNewsText.php','post',data, function(){
        
        location.reload();
    });
}
});


//unos horoskopa u bazu


$(document).on("click", "#btnInsertHoroscope", function(){
    $("#errors").html("");
    
    let errors = new Array();


    let title=$("#horoscopeText").val();
    if(title=="") errors.push("Nije unet tekst horoskopa");

    let zodiac = $("#ddlZodiacs").val();

    if(errors.length>0){
        html='';
        for(error of errors){
            html+=`<p class="alert alert-danger mt-2">${error}</p>`
        }

        $("#errors").html(html);
    }

    data = {
        "zodiac":zodiac,
        "title":title
    }

    ajaxCallBack("models/insertWeeklyHoroscope.php","POST",data,function(result){
        console.log(result);
        insertHoroscope.reset();
    });

});

//dodavanje odgovora na anketu

$(document).on("click", "#addResponse", function(e){
    e.preventDefault();

    moreResponses.innerHTML += '<input type="text" class="form-control newResponses">';
})


//upisivanje ankete u bazu

$(document).on("click", "#addnewQuestionnaire", function(e){
    e.preventDefault();

    let title = $("#newQuestionnaireName").val();
    let responsesTags = $(".newResponses");
    let responses = new Array();

    for(response of responsesTags){
        responses.push(response.value);
    }

    data = {
        "title":title,
        "responses":responses
    }

    ajaxCallBack("models/insertNewQuestionnaire.php","POST",data,function(result){
        console.log(result);
        newQuestionnaire.reset();
        location.reload();
    });

   
});

//aktiviranje druge ankete

$(document).on("click", "#activate", function(e){
    e.preventDefault();

    let active = $("#activeQ").data("active");
    let newActive = $("#nonActive").val();
    

    data = {
        "active":active,
        "newActive":newActive
    }

    ajaxCallBack("models/activateQuestionnaire.php","POST",data,function(result){
        console.log(result);
        location.reload();
    });


   
})


//slider JS
try{

let slides = document.getElementsByClassName("slider__slide");
let navlinks = document.getElementsByClassName("slider__navlink");
let currentSlide = 0;

document.getElementById("nav-button--next").addEventListener("click", () => {
    changeSlide(currentSlide + 1)
});
document.getElementById("nav-button--prev").addEventListener("click", () => {
    changeSlide(currentSlide - 1)
});

function changeSlide(moveTo) {
    if (moveTo >= slides.length) {moveTo = 0;}
    if (moveTo < 0) {moveTo = slides.length - 1;}
    
    slides[currentSlide].classList.toggle("active");
    navlinks[currentSlide].classList.toggle("active");
    slides[moveTo].classList.toggle("active");
    navlinks[moveTo].classList.toggle("active");
    
    currentSlide = moveTo;
}

document.querySelectorAll('.slider__navlink').forEach((bullet, bulletIndex) => {
    bullet.addEventListener('click', () => {
        if (currentSlide !== bulletIndex) {
            changeSlide(bulletIndex);
        }
    })
})

}

catch{
    
}


