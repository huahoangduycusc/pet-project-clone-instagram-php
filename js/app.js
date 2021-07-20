var BASE_URL = document.querySelector("#base_url").value;
var is_busy = false;
var stopped = false;
var page = 1;
// click function dropdown
window.onclick = function (event) {
    openCloseDropdown(event);
}
var func = document.querySelector('.function');
function openCloseDropdown(event) {
    if (!event.target.matches('.dropdown-toggle')) {
        func.classList.remove('dropdown');
    }
    else {
        event.preventDefault();
        func.classList.toggle('dropdown');
    }
    if(event.target.classList.contains("modal")){
        $(".modal").removeClass("open");
        $(".modal-body").html("");
        $("html").css('overflow','');
        is_busy = false;
        stopped = false;
        page = 1;
    }
}
// function open spiner
var spiner = document.querySelector('.spiner');
function openCloseSpiner(flag) {
    if (flag == false) {
        spiner.classList.remove("active");
    }
    else {
        spiner.classList.add("active");
    }
}
// close modal
$(document).on('click','.modal-close',function(e){
    $(".modal").removeClass("open");
    $(".modal-body").html("");
    $("html").css('overflow','');
    is_busy = false;
    stopped = false;
    page = 1;
});
