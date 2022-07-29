$(function(){$(".theme-switcher").on("click",function(){$(".all-themes-colors").toggleClass("active")});$(document).on("click",function(e){if(!$(e.target).closest(".theme-switcher").length){$(".all-themes-colors").removeClass("active")}});$(".color-item").on("click",function(){const color=$(this).attr("data-theme");let bodyClasses=$("body").attr("class").split(" ");let classToRemove=bodyClasses.find((cla)=>cla.match("theme-"));$("body").removeClass(classToRemove);$("body").addClass("theme-"+color);localStorage.setItem("theme",color)});const themeColor=localStorage.getItem("theme");if(themeColor){$("body").addClass("theme-"+themeColor)}});
$(document).ready(function(){
    $('.popup-youtube').magnificPopup({
        type: 'iframe',
    });
    $('.popup-images').magnificPopup({
        type: 'image',
        closeBtnInside: true,
        mainClass: 'mfp-img',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
        },
    });

    // console.log('nahi aayaa yhaaa');
    $('p').each(function(i, value){
        if(!$(this).text().trim()){
            $(this).remove();
        }
    });

    $(".my-class").slick({
        infinite: true,
        slidesToShow: 2,
        slidesToScroll: 1,
        dots: true,
        autoplay: true,
        autoplaySpeed: 1000,
        arrows: true,
        pauseOnHover: true,
    });
    $('.update').slick({
        dots: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 2000,
        pauseOnHover: false,
        pauseOnFocus: false,
        arrows: false,
        margin:10,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 1
            }
        }]
    });
})

//Phone number validation
function phonenumber(phone, e, id){
    var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    $(e).parent().find('.validation').remove();
    if((phone.match(phoneno))){
        $("#checkError").val("0");
        $(e).parent().find('.validation').remove();
    }else{
        $("#checkError").val("1");
        $("#"+id).parent().append("<span class='text-danger validation'>Please valid phone number.</span>");
    }
}

$("#number").keyup(function(){
    //$(this).parent().find('.validation').remove();
    var phone = $("#number").val().replace(/ /g,''); 
    phonenumber(phone, this, 'number');
});

$("#userPhone").keyup(function(){
    var phone = $("#userPhone").val().replace(/ /g,''); 
    phonenumber(phone, this, 'userPhone');
});



$("#sendMessage").click(function(){
    $(".validation").remove();
    let flag    = true;
    
    let name    = $("#userName").val();
    let number  = $("#userPhone").val(); 
    let email   = $("#userEmail").val(); 
    let message = $("#userMessage").val();
    if(name==""){
        flag = false;
        $("#userName").parent().append("<span class='text-danger validation'>Please enter your name.</span>");
    }
    if(number==""){
        flag = false;
        $("#userPhone").parent().append("<span class='text-danger validation'>Please enter your number.</span>");
    }
    if($("#checkError").val()=="1"){
        flag = false;
        $("#userPhone").parent().append("<span class='text-danger validation'>Please enter valid number.</span>");
    }
    if(message==""){
        flag = false;
        $("#userMessage").parent().append("<span class='text-danger validation'>Please enter your message.</span>");
    }
    if(email==""){
        flag = false;
        $("#userEmail").parent().append("<span class='text-danger validation'>Please enter your email.</span>");
    }
    if(email!=""){
        if(!ValidateEmail(email)){
            flag = false;   
            $("#userEmail").parent().append("<span class='text-danger validation'>Please enter valid email.</span>");
        }
    }
    console.log($("#checkError").val());
    console.log(flag);
    if(flag && $("#checkError").val()=="0"){
        $("#sendMessage").prop("disabled", true);
        let url = $("#baseUrl").val()+"/contact/inquiry";
        $.ajax({
            url     : url,
            type    : "post",
            data    : {
                "name"    : name,
                "number"  : number,
                "email"   : email, 
                "message" : message,
            },
            success:function(data){
                $("#sendMessage").prop("disabled", false);
                data = JSON.parse(data);
                if(data.status){

                    $("#userName").val("");
                    $("#userPhone").val("");
                    $("#userEmail").val("");
                    $("#userMessage").val("");
                    $("#sendMessage").parent().parent().append("<div class='text-center'><span class='text-success validation'>"+data.msg+"</span></div>");
                }
            },error:function(){
                $("#sendMessage").prop("disabled", false);
            }
        });
    }
});

$("#userName").keyup(function(){
    $(this).parent().find('.validation').remove();
});
$("#userEmail").keyup(function(){
    $(this).parent().find('.validation').remove();
});
$("#userMessage").keyup(function(){
    $(this).parent().find('.validation').remove();
});

function ValidateEmail(mail) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)){
        return true;
    }
    return false;
}

$("#sendMsg").click(function(){
    $(".validation").remove();
    let flag    = true;
    let name    = $.trim($("#name").val());
    let number  = $.trim($("#number").val()); 
    let message = $.trim($("#message").val());
    let enqEmail = $.trim($("#enqEmail").val());
    if(name==""){
        flag = false;
        $("#name").parent().append("<span class='text-danger validation'>Please enter your name.</span>");
    }
    if(number==""){
        flag = false;
        $("#number").parent().append("<span class='text-danger validation'>Please enter your number.</span>");
    }
    if($("#checkError").val()=="1"){
        flag = false;
        $("#number").parent().append("<span class='text-danger validation'>Please enter valid number.</span>");
    }
    if(message==""){
        flag = false;
        $("#message").parent().append("<span class='text-danger validation'>Please enter your message.</span>");
    }
    if(enqEmail==""){
        flag = false;
        $("#enqEmail").parent().append("<span class='text-danger validation'>Please enter your email.</span>");
    }
    if(enqEmail!=""){
        if(!ValidateEmail(enqEmail)){
            flag = false;
            $("#enqEmail").parent().append("<span class='text-danger validation'>Please enter valid email.</span>");
        }
    }

    if(flag && $("#checkError").val()=="0"){
        let url = $("#baseUrl").val()+"/contact/send-inquiry";
        $.ajax({
            url     : url,
            type    : "post",
            data    : {
                "name"    : name,
                "number"  : number,
                "message" : message,
                "email"   : enqEmail,
            },
            success:function(data){
                data = JSON.parse(data);
                if(data.status){
                    $("#name").val("");
                    $("#number").val("");
                    $("#message").val("");
                    $("#enqEmail").val("");
                    $("#message").parent().append("<span class='text-success validation'>"+data.msg+"</span>");
                }
            },error:function(){

            }
        });
    }
});

$('#inquiryModal').on('hidden.bs.modal', function (e) {
    $(".validation").remove();
})

function testimonialModal(val) {
    $("#modalBody").append(atob(val));
    $("#testimonialModalShow").modal("show");
}

$(document).on('click', '.testimonialModalClose', function () {
    $("#testimonialModalShow").modal("hide");
});

