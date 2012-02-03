<?php
require KP_CORE_PATH . '/kpack/kpack.php';
require KP_CORE_PATH . '/kpack/module.php';

$modules = array();
$hooks = array();
$classes = array();

$uri_test = array();

$mods_dir = scandir(KP_MODS_PATH);

foreach ($mods_dir as $mod) {
    if ($mod != '.' && $mod != '..') {
        if (file_exists(KP_MODS_PATH . '/' . $mod . '/module.php')) {
            include KP_MODS_PATH . '/' . $mod . '/module.php';
        }
    }
}

/*
 * print_r($modules); print_r($classes); print_r($hooks);
 */

KPack::run_hook("post_mods_load");
?>
