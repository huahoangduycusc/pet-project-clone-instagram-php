<?php
define('IN_SITE', true);
$rootpath = '';
require_once('libs/core.php');
if (!$user_id) {
    redirect($homeurl . "/signin.php");
}
require_once('libs/header.php');
$s = isset($_GET['s']) ? htmlspecialchars($_GET['s']) : '';
?>
<div class="body-content">
    <section class="any-follow">
        <h4>Search <?php echo $s;?> </h4>
        <div class="any-follow-list">
            <?php
            $objAccount = new Account();
            $listSugges = $objAccount->searching($s);
            foreach ($listSugges as $sg) {
                $textFollow = $objAccount->isFollowed($sg['account_id']) ? 'Unfollow' : 'Follow';
            ?>
                <div class="any-item">
                    <div class="any-item-avatar">
                        <a href=""><img src="<?php echo $homeurl . $sg['avatar']; ?>" alt=""></a>
                    </div>
                    <div class="any-item-profile">
                        <div class="any-profile-user">
                            <a href="<?php echo $homeurl; ?>/app/profile?id=<?php echo $sg['account_id']; ?>">
                                <?php echo $sg['username']; ?>
                            </a>
                        </div>
                        <div class="any-profile-name"><?php echo $sg['fullname']; ?></div>
                        <div class="any-profile-sg">Suggestion for you</div>
                    </div>
                    <div class="any-item-btn">
                        <button class="btn-follow-sm follow-request" data-u="<?php echo $sg['account_id']; ?>"><?php echo $textFollow;?></button>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
</div>
<?php
require_once('libs/footer.php');
?>
<script src="./js/post.js"></script>