<?php

class KPack2
{

    /**
     * Add a page.
     * @param string $pattern Pattern of URL
     * @param string $func Function to call.
     */
    function add_page ($pattern, $func)
    {
        KPack::get_class("kp_url", "KP_URL")->add_rule($pattern, $func);
    }

    static function set_config ($name, $val)
    {
        global $kp2_config;
        $kp2_config[$name] = $val;
    }

    function set_var ($name, $val)
    {
        global $tpl_vars;
        $tpl_vars[$name] = $val;
    }
}
?>
