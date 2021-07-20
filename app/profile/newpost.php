<?php
define('IN_SITE',true);
$rootpath = '../../';
require_once($rootpath.'libs/core.php');
if(!$user_id){
    redirect($homeurl);
}
require_once($rootpath.'libs/header.php');
if(isset($_POST['newPost'])){
    $total = count($_FILES['filePhoto']['name']);
    echo $total;
    // Loop through each file
    for( $i=0 ; $i < $total ; $i++ ) {

        //Get the temp file path
        $tmpFilePath = $_FILES['filePhoto']['name'][$i];
        echo $tmpFilePath;
    
    }

}
?>
<div class="body-content">
    <section class="user-posts">
        <div class="line"></div>
        <div class="user-own">
            <div class="user-own-icon">
                <i class="fas fa-camera"></i>
                <h1>Add a new post </h1>
                <p>Share memories with your friends.</p>
            </div>
        </div>
        <div class="list-create">
            <form method="post" enctype="multipart/form-data" id="submit_post">
                <div class="box-input">
                    <p style="margin-bottom: 10px;">Message</p>
                    <textarea name="message" id="msg" rows="5" class="form-control" placeholder="Enter your message"></textarea>
                </div>
                <div class="box-input">
                    <p>Choose one or multiple images</p>
                    <div id="previewImage"></div>
                    <input type="file" id="filePhoto" name="filePhoto[]" class="file visibility-hidden" multiple>
                    <div class="drop-file-post">
                        <button type="button" class="new-post-btn" onclick="$('#filePhoto').trigger('click')">
                            <i class="far fa-images"></i>
                        </button>
                    </div>
                </div>
                <div class="box-input">
                    <button class="btn-create" type="submit" name="newPost" value="<?php echo time();?>">Create post</button>
                </div>
            </form>
        </div>
    </section>
</div>
<?php
require_once($rootpath.'libs/footer.php');
?>
<script src="app.js"></script>
<script>
 //============ Upload Preview Media
 $("#filePhoto").on('change', function(){
    $('#previewImage').html('');
    var total_file=document.getElementById("filePhoto").files.length;
    for(var i=0;i<total_file;i++)
    {
    $('#previewImage').append("<img src='"+URL.createObjectURL(event.target.files[i])+"' width='70' class='rounded'>");
    }
});
</script>