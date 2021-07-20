<?php
define('IN_SITE', true);
$rootpath = '../../';
require_once($rootpath . "libs/core.php");
if (!$user_id || !$id) {
    redirect($homeurl);
}
$objPost = new Post();
$post = $objPost->viewInfo($id);
if (!$post) {
    redirect($homeurl);
}
$isLiked = $objPost->isLiked($post['post_id']); // check if user is like this post ?
$isSaved = $objPost->isSaved($post['post_id']); // check if saved this post before ?
$countCmt = db_count($T_POST_CMT, 'cmt_id', array('post_id' => $id));
$account = new Account();
$textFollow = $account->isFollowed($post['account_id']) ? 'Unfollow' : 'Follow';
require_once($rootpath . "libs/header.php");
?>
<div class="body-content">
    <div class="view-post">
        <article class="article">
            <div class="carousel-container">
                <div class="carousel-slide">
                    <?php
                    $images = $objPost->getImages($post['post_id']);
                    foreach ($images as $image) {
                    ?>
                        <div><img src="<?php echo $homeurl . "/" . $image['image_path']; ?>"></div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="article-content">
                <div class="article-author">
                    <div class="article-avatar">
                        <a href="<?php echo Account::Url($post['account_id']); ?>"><img src="<?php echo $homeurl . $post['avatar']; ?>" alt=""></a>
                    </div>
                    <div class="article-author-name">
                        <a href="<?php echo Account::Url($post['account_id']); ?>"><?php echo $post['username']; ?></a>
                        <span><img src="<?php echo $homeurl; ?>/images/verify.png" title="Verified"></span>
                        <?php
                        if ($user_id != $post['account_id']) {
                        ?>
                            <div class="follow">
                                <span class="RPhNB">•</span>
                                <a href="#follow" class="follow-request" data-u="<?php echo $post['account_id']; ?>"><?php echo $textFollow; ?></a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="article-action">
                        <button class="article-action-btn" data-id="<?php echo $post['post_id']; ?>" data-u="<?php echo $post['account_id']; ?>">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                </div>
                <div class="line"></div>
                <div class="article-talk">
                    <div class="article-talk-item">
                        <div class="talk-avatar">
                            <a href="<?php echo Account::Url($post['account_id']); ?>"><img src="<?php echo $homeurl . $post['avatar']; ?>" alt=""></a>
                        </div>
                        <div class="talk-content">
                            <h3><a href="<?php echo Account::Url($post['account_id']); ?>"><?php echo $post['username']; ?></a></h3>
                            <span><img src="<?php echo $homeurl; ?>/images/verify.png" title="Verified"></span>
                            <span id="msgView"><?php echo html_entity_decode($post['post_msg']); ?></span>
                            <div class="talk-times">
                                <time class="times"><?php echo thoigian($post['post_date']); ?></time>
                            </div>
                        </div>
                    </div>
                    <div id="container-cmt" class="result">
                        <?php
                        $comments = $objPost->getComments($post['post_id']);
                        foreach ($comments as $cmt) {
                        ?>
                            <div class="article-talk-item">
                                <div class="talk-avatar">
                                    <a href="<?php echo Account::Url($cmt['account_id']); ?>"><img src="<?php echo $homeurl . $cmt['avatar']; ?>" alt=""></a>
                                </div>
                                <div class="talk-content">
                                    <h3><a href="<?php echo Account::Url($cmt['account_id']); ?>"><?php echo $cmt['username']; ?></a></h3>
                                    <span><?php echo html_entity_decode($cmt['cmt_msg']); ?></span>
                                    <div class="talk-times">
                                        <time class="times"><?php echo thoigian($cmt['cmt_date']); ?></time>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="loading center" style="display:none"><img src="<?php echo $homeurl; ?>/theme/ajax-loader.gif" width="20"></div>
                    <?php
                    if ($countCmt > $limit) {
                    ?>
                        <div class="center" style="color:#888;">
                            <span style="cursor:pointer;font-size:19px;" data-load="<?php echo $post['post_id']; ?>" class="load-more"><i class="fas fa-plus-circle"></i></span>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <section class="article-action">
                    <span class="likeButton" data-like="<?php echo $post['post_id']; ?>" style="font-size: 24px;">
                        <i class="<?php echo ($isLiked ? 'fas fa-heart red' : 'far fa-heart'); ?>"></i>
                    </span>
                    <span>
                        <label for="msgChat"><i class="far fa-comment"></i></label>
                    </span>
                    <div class="float-right post-count-img" data-saved="<?php echo $post['post_id']; ?>">
                        <i class="<?php echo ($isSaved ? 'fas fa-bookmark' : 'far fa-bookmark'); ?>"></i>
                    </div>
                </section>
                <section class="article-info">
                    <span id="numLike<?php echo $post['post_id']; ?>"><?php echo $objPost->countLikes($post['post_id']); ?></span> likes
                    <div class="article-times"><?php echo date("F d, Y", $post['post_date']); ?></div>
                </section>
                <section class="article-comment">
                    <form method="post" id="submitChat" data-emojiarea data-type="unicode" data-global-picker="false">
                        <button type="button" class="btn-smiley flex emoji-button" style="font-size: 20px;color:#333;margin-right:15px;"><i class="far fa-smile"></i></button>
                        <?php
                        CSRF::create_token();
                        ?>
                        <textarea name="msgChat" id="msgChat" class="article-input" data-post="<?php echo $post['post_id']; ?>" placeholder="Add comment ..." required></textarea>
                        <button type="submit" class="btn-cmt-view">Post</button>
                    </form>
                </section>
            </div>
        </article>
        <div class="line" style="margin-top: 40px;"></div>
        <div class="more-post-author">
            <div class="author-post-title">
                <span>More posts from </span> <a href="<?php echo Account::Url($post['account_id']); ?>"><?php echo $post['username']; ?></a>
            </div>
            <div class="author-post-content user-posts">
                <div class="user-posts-list">
                    <?php
                    $latest = $objPost->latestPost($id, $post['account_id']);
                    foreach ($latest as $itemPost) {
                        $cmt = db_count($T_POST_CMT, 'cmt_id', array('post_id' => $itemPost['post_id']));
                        $like = db_count($T_POST_LIKE, 'like_id', array('post_id' => $itemPost['post_id']));
                    ?>
                        <article class="article-post">
                            <a href="<?php echo Post::Url($itemPost['post_id']); ?>" class="post-a">
                                <img src="<?php echo $homeurl . "/" . $itemPost['image_path']; ?>" class="post-thumb">
                                <i class="fas fa-clone"></i>
                                <div class="article-more">
                                    <span><i class="fas fa-heart"></i> <?php echo $like; ?></span>
                                    <span><i class="fas fa-comment"></i> <?php echo $cmt; ?></span>
                                </div>
                            </a>
                        </article>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="post" id="post" value="<?php echo $post['post_id']; ?>">
<div class="function-fixed">
    <div class="function-container">
        <div class="function-content">
            <button class="function-btn function-red" onclick="reportPost();">Report</button>
            <?php
            if ($user_id != $post['account_id']) {
                echo '<button class="follow-option function-btn function-red" data-u="' . $post['account_id'] . '">...</button>';
            } else {
                echo '<button class="edit-option function-btn function-red">Edit this post</button>';
                echo '<button class="del-option function-btn function-red">Delete this post</button>';
            }
            ?>
            <button class="modal-option function-btn">Share to...</button>
            <button class="copy-option function-btn">Copy link</button>
            <button class="function-btn btn-huy">Cancel</button>
        </div>
    </div>
</div>
<div class="pop-up">
    <span>Link copied to clipboard.</span>
</div>
<script>
    $(document).ready(function() {
        $('.carousel-slide').slick({
            dots: true,
            infinite: false,
            speed: 300,
        });
    });
</script>
<script src="<?php echo $homeurl; ?>/js/post.js"></script>
<?php
require_once($rootpath . "libs/footer.php");
?>