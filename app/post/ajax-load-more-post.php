<?php
sleep(1);
define('IN_SITE', true);
// Thiết lập kết quả trả về là html và charset là utf8 để khỏi lỗi font
header('Content-Type: text/html; charset=utf-8');
$rootpath = "../../";
require_once($rootpath . "libs/core.php");
$result = array();
$skip = input_post('page');
$skip = abs(intval($skip));
$start = ($skip*$limit)-$limit;
if ($skip) {
    $objPost = new Post();
    $list = $objPost->getAllPostofAccountFollowed();
}
?>
<?php
foreach ($list as $post) {
    $isLiked = $objPost->isLiked($post['post_id']);
    $isSaved = $objPost->isSaved($post['post_id']);
?>
    <article class="post-index">
        <div class="post-index-author">
            <div class="post-index-avatar">
                <a href="<?php echo Account::Url($post['account_id']);?>"><img src="<?php echo $homeurl . $post['avatar']; ?>" alt=""></a>
            </div>
            <div class="post-index-name">
                <span><a href="<?php echo Account::Url($post['account_id']);?>"><?php echo $post['username']; ?></a></span>
            </div>
        </div>
        <div class="post-btn-index">
            <button class="post-index-button" data-id="<?php echo $post['post_id']; ?>" data-u="<?php echo $post['account_id'];?>">
                <i class="fas fa-ellipsis-h"></i>
            </button>
        </div>
        <div class="post-index-img">
            <?php
            $images = $objPost->getImages($post['post_id']);
            foreach ($images as $image) {
            ?>
                <div><img src="<?php echo $image['image_path']; ?>"></div>
            <?php
            }
            ?>
        </div>
        <div class="post-index-content">
            <section class="post-index-operation">
                <span class="likeButton" data-like="<?php echo $post['post_id']; ?>" style="font-size: 30px;">
                    <i class="<?php echo ($isLiked ? 'fas fa-heart red' : 'far fa-heart'); ?>"></i>
                </span>
                <span>
                    <label for="msg<?php echo $post['post_id']; ?>"><i class="far fa-comment"></i></label>
                </span>
                <div class="post-count-img" data-saved="<?php echo $post['post_id']; ?>">
                    <i class="<?php echo ($isSaved ? 'fas fa-bookmark' : 'far fa-bookmark'); ?>"></i>
                </div>
            </section>
            <section class="post-index-like">
                <span id="numLike<?php echo $post['post_id']; ?>"><?php echo $objPost->countLikes($post['post_id']); ?></span> likes
            </section>
            <section class="post-index-msg" id="chat<?php echo $post['post_id']; ?>">
                <div class="post-index-text">
                    <span class="post-text-author"><a href="<?php echo Account::Url($post['account_id']);?>"><?php echo $post['username']; ?></a></span>
                    <span class="post-text-content"><?php echo html_entity_decode($post['post_msg']); ?></span>
                </div>
                <?php
                $limit = 2;
                $listCmt = $objPost->getComments($post['post_id']);
                foreach ($listCmt as $cmt) {
                ?>
                    <div class="post-index-text">
                        <span class="post-text-author"><a href="<?php echo Account::Url($cmt['account_id']);?>"><?php echo $cmt['username']; ?></a></span>
                        <span class="post-text-content"><?php echo html_entity_decode($cmt['cmt_msg']); ?></span>
                    </div>
                <?php
                }
                ?>
            </section>
            <div class="post-index-times">
                <span><?php echo thoigian($post['post_date']); ?></span>
            </div>
            <section class="post-index-comment flex">
                <form method="post" data-emojiarea data-type="unicode" data-global-picker="true">
                    <button type="button" class="btn-smiley flex emoji-button"><i class="far fa-smile"></i></button>
                    <textarea name="msg" id="msg<?php echo $post['post_id']; ?>" class="cmt-index" placeholder="Thêm bình luận"></textarea>
                    <button type="button" class="btn-cmt" data-cmt="<?php echo $post['post_id']; ?>">Đăng</button>
                </form>
            </section>
        </div>
    </article>
<?php
}
if (count($list) < $limit){
    echo '<script language="javascript">stopped = true; </script>';
}
?>