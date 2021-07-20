<?php
define('IN_SITE', true);
$rootpath = '../../';
require_once($rootpath . 'libs/core.php');
if (!$user_id) {
    redirect($homeurl);
}
if (!$id) {
    $id = $user_id;
}
$obj = new Account();
$account = $obj->getRow($id);
if (!$account) {
    redirect($homeurl);
}
$textFollow = $obj->isFollowed($id) ? 'Unfollow' : 'Follow';
require_once($rootpath . 'libs/header.php');
?>
<div class="body-content">
    <section class="user-info">
        <div class="user-avatar">
            <div class="avatar-profile">
                <img src="<?php echo $homeurl . "/" . $account['avatar']; ?>" alt="">
            </div>
        </div>
        <div class="user-introduce">
            <div class="user-name">
                <h2 class="user-name-title"><?php echo $account['username']; ?></h2>
                <span><img src="<?php echo $homeurl; ?>/images/verify.png" alt=""></span>
                <div class="user-follow">
                    <?php
                    if ($user_id != $id) {
                        echo '<a href="" data-u="'.$id.'" class="follow-request btn-follow">'.$textFollow.'</a>';
                    } else {
                        echo '<a href="" class="btn-setting">Setting profile <i class="fas fa-cog"></i></a>';
                    }
                    ?>

                </div>
            </div>
            <ul class="user-more">
                <li class="more-item">
                    <span class="bold"><?php echo $account['post']; ?></span> posts
                </li>
                <li class="more-item">
                    <a href="#followers" class="<?php echo ($obj->countFollower($id) > 0 ? 'aj-followers' :'');?>"><span class="bold" id="flers"><?php echo $obj->countFollower($id); ?></span> followers</a>
                </li>
                <li class="more-item <?php echo ($obj->countFollowing($id) > 0 ? 'aj-following' : '' );?>">
                    <span class="bold"><?php echo $obj->countFollowing($id); ?></span> following
                </li>
            </ul>
            <div class="user-about">
                <h2 class="user-about-title"><?php echo $account['fullname']; ?></h2>
                <span><?php echo $account['introduce']; ?></span>
                <a href="" class="user-author"><?php echo $account['bio']; ?></a>
            </div>
        </div>
    </section>
    <section class="user-posts">
        <?php
        if ($user_id == $id) {
        ?>
        <div class="line"></div>
            <div class="user-own">
                <div class="user-own-icon">
                    <i class="fas fa-camera"></i>
                    <h1>Add a new post </h1>
                    <p>Share memories with your friends.</p>
                    <a href="newpost.php" class="btn-follow">Add new post</a>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="profile-tab flex">
            <a href="" class="tab-content tab-visited"><i class="fas fa-border-all"></i><span>POSTS</span></a>
            <?php
            if($user_id == $id){
                echo'<a href="saved.php" class="tab-content"><i class="far fa-bookmark"></i><span>Saved</span></a>';
            }
            ?>
        </div>
        <div class="user-posts-list" id="your-account-post">
            <?php
            $objPost = new Post();
            $myPost = $objPost->getPostOfAccount($id,0);
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
            if(count($myPost) == 0){
                echo'<div class="empty center">This account has no post created</div>';
            }
            ?>
        </div>
        <div id="loading" class="center hidden">
            <img src="<?php echo $homeurl;?>/public/images/loading.gif" width="70" alt="">
        </div>
    </section>
</div>
<?php
require_once($rootpath . 'libs/footer.php');
?>