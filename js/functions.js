// ================== LIKE POST ==============
$(document).on('click', '.likeButton', function (e) {
    var element = $(this);
    var id = element.attr("data-like");
    var data = '?id=' + id;
    $.ajax({
        url: BASE_URL + "/app/post/ajax-like.php" + data,
        type: 'GET',
        dataType: 'json',
        cache: false,
        data: {
            id: id
        },
        success: function (result) {
            if (result != null) {
                if (result.data == "like") {
                    element.find("i").removeClass("far fa-heart").addClass("fas fa-heart red");
                }
                else {
                    element.find("i").removeClass("fas fa-heart red").addClass("far fa-heart");
                }
                $("#numLike" + id).html(result.countLike);
            }
        },
        error: function () {
            alert("Error...");
        }
    });
});

// =================== SAVE POST =================
$(document).on('click', '.post-count-img', function (e) {
    var element = $(this);
    var id = $(this).attr('data-saved');
    $.ajax({
        url: BASE_URL + "/app/post/ajax-save-post.php",
        type: 'get',
        dataType: 'json',
        cache: false,
        data: {
            id: id
        },
        success: function (result) {
            if (result.data != false) {
                if (result.data == "saved") {
                    createNoti("Saved this post success !");
                    element.find("i").removeClass("far fa-bookmark").addClass("fas fa-bookmark");
                }
                else {
                    createNoti("Unsaved this post success !");
                    element.find("i").removeClass("fas fa-bookmark").addClass("far fa-bookmark");
                }
            }
        },
        error: function () {
            alert("Error");
        }
    });

});
// ================= COMMENT ====================
$(document).on('click', '.btn-cmt', function (e) {
    e.preventDefault();
    var element = $(this);
    var id = element.attr("data-cmt");
    var msg = $("#msg" + id).val();
    $("#msg" + id).val("");
    if(!msg.trim()){
        createNoti("Please enter message to comment about this post !");
        return false;
    }
    $("#chat" + id).css('opacity','0.5');
    $.ajax({
        url: BASE_URL + "/app/post/ajax-cmt.php",
        type: 'post',
        dataType: 'json',
        cache: false,
        data: {
            id: id,
            msg: msg
        },
        success: function (result) {
            if (result != null) {
                if (result.length != 0) {
                    var chatDiv = document.createElement("div");
                    chatDiv.classList.add("post-index-text");
                    var chatAuthor = document.createElement("span");
                    chatAuthor.classList.add("post-text-author");
                    var linkAuthor = document.createElement("a");
                    linkAuthor.setAttribute("href", result.data.account_id);
                    linkAuthor.innerHTML = result.data.username;
                    chatAuthor.append(linkAuthor);
                    var chatContent = document.createElement("span");
                    chatContent.classList.add("post-text-content");
                    chatContent.innerText = result.data.cmt_msg;
                    chatDiv.append(chatAuthor);
                    chatDiv.append(" ");
                    chatDiv.append(chatContent);
                    $("#chat" + id).append(chatDiv);
                }
            }
            $("#chat" + id).css('opacity','1');
            $("#msg" + id).val("");
        },
        error: function () {
            alert("Error........");
        }
    });
});
/// enter
$(document).on('keypress', '.cmt-index', function (e) {
    if (e.which == 13) {
        var msg = this.value;
        this.value = "";
        var postId = $(this).attr("id").substr(3);
        if(!msg.trim()){
            createNoti("Please enter message to comment about this post !");
            return false;
        }
        $("#chat" + postId).css('opacity', '0.5');
        $.ajax({
            url: BASE_URL + "/app/post/ajax-cmt.php",
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                id: postId,
                msg: msg
            },
            success: function (result) {
                if (result != null) {
                    if (result.length != 0) {
                        var chatDiv = document.createElement("div");
                        chatDiv.classList.add("post-index-text");
                        var chatAuthor = document.createElement("span");
                        chatAuthor.classList.add("post-text-author");
                        var linkAuthor = document.createElement("a");
                        linkAuthor.setAttribute("href", result.data.account_id);
                        linkAuthor.innerHTML = result.data.username;
                        chatAuthor.append(linkAuthor);
                        var chatContent = document.createElement("span");
                        chatContent.classList.add("post-text-content");
                        chatContent.innerText = result.data.cmt_msg;
                        chatDiv.append(chatAuthor);
                        chatDiv.append(" ");
                        chatDiv.append(chatContent);
                        $("#chat" + postId).append(chatDiv);
                    }
                }
                $("#chat" + postId).css('opacity', '1');
                $("#msg" + postId).val("");
            },
            error: function () {
                alert("Error........");
            }
        });
    }
});
// =================== load more comment =================
var skip = 10;
$(document).on('click', '.load-more', function () {
    var data_load = $(this).attr("data-load");
    var element = $(this);
    $(".loading").css('display', 'block');
    $.ajax({
        url: BASE_URL + "/app/post/ajax-load-more-cmt.php",
        type: 'post',
        dataType: 'json',
        cache: false,
        data: {
            id: data_load,
            skip: skip
        },
        success: function (result) {
            if (result.data.length === 0 || result.data.length < 10) {
                element.fadeOut(300);
            }
            $(".loading").css('display', 'none');
            skip += 10;
            $.each(result.data, function (index, cmt) {
                var divTalk = document.createElement("div");
                divTalk.classList.add("article-talk-item");
                var talkAvatar = document.createElement("div");
                talkAvatar.classList.add("talk-avatar");
                talkAvatar.innerHTML = "<a href=''><img src='" + BASE_URL + cmt.avatar + "'></a></a>";
                var talkContent = document.createElement("div");
                talkContent.classList.add("talk-content");
                talkContent.innerHTML = "<h3><a href=''>" + cmt.username + "</a></h3> ";
                talkContent.innerHTML += "<span>" + cmt.cmt_msg + "</span>";
                var date = moment(parseInt(cmt.cmt_date) * 1000).format("DD MMM YYYY hh:mm a") //parse integer
                talkContent.innerHTML += "<div class='talk-times'><time class='times'>" + date + "</time></div>";
                divTalk.appendChild(talkAvatar);
                divTalk.appendChild(talkContent);
                $(".result").append(divTalk);
            });
        },
        error: function () {
            alert("Error");
        }
    });
});

// ================ comment on view post ==================
// json
function resultJsonCmt(result) {
    $(".article-talk").css('opacity', '1');
    $(".article-input").val("");
    var myResult = document.querySelector('.result');
    var divTalk = document.createElement("div");
    divTalk.classList.add("article-talk-item");
    var talkAvatar = document.createElement("div");
    talkAvatar.classList.add("talk-avatar");
    talkAvatar.innerHTML = "<a href=''><img src='" + BASE_URL + result.data.avatar + "'></a></a>";
    var talkContent = document.createElement("div");
    talkContent.classList.add("talk-content");
    talkContent.innerHTML = "<h3><a href=''>" + result.data.username + "</a></h3> ";
    talkContent.innerHTML += "<span>" + result.data.cmt_msg + "</span>";
    talkContent.innerHTML += "<div class='talk-times'><time class='times'>" + result.data.cmt_date + "</time></div>";
    divTalk.appendChild(talkAvatar);
    divTalk.appendChild(talkContent);
    myResult.prepend(divTalk);
}
// enter
$(document).on('keypress', '.article-input', function (e) {
    if (e.which == 13) {
        $(".article-talk").css('opacity', '0.5');
        var msg = this.value;
        var postId = $(this).attr("data-post");
        $("#msgChat").val("");
        $.ajax({
            url: BASE_URL + "/app/post/ajax-cmt.php",
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                id: postId,
                msg: msg
            },
            success: function (result) {
                resultJsonCmt(result);

            },
            error: function () {
                alert("Occur error.");
            }
        });
    }
});
// submit
$("#submitChat").submit(function () {
    var msg = $("#msgChat").val();
    var id = $("#msgChat").attr("data-post");
    $("#msgChat").val("");
    $(".article-talk").css('opacity', '0.5');
    $.ajax({
        url: BASE_URL + "/app/post/ajax-cmt.php",
        type: 'post',
        dataType: 'json',
        cache: false,
        data: {
            id: id,
            msg: msg
        },
        success: function (result) {
            resultJsonCmt(result);

        },
        error: function () {
            alert("Occur error.");
        }
    });
    return false;
});
// ================ Follow account ===================
$(document).on('click', '.follow-request', function (e) {
    e.preventDefault();
    var element = $(this);
    var idUser = $(this).attr("data-u");
    element.html("Waiting...");
    $.ajax({
        url: BASE_URL + "/app/profile/ajax-follow.php",
        type: 'get',
        dataType: 'json',
        cache: false,
        data: {
            id: idUser
        },
        success: function (result) {
            element.html(result.data);
        },
        error: function () {
            alert("Occur error.");
        }
    });
});
// =============== scroll more post ==================
$(document).ready(function () {
    $(window).scroll(function () {
        $element = $(".box-view");
        $loadding = $('#loading');
        if ($(window).scrollTop() + $(window).height() >= $element.height()) {
            if (is_busy == true) {
                return false;
            }
            if (stopped == true) {
                return false;
            }
            is_busy = true;
            page++;
            $loadding.removeClass('hidden');
            // send Ajax
            $.ajax(
                {
                    type: 'post',
                    dataType: 'text',
                    url: BASE_URL + '/app/post/ajax-load-more-post.php',
                    cache: false,
                    data: { page: page },
                    success: function (result) {
                        $(".box-view").append(result);
                        $('.post-index-img').not('.slick-initialized').slick({
                            dots: true,
                            infinite: false,
                            speed: 300,
                        });
                    },
                    error: function () {
                        alert("error when load post");
                    }
                })
                .always(function () {
                    $loadding.addClass("hidden");
                    is_busy = false;
                });
            return false;
        }
    });
});

// loop for notification
function createNoti(msg){
    var divFixed = document.querySelector('.noti-fixed');
    var notiContent = document.createElement("div");
    notiContent.classList.add("noti-content");
    notiContent.innerHTML = msg;
    divFixed.appendChild(notiContent);
    setTimeout(function(){
        notiContent.style.transform = 'translateY(100px) rotate(20deg)';
        notiContent.style.transition = 'all ease 1s';
        notiContent.style.opacity = '0';
    },3000);
}
// open view function
$(document).on('click','.article-action-btn',function(e){
    idPost = $(this).attr("data-id");
    url.value = BASE_URL + "/app/post/view.php?id=" + idPost;
    user = $(this).attr("data-u");
    account_id = user;
    $.ajax({
        url: BASE_URL+"/app/profile/ajax-follow-text.php",
        type: 'get',
        dataType: 'json',
        cache: false,
        data : {
            id : user
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
    $(".function-fixed").addClass("function-open");
});
// show edit post
$(document).on('click','.edit-option',function(e){
    closeFunction();
    openCloseSpiner(true);
    $("html").css('overflow','hidden');
    $.ajax({
        url: BASE_URL+"/app/post/edit-post-ajax.php?do=show",
        type: 'post',
        dataType: 'text',
        cache: false,
        data : {
            id : $("#post").val()
        },
        success: function(result){
            openCloseSpiner(false);
            if(result != null){
                $(".modal").addClass("open");
                $(".modal-title").html('Edit my post');
                $(".modal-body").html(result);
            }
        },
        error: function(){
            openCloseSpiner(false);
            alert("Occur error when request to server to edit this post..");
        }
    });
});
$(document).on('click','.btn-save-option',function(e){
    e.preventDefault();
    $(".modal").removeClass("open");
    openCloseSpiner(true);
    $.ajax({
        url: BASE_URL+"/app/post/edit-post-ajax.php?do=save",
        type: 'post',
        dataType: 'json',
        cache: false,
        data : {
            id : $("#post").val(),
            msg: $("#msgEdit").val()
        },
        success: function(result){
            console.log(result);
            openCloseSpiner(false);
            if(result != null){
                if(result.data == false){
                    Swal.fire({
                        icon: 'error',
                        text: 'Something went wrong! Cannot save this post'
                    });
                }
                else{
                    $("#msgView").html($("#msgEdit").val());
                    Swal.fire({
                        icon: 'success',
                        text: 'Saved this post success!',
                      });
                }
            }

        },
        error: function(){
            openCloseSpiner(false);
            alert("Error occur when save this post..");
        }
    })
    .always(function(){
        $("html").css('overflow','');
    });
});
// view followers
var fl_page = 1;
$(document).on('click','.aj-followers',function(e){
    e.preventDefault();
    fl_page = 1;
    stopped = false;
    $("html").css('overflow','hidden');
    $(".modal").addClass("open");
    $(".modal-title").html("Followers");
    var flList = document.createElement("ul");
    flList.classList.add("list-followers");
    $(".modal-body").html(flList);
    $(".modal-body").attr("id","load-fl");
    $div = $("<div/>");
    $div.addClass("center");
    $div.attr("id","loading");
    $div.html('<img src="'+BASE_URL+'/public/images/loading.gif" width="70" alt="">');
    $(".list-followers").append($div);
    $.ajax({
        url: BASE_URL+"/app/profile/ajax-get-followers.php",
        type: 'get',
        dataType: 'text',
        cache: false,
        data: {
            id : $("#accountID").val(),
        },
        success: function(result){
            $(".list-followers").html(result);
            $(".list-followers").css("margin-bottom","30px");
        },
        error: function(){
            alert("Occur error when view followers");
        }
    })
});
// view following
$(document).on('click','.aj-following',function(e){
    fl_page = 1;
    stopped = false;
    $("html").css('overflow','hidden');
    $(".modal").addClass("open");
    $(".modal-title").html("Following");
    var flList = document.createElement("ul");
    flList.classList.add("list-followers");
    $(".modal-body").html(flList);
    $(".modal-body").attr("id","load-following");
    $div = $("<div/>");
    $div.addClass("center");
    $div.attr("id","loading");
    $div.html('<img src="'+BASE_URL+'/public/images/loading.gif" width="70" alt="">');
    $(".list-followers").append($div);
    $.ajax({
        url: BASE_URL+"/app/profile/ajax-get-following.php",
        type: 'get',
        dataType: 'text',
        cache: false,
        data: {
            id : $("#accountID").val(),
        },
        success: function(result){
            $(".list-followers").html(result);
            $(".list-followers").css("margin-bottom","30px");
        },
        error: function(){
            alert("Occur error when view followers");
        }
    })
});
// scroll see more followers
document.addEventListener('scroll', function (event) {
    if (event.target.id === 'load-fl') { // view follower  
        $element = $(".modal-body");
        if ($element.scrollTop() + $element.height() >= $(".list-followers").height()-50) {
            if (is_busy == true) {
                return false;
            }
            if (stopped == true) {
                return false;
            }
            is_busy = true;
            fl_page++;
            $div = $("<div/>");
            $div.addClass("center");
            $div.attr("id","loading");
            $div.html('<img src="'+BASE_URL+'/public/images/loading.gif" width="70" alt="">');
            $(".list-followers").append($div);
            $.ajax({
                url: BASE_URL+"/app/profile/ajax-get-followers.php",
                type: 'get',
                dataType: 'text',
                cache: false,
                data: {
                    id : $("#accountID").val(),
                    page : fl_page
                },
                success: function(result){
                    $div.css('display','none');
                    $(".list-followers").append(result);
                },
                error: function(){
                    alert("Occur error when view followers");
                }
            })
            .always(function(){
                is_busy = false;
            });
            return false;
        }
    }
    if (event.target.id === 'load-following') { // view following      
        $element = $(".modal-body");
        if ($element.scrollTop() + $element.height() >= $(".list-followers").height()-50) {
            if (is_busy == true) {
                return false;
            }
            if (stopped == true) {
                return false;
            }
            is_busy = true;
            fl_page++;
            $div = $("<div/>");
            $div.addClass("center");
            $div.attr("id","loading");
            $div.html('<img src="'+BASE_URL+'/public/images/loading.gif" width="70" alt="">');
            $(".list-followers").append($div);
            $.ajax({
                url: BASE_URL+"/app/profile/ajax-get-following.php",
                type: 'get',
                dataType: 'text',
                cache: false,
                data: {
                    id : $("#accountID").val(),
                    page : fl_page
                },
                success: function(result){
                    $div.css('display','none');
                    $(".list-followers").append(result);
                },
                error: function(){
                    alert("Occur error when view followers");
                }
            })
            .always(function(){
                is_busy = false;
            });
            return false;
        }
    }
}, true);
// view more post of account
var v_page = 1;
$(document).ready(function () {
    $(window).scroll(function () {
        $element1 = $("#your-account-post");
        $loadding = $('#loading');
        if ($(window).scrollTop() + $(window).height() >= $element1.height()) {
            if (is_busy == true) {
                return false;
            }
            if (stopped == true) {
                return false;
            }
            is_busy = true;
            v_page++;
            $loadding.removeClass('hidden');
            // send Ajax
            $.ajax(
                {
                    type: 'get',
                    dataType: 'text',
                    url: BASE_URL + '/app/post/ajax-see-more-post.php',
                    cache: false,
                    data: { 
                        id: $("#accountID").val(),
                        page: v_page 
                    },
                    success: function (result) {
                        $element1.append(result);
                    },
                    error: function () {
                        alert("error when load post");
                    }
                })
                .always(function () {
                    $loadding.addClass("hidden");
                    is_busy = false;
                });
            return false;
        }
    });
});
// view saved post
$(document).ready(function () {
    $(window).scroll(function () {
        $element2 = $("#account-saved-post");
        $loadding = $('#loading');
        if ($(window).scrollTop() + $(window).height() >= $element2.height()) {
            if (is_busy == true) {
                return false;
            }
            if (stopped == true) {
                return false;
            }
            is_busy = true;
            v_page++;
            $loadding.removeClass('hidden');
            // send Ajax
            $.ajax(
                {
                    type: 'get',
                    dataType: 'text',
                    url: BASE_URL + '/app/post/ajax-load-save-post.php',
                    cache: false,
                    data: { 
                        id: $("#accountID").val(),
                        page: v_page 
                    },
                    success: function (result) {
                        $element2.append(result);
                    },
                    error: function () {
                        alert("error when load post");
                    }
                })
                .always(function () {
                    $loadding.addClass("hidden");
                    is_busy = false;
                });
            return false;
        }
    });
});
// delete post
$(document).on('click','.del-option',function(e){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            closeFunction();
            $.ajax({
                url: BASE_URL+"/app/post/ajax-del-post.php",
                type: 'get',
                dataType: 'json',
                data: {
                    id: $("#post").val()
                },
                success: function(result){
                    if(result != null)
                    {
                        if(result.data == true){
                            Swal.fire(
                                'Deleted!',
                                'Your post has been deleted.',
                                'success'
                            );
                            setTimeout(function(){
                                window.location.href = BASE_URL+'/app/profile';
                             }, 2000);
                        }
                        else{
                            Swal.fire(
                                'Error!',
                                'Cannot handling your request.',
                                'error'
                            );
                        }
                    }
                },
                error: function(){
                    alert("Occur error when request...");
                }
            });
        }
      });
});
// explore scroll
$(document).ready(function () {
    $(window).scroll(function () {
        $element3 = $("#load-explore");
        $loadding = $('#loading');
        if ($(window).scrollTop() + $(window).height() >= $element3.height()) {
            if (is_busy == true) {
                return false;
            }
            if (stopped == true) {
                return false;
            }
            is_busy = true;
            v_page++;
            $loadding.removeClass('hidden');
            // send Ajax
            $.ajax(
                {
                    type: 'get',
                    dataType: 'text',
                    url: BASE_URL + '/app/post/ajax-load-explore.php',
                    cache: false,
                    data: { 
                        page: v_page 
                    },
                    success: function (result) {
                        $element3.append(result);
                    },
                    error: function () {
                        alert("error when load post");
                    }
                })
                .always(function () {
                    $loadding.addClass("hidden");
                    is_busy = false;
                });
            return false;
        }
    });
});