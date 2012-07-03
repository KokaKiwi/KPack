<?php
require dirname(__FILE__) . "/kpack.php";
require dirname(__FILE__) . "/controller.php";
require dirname(__FILE__) . "/loader.php";

define("KP_APPS_PATH", KP_ROOT_PATH . "/apps/1.0");

KPack::register_module("kp_mvc", "Model View Controller System for KPack", 
        "4.0");
KPack::register_class("kp_mvc", "KP_MVC");
KPack::register_hook("kp_mvc", "pre_process", "kp_mvc.KP_MVC.pre_process");
KPack::register_hook("kp_mvc", "post_process", "kp_mvc.KP_MVC.post_process");

$kp2_config = array();
$tpl_vars = array();

class KP_MVC extends Module
{

    function __construct ()
    {
        $this->config = array();
        $this->tpl_vars = array();
    }

    function pre_process ()
    {
        $this->include_dir(KP_APPS_PATH . "/config");
        $this->include_dir(KP_APPS_PATH . "/controllers");
        Kpack::get_class("kp_smarty", "KP_Smarty")->smarty->template_dir = KP_APPS_PATH .
                 "/views";
            }

            function post_process ()
            {
                $request = KPack::get_class("kp_url", "KP_URL")->uri;
                if (file_exists(KP_APPS_PATH . '/public/' . $request) &&
                         $request != '') {
                            $exts = explode(".", $request);
                            $ext = array_pop($exts);
                            switch ($ext) {
                                case "css":
                                    Header("Content-type: text/css");
                                    
                                    $smarty = KPack::get_class("kp_smarty", 
                                            "KP_Smarty");
                                    $smarty->smarty->left_delimiter = '{{';
                                    $smarty->smarty->right_delimiter = '}}';
                                    echo $smarty->smarty->fetch(
                                            KP_APPS_PATH . '/public/' . $request);
                                    $smarty->smarty->left_delimiter = '{';
                                    $smarty->smarty->right_delimiter = '}';
                                    break;
                                
                                case "js":
                                    Header("Content-type: text/javascript");
                                    $file = file_get_contents(
                                            KP_APPS_PATH . '/public/' . $request);
                                    echo $file;
                                    break;
                                    
                                case "png": case "jpg":
                                    Header("Content-type: image/" . $ext);
                                    $file = file_get_contents(
                                            KP_APPS_PATH . '/public/' . $request);
                                    echo $file;
                                    break;
                                
                                default:
                                    $file = file_get_contents(
                                            KP_APPS_PATH . '/public/' . $request);
                                    echo $file;
                            }
                        }
                    }

                    function include_dir ($dir)
                    {
                        $scan = scandir($dir);
                        foreach ($scan as $inc) {
                            if ($inc != '.' && $inc != '..') {
                                if (is_dir($dir . '/' . $inc)) {
                                    $this->include_dir($dir . '/' . $inc);
                                }
                                else {
                                    include $dir . '/' . $inc;
                                }
                            }
                        }
                    }
                }
                ?>
