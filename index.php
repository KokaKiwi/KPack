<?php
    require dirname(__FILE__) . '/config.php';
    
    $options = array(
            'request' => $_SERVER['REQUEST_URI'],
            'app_path' => KP_CORE_PATH . '/apps/1.0'
    );
    
    KPack::process($options);
?>