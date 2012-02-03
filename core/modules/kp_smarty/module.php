<?php
require dirname(__FILE__) . "/smarty-3.0.6/Smarty.class.php";

KPack::register_module("kp_smarty", "Smarty Template Engine for KPack", "3.0.6");
KPack::register_class("kp_smarty", "KP_Smarty");

class KP_Smarty extends Module
{

    function __construct ()
    {
        $this->smarty = new Smarty();
        $this->smarty->template_dir = dirname(__FILE__) . "/templates/";
        $this->smarty->compile_dir = dirname(__FILE__) . "/templates_c/";
        $this->smarty->allow_php_tag = true;
        $this->smarty->registerPlugin("function", "url", "kp_smarty_url");
    }
}

function kp_smarty_url ($params, $smarty)
{
    $url = "http://" . $_SERVER['HTTP_HOST'];
    if (empty($params["u"])) {
        return $url;
    }
    else {
        return $url . "/" . $params['u'];
    }
}
?>
