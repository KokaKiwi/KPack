<?php
KPack::register_module("kp_url", "URL Rewriting for KPack", "1.0");
KPack::register_class("kp_url", "KP_URL");
KPack::register_hook("kp_url", "on_process", "kp_url.KP_URL.process");

class KP_URL extends Module
{

    function __construct ()
    {
        $this->rules = array();
        $this->uri = "";
    }

    function process ($options)
    {
        global $modules, $classes, $hooks, $uri_test;
        
        $request_uri = $options['request'];
        if (preg_match("#^(.*)\?#", $request_uri, $matches)) {
            $request_uri = $matches[1];
        }
        if ($request_uri != "/") {
            $uri_dirs = explode("/", $request_uri);
            $uri = array();
            foreach ($uri_dirs as $dir) {
                if (! preg_match("#\/" . $dir . "#", $request_uri)) {
                    $uri[] = $dir;
                }
            }
            $uri = implode("/", $uri_dirs);
            $uri = substr($uri, 1);
        }
        else {
            $uri = "";
        }
        
        if (isset($_GET['debug'])) {
            print_r($this->rules);
            print_r($uri);
            die();
        }
        
        $this->uri = $uri;
        
        foreach ($this->rules as $rule) {
            $test = array();
            
            if (preg_match("#^" . $rule['pattern'] . "$#", $uri, $matches)) {
                $test = array("function" => $rule['function'], 
                        "params" => $matches);
            }
            
            if (! empty($test)) {
                $uri_test = $test;
                
                $func = $rule['function'];
                
                if (preg_match(
                        "#^([a-zA-Z0-9_]+)\.([a-zA-Z0-9_]+)\.([a-zA-Z0-9_]+)$#", 
                        $func, $matches)) {
                    $mod_id = $matches[1];
                    $class_name = $matches[2];
                    $func_name = $matches[3];
                    
                    return $classes[$mod_id . "." . $class_name]->$func_name();
                }
                else 
                    if (preg_match("#^([a-zA-Z0-9_]+)\/([a-zA-Z0-9_]+)$#", 
                            $func, $matches)) {
                        $class_name = $matches[1];
                        $func_name = $matches[2];
                        
                        $class = new $class_name();
                        $class->$func_name();
                    }
                    else {
                        return $func();
                    }
            }
        }
    }

    function add_rule ($regex, $func)
    {
        $this->rules[] = array('pattern' => $regex, 'function' => $func);
    }
}
?>
