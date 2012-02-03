<?php

/**
 * Smarty plugin
 * 
 * @package Smarty
 * @subpackage PluginsFilter
 */

/**
 * Smarty htmlspecialchars variablefilter plugin
 *
 * @param $source string
 *            input string
 * @param $ object
 *            &$smarty Smarty object
 * @return string filtered output
 */

function smarty_variablefilter_htmlspecialchars ($source, $smarty)
{
    return htmlspecialchars($source, ENT_QUOTES);
}

?>