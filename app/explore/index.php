<?php
define('IN_SITE', true);
$rootpath = '../../';
require_once($rootpath . "libs/core.php");
if (!$user_id) {
    redirect($homeurl);
}
require_once($rootpath . "libs/header.php");
?>
<div class="body-content">
<div style="padding-top: 5px;"></div>
    <section class="user-posts">
        <div class="user-posts-list" id="load-explore">
            <?php
            $objPost = new Post();
            $myPost = $objPost->explore();
            foreach ($myPost as $post) {
                $cmt = db_count($T_POST_CMT, 'cmt_id', array('post_id' => $post['post_id']));
                $like = db_count($T_POST_LIKE, 'like_id', array('post_id' => $post['post_id']));
            ?>
                <article class="article-post">
                    <a href="<?php echo Post::Url($post['post_id']); ?>" class="post-a">
                        <img src="<?php echo $homeurl . "/" . $post['image_path']; ?>" class="post-thumb">
                        <i class="fas fa-clone"></i>
                        <div class="article-more">
                            <span><i class="fas fa-heart"></i> <?php echo $like; ?></span>
                            <span><i class="fas fa-comment"></i> <?php echo $cmt; ?></span>
                        </div>
                    </a>
                </article>
            <?php
            }
            if (count($myPost) == 0) {
                echo '<div class="empty center">There is not any post created</div>';
            }
            ?>
        </div>
        <div id="loading" class="center hidden">
            <img src="<?php echo $homeurl; ?>/public/images/loading.gif" width="70" alt="">
        </div>
    </section>
</div>
<?php
require_once($rootpath . "libs/footer.php");
?>