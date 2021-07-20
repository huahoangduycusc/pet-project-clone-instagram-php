<?php
define('IN_SITE',true);
$rootpath = "../../";
require_once($rootpath."libs/core.php");
$html = "";
$html .= '<a href="https://www.facebook.com/sharer/sharer.php?u='.Post::Url($id).'" class="share-link" target="_blank">
<div class="share-option">
<div class="share-option-icon"><i class="fab fa-facebook-f"></i></div>
<div class="share-option-text">Share to facebook</div>
</div>
</a>';
$html .= '<a href="https://twitter.com/intent/tweet?text='.Post::Url($id).'" class="share-link" target="_blank">
<div class="share-option">
<div class="share-option-icon"><i class="fab fa-twitter"></i></div>
<div class="share-option-text">Share to twitter</div>
</div>
</a>';
$html .= '<a href="'.$id.'" class="share-link copy-option" target="_blank">
<div class="share-option">
<div class="share-option-icon"><i class="fas fa-link"></i></div>
<div class="share-option-text">Copy Link</div>
</div>
</a>';
$html .= '<a href="#home" class="share-link modal-close">
<div class="share-option cancel">
<div class="share-option-icon"><i></i></div>
<div class="share-option-text">Cancel</div>
</div>
</a>';
echo $html;
?>
