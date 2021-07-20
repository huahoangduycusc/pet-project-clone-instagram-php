// submit form
$("#submit_post").on('submit', function(){
    //alert("hello");
    openCloseSpiner(true);
    $.ajax({
        url: 'post-ajax.php',
        type: 'post',
        dataType: 'json',
        contentType: false,
        processData: false,
        cache: false,
        data: new FormData(this),
        success : function(data){
            console.log(data);
            openCloseSpiner(false);
            if(data.error != ""){
                Swal.fire(
                    'Error!',
                    data.error,
                    'error'
                  );
            }
            else{
                Swal.fire(
                    'Success!',
                    'Posted success',
                    'success'
                );
                $("#filePhoto").val("");
                $("#msg").val("");
                $("#previewImage").html("");
            }
        },
        error : function(){
            openCloseSpiner(false);
            alert("Error");
        }
    });
    return false;
});