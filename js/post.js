var idPost = "";
var jPost = document.querySelectorAll(".post-index-button");
let functionPage = document.querySelector(".function-fixed");
var url = document.querySelector("#url");
var account_id;
$(document).on('click', '.post-index-button', function (e) {
    let id = $(this).attr("data-id");
    account_id = $(this).attr("data-u");
    idPost = id;
    functionPage.classList.add("function-open");
    url.value = BASE_URL + "/app/post/view.php?id=" + id;
    $.ajax({
        url: BASE_URL+"/app/profile/ajax-follow-text.php",
        type: 'get',
        dataType: 'json',
        cache: false,
        data : {
            id : account_id
        },
        success: function(result){
            if(result != null){
                if(result.data == 0){
                    $(".follow-option").html('Follow');
                }
                else{
                    $(".follow-option").html('Unfollow');
                }
            }
        },
        error: function(){
            alert("Error...");
        }
    });
});
// close function page
function closeFunction() {
    if (functionPage) {

        functionPage.classList.remove("function-open");
    }
}
if (functionPage) {
    functionPage.addEventListener('click', (e) => {
        if (e.target.classList.contains("function-fixed") || e.target.classList.contains("btn-huy")) {
            closeFunction();
        }
    });
}
// function report
function reportPost() {
    closeFunction();
    console.log(idPost);
    $.ajax({
        url: BASE_URL+"/app/post/ajax-report.php",
        type: 'get',
        dataType: 'json',
        cache: false,
        data: {
            id: idPost
        },
        success: function(result){
            if(result != null){
                if(result.data == true){
                    Swal.fire(
                        'Thanks for letting us know',
                        'Your feedback is important in helping us keep the Instagram community safe',
                        'success'
                    );
                }
                else{
                    Swal.fire(
                        'Error',
                        'Occur errors when reporting this post',
                        'error'
                    );
                }
            }
        },
        error: function(){
            Swal.fire(
                'Error',
                'Occur errors when reporting this post',
                'error'
            );
        }
    });
}
// function go to post
function gotoPost() {
    window.location.href = url.value;
}
// function copy link
$(document).on('click','.copy-option',function(e){
    e.preventDefault();
    /* Get the text field */
    var copyText = document.querySelector("#url");
    navigator.clipboard.writeText(copyText.value);
    $(".modal").removeClass('open');
    /* Alert the copied text */
    appearPopup();
    closeFunction();

});

function appearPopup() {
    var pop = document.querySelector(".pop-up");
    pop.classList.add("pop-up-open");
    setTimeout(function () {
        closePopup();
    }, 3000);
}
// function close pop up
function closePopup() {
    var pop = document.querySelector(".pop-up");
    pop.classList.remove("pop-up-open");
}
//============ Upload Preview Media
$("#filePhoto").on('change', function () {

    $('#previewImage').html('');
    var total_file = document.getElementById("filePhoto").files.length;
    for (var i = 0; i < total_file; i++) {
        $('#previewImage').append("<img src='" + URL.createObjectURL(event.target.files[i]) + "' width='45' class='rounded'>");
    }
});
// follow option
$(document).on('click','.follow-option',function(e){
    openCloseSpiner(true);
    $.ajax({
        url: BASE_URL+"/app/profile/ajax-follow.php",
        type: 'get',
        dataType: 'json',
        cache: false,
        data : {
            id : account_id
        },
        success: function(result){
            openCloseSpiner(false);
            $(".follow-option").html(result.data);
        },
        error: function(){
            alert("Error when handling follow process..");
        }
    });
});
// share post
// modal
$(document).on('click','.modal-option',function(e){
    closeFunction();
    $(".modal").addClass("open");
    $(".modal-title").html("Share to");
    $("html").css("overflow","hidden");
    $.ajax({
        url: BASE_URL+"/app/post/share.php",
        type: 'get',
        dataType: 'text',
        cache: false,
        data : {
            id : idPost
        },
        success: function(result){
            $(".modal-body").html(result);
        },
        error: function(){
            alert("Error occur when sharing this post...");
        }
    });
});