<?php
//// thoigian forum ////
function thoigian($from, $to = '') {
    if (empty($to))
    $to = time();
    $diff = (int) abs($to - $from);
    if ($diff <= 60) {
    $since = sprintf('Just a moment');
    } elseif ($diff <= 3600) {
    $mins = round($diff / 60);
    if ($mins <= 1) {
    $mins = 1;
    }
    $since = sprintf('%s minute ago', $mins);
    } else if (($diff <= 86400) && ($diff > 3600)) {
    $hours = round($diff / 3600);
    if ($hours <= 1) {
    $hours = 1;
    }
    $since = sprintf('%s hour ago', $hours);
    } elseif (($diff >= 86400) && ($diff < 604800)){
    $days = round($diff / 86400);
    if ($days <= 1) {
    $days = 1;
    }
    $since = sprintf('%s day ago', $days);
    }
    elseif (($diff >= 604800) && ($diff < 2592000)) {
    $tuans = round($diff / 604800);
    if ($tuans <= 1) {
    $tuans = 1;
    }
    $since = sprintf('%s week ago', $tuans);
    }
    elseif (($diff >= 2592000) && ($diff < 31092000)) {
    $tuanss = round($diff / 2592000);
    if ($tuanss <= 1) {
    $tuanss = 1;
    }
    $since = sprintf('%s month ago', $tuanss);
    }
    elseif (($diff >= 31092000) && ($diff < 31092000000000)) {
    $tuansss = round($diff / 31092000);
    if ($tuansss <= 1) {
    $tuansss = 1;
    }
    $since = sprintf('%s year ago', $tuansss);
    }
    return $since;
}
?>