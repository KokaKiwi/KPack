<?php

/**
 * Smarty plugin to execute PHP code
 * 
 * @package Smarty
 * @subpackage PluginsBlock
 * @author Uwe Tews 
 */

/**
 * Smarty {php}{/php} block plugin
 *
 * @param $content string
 *            contents of the block
 * @param $template object
 *            template object
 * @param $ boolean
 *            &$repeat repeat flag
 * @return string content re-formatted
 */
function smarty_block_php ($params, $content, $template, &$repeat)
{
    if (! $template->allow_php_tag) {
        throw new SmartyException(
                "{php} is deprecated, set allow_php_tag = true to enable");
    }
    eval($content);
    return '';
}

?>