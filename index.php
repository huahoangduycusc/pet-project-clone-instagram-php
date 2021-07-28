<?php
define('IN_SITE', true);
$rootpath = '';
require_once('libs/core.php');
if (!$user_id) {
    redirect($homeurl . "/signin.php");
}
require_once('libs/header.php');
?>
<div class="body-content">
    <div class="box-welcome">
        <div class="welcome-left">
            <div class="box-view">
                <?php
                $objPost = new Post();
                $listPost = $objPost->getAllPostofAccountFollowed();
                foreach ($listPost as $post) {
                    $isLiked = $objPost->isLiked($post['post_id']);
                    $isSaved = $objPost->isSaved($post['post_id']);
                ?>
                    <article class="post-index">
                        <div class="post-index-author">
                            <div class="post-index-avatar">
                                <a href="<?php echo Account::Url($post['account_id']); ?>"><img src="<?php echo $homeurl . $post['avatar']; ?>" alt=""></a>
                            </div>
                            <div class="post-index-name">
                                <span><a href="<?php echo Account::Url($post['account_id']); ?>"><?php echo $post['username']; ?></a></span>
                            </div>
                        </div>
                        <div class="post-btn-index">
                            <button class="post-index-button" data-id="<?php echo $post['post_id']; ?>" data-u="<?php echo $post['account_id']; ?>">
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
                                    <span class="post-text-author"><a href="<?php echo Account::Url($post['account_id']); ?>"><?php echo $post['username']; ?></a></span>
                                    <span class="post-text-content"><?php echo html_entity_decode($post['post_msg']); ?></span>
                                </div>
                                <?php
                                $limit = 2;
                                $listCmt = $objPost->getComments($post['post_id']);
                                foreach ($listCmt as $cmt) {
                                ?>
                                    <div class="post-index-text">
                                        <span class="post-text-author"><a href="<?php echo Account::Url($cmt['account_id']); ?>"><?php echo $cmt['username']; ?></a></span>
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
                ?>
            </div>
            <div id="loading" class="center hidden">
                <img src="<?php echo $homeurl; ?>/public/images/loading.gif" width="70" alt="">
            </div>
        </div>
        <div class="welcome-right">
            <div class="box-right-self">
                <div class="box-right-avatar">
                    <a href="<?php echo $homeurl; ?>/app/profile"><img src="<?php echo $homeurl . $datauser['avatar']; ?>" style="width:56px;height:56px;" alt=""></a>
                </div>
                <div class="box-right-user">
                    <div class="user-bold"><a href="<?php echo $homeurl; ?>/app/profile"><?php echo $datauser['username']; ?></a></div>
                    <div class="user-fullname"><a href="<?php echo $homeurl; ?>/app/profile"><?php echo $datauser['fullname']; ?></a></div>
                </div>
                <div class="box-right-out">
                    <a href="<?php echo $homeurl; ?>/signout.php">Log out</a>
                </div>
            </div>
            <!-- end div -->
            <div class="box-right-suggest">
                <div class="suggest-text">
                    <div>Suggestions For You</div>
                    <a href="" class="suggest-see">See all</a>
                </div>
                <div class="suggest-list">
                    <div class="suggest-list-user">
                        <?php
                        $objAccount = new Account();
                        $getListSugges = $objAccount->getSuggestion();
                        foreach ($getListSugges as $sg) {
                        ?>
                            <div class="suggest-user">
                                <div class="suggest-user-avatar">
                                    <a href="<?php echo $homeurl;?>/app/profile/index.php?id=<?php echo $sg['account_id'];?>">
                                        <img src="<?php echo $homeurl;?>/<?php echo $sg['avatar'];?>" style="width:32px;height:32px;" alt="">
                                    </a>
                                </div>
                                <div class="suggest-user-name">
                                    <div class="suggest-u"><a href=""><?php echo $sg['username'];?></a></div>
                                    <div class="suggest-f">Suggested for you</div>
                                </div>
                                <div class="suggest-user-follow">
                                    <a href="">Follow</a>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="function-fixed">
    <div class="function-container">
        <div class="function-content">
            <button class="function-btn function-red" onclick="reportPost();">Report</button>
            <button class="follow-option function-btn function-red">...</button>
            <button class="function-btn" onclick="gotoPost();">Go to post</button>
            <button class="modal-option function-btn">Share to ...</button>
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
        $('.post-index-img').slick({
            dots: true,
            infinite: false,
            speed: 300,
        });
    });
</script>
<?php
require_once('libs/footer.php');
?>
<script src="./js/post.js"></script>