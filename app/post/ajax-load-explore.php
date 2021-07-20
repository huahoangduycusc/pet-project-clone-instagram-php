<?php
sleep(1);
define('IN_SITE', true);
// Thiết lập kết quả trả về là html và charset là utf8 để khỏi lỗi font
header('Content-Type: text/html; charset=utf-8');
$rootpath = "../../";
require_once($rootpath . "libs/core.php");
$result = array();
$skip = input_get('page');
$skip = abs(intval($skip));
$start = ($skip * $limit) - $limit;
if ($skip) {
    $objPost = new Post();
    $list = $objPost->explore();
}
$html = "";
?>
<?php
foreach ($list as $post) {
    $cmt = db_count($T_POST_CMT, 'cmt_id', array('post_id' => $post['post_id']));
    $like = db_count($T_POST_LIKE, 'like_id', array('post_id' => $post['post_id']));
    $html .= ' <article class="article-post">
    <a href="' . Post::Url($post['post_id']) . '" class="post-a">
        <img src="' . $homeurl . "/" . $post['image_path'] . '" class="post-thumb">
        <i class="fas fa-clone"></i>
        <div class="article-more">
            <span><i class="fas fa-heart"></i> ' . $like . '</span>
            <span><i class="fas fa-comment"></i> ' . $cmt . '</span>
        </div>
    </a>
</article>';
}
if (count($list) < $limit) {
    $html .= '<script language="javascript">stopped = true; </script>';
}
echo $html;
?>