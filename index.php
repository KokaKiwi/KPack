<?php
    require dirname(__FILE__) . '/config.php';
    
    KPack::process(array('request' => $_SERVER['REQUEST_URI']));
?>