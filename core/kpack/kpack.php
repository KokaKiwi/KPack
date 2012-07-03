<?php

class KPack
{

    /**
     * Main function.
     * Do page processing.
     */
    static function process ($options = array())
    {
        global $modules, $hooks, $classes;
        KPack::run_hook("pre_process", $options);
        KPack::run_hook("on_process", $options);
        KPack::run_hook("post_process", $options);
    }

    static function register_module ($mod_id, $mod_name, $mod_version, 
            $mod_desc = "", $mod_author = "")
    {
        global $modules, $hooks, $classes;
        $modules[$mod_id] = array('name' => $mod_name, 
                'version' => $mod_version, 'description' => $mod_desc, 
                'author' => $mod_author);
    }

    static function get_module ($mod_id)
    {
        global $modules, $hooks, $classes;
        KPack::verif_loaded($mod_id);
        return $modules[$mod_id];
    }

    static function register_class ($mod_id, $class_name)
    {
        global $modules, $hooks, $classes;
        KPack::verif_loaded($mod_id);
        $classes[$mod_id . "." . $class_name] = new $class_name();
        $classes[$mod_id . "." . $class_name]->mod_id = $mod_id;
        $classes[$mod_id . "." . $class_name]->mod_name = $modules[$mod_id]['name'];
        $classes[$mod_id . "." . $class_name]->mod_version = $modules[$mod_id]['version'];
        $classes[$mod_id . "." . $class_name]->mod_desc = $modules[$mod_id]['description'];
        $classes[$mod_id . "." . $class_name]->mod_author = $modules[$mod_id]['author'];
    }

    static function get_class ($mod_id, $class_name)
    {
        global $modules, $hooks, $classes;
        return $classes[$mod_id . "." . $class_name];
    }

    static function register_hook ($mod_id, $hook_name, $hook_function)
    {
        global $modules, $hooks, $classes;
        KPack::verif_loaded($mod_id);
        if (isset($hooks[$hook_name]))
            $hooks[$hook_name] = array();
        $hooks[$hook_name][] = $hook_function;
    }

    static function run_hook ($hook_name, $options = array())
    {
        global $modules, $hooks, $classes;
        if (isset($hooks[$hook_name])) {
            foreach ($hooks[$hook_name] as $hook) {
                if (preg_match(
                        "#^([a-zA-Z0-9_]+)\.([a-zA-Z0-9_]+)\.([a-zA-Z0-9_]+)$#", 
                        $hook, $matches)) {
                    $mod_id = $matches[1];
                    $class_name = $matches[2];
                    $func_name = $matches[3];
                    
                    return $classes[$mod_id . "." . $class_name]->$func_name($options);
                }
                else {
                    return $hook($options);
                }
            }
        }
    }

    static function verif_loaded ($mod_id)
    {
        global $modules, $hooks, $classes;
        if (! isset($modules[$mod_id]))
            die("Le module " . $mod_id . " n'est pas charg&eacute;");
    }

    static function get_uri_result ()
    {
        global $uri_test;
        return $uri_test;
    }
}
?>
