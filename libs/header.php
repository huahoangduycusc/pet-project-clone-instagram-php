<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title;?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php echo $homeurl; ?>/theme/style.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $homeurl; ?>/theme/slick.css">
    <link rel="stylesheet" href="<?php echo $homeurl; ?>/theme/slick-theme.css">
    <link rel="stylesheet" href="<?php echo $homeurl; ?>/theme/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="<?php echo $homeurl; ?>/theme/assets/js/jquery.emojiarea.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo $homeurl; ?>/js/slick.min.js"></script>
    <script src="<?php echo homeurl(); ?>/js/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="<?php echo homeurl(); ?>/js/sweetalert2.min.css" />
    <script src="<?php echo $homeurl; ?>/js/moment.min.js"></script>
</head>

<body>
    <div class="spiner">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <header>
        <nav class="nav">
            <div class="nav-container">
                <div class="nav-logo">
                    <a href="<?php echo $homeurl; ?>"><img src="<?php echo $homeurl; ?>/images/logo.png" alt=""></a>
                </div>
                <div class="nav-search">
                    <form class="nav-search-form">
                        <div class="search-nav-content">
                            <input type="text" name="s" placeholder="Search">
                            <button type="submit" class="nav-search-btn"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="nav-user">
                    <div class="nav-user-container">
                        <div class="nav-user-item"><a href="<?php echo $homeurl;?>"><i class="fas fa-home"></i></a></div>
                        <div class="nav-user-item"><a href="<?php echo $homeurl;?>/app/explore"><i class="fab fa-cloudscale"></i></a></div>
                        <div class="nav-user-item"><a href="<?php echo $homeurl;?>/app/profile/saved.php"><i class="fas fa-heart"></i></a></div>
                        <div class="nav-user-item function">
                            <a href="" class="nav-user-item"><i class="fas fa-user dropdown-toggle"></i></a>
                            <div class="guess">
                                <div class="guess-container">
                                    <a href="<?php echo $homeurl; ?>/app/profile" class="guess-item"><i class="fas fa-user"></i><span>Profile</span></a>
                                    <a href="" class="guess-item"><i class="fas fa-cog"></i><span>Settings</span></a>
                                    <a href="<?php echo $homeurl;?>/app/profile/saved.php" class="guess-item"><i class="far fa-bookmark"></i><span>Saved</span></a>
                                    <div class="phancach"></div>
                                    <a href="<?php echo $homeurl; ?>/signout.php" class="guess-item"><i class="fas fa-sign-out-alt"></i><span>Log out</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <input type="hidden" id="base_url" value="<?php echo $homeurl; ?>">
    <input type="text" class="hidden" id="url">
    <input type="hidden" value="<?php echo $id;?>" id="accountID" class="">
    <div class="modal">
        <div class="dialog">
            <div class="modal-header flex-p">
                <div class="flex woa"></div>
                <h1 class="modal-title flex">Share on</h1>
                <div class="flex modal-close woa">
                    <button>
                        <svg aria-label="Đóng" class="_8-yf5 " fill="#262626" height="24" viewBox="0 0 48 48" width="24">
                            <path clip-rule="evenodd" d="M41.1 9.1l-15 15L41 39c.6.6.6 1.5 0 2.1s-1.5.6-2.1 0L24 26.1l-14.9 15c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l14.9-15-15-15c-.6-.6-.6-1.5 0-2.1s1.5-.6 2.1 0l15 15 15-15c.6-.6 1.5-.6 2.1 0 .6.6.6 1.6 0 2.2z" fill-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- model header -->
            <div class="modal-body">
            222
            </div>
        </div>
    </div>