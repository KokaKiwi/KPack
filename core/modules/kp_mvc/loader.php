<?php
	class KP_Loader extends Kpack2 {
		function view($file, $headers = true) {
			global $kp2_config, $tpl_vars;
			KPack::get_class("kp_smarty", "KP_Smarty")->smarty->assign($kp2_config);
			KPack::get_class("kp_smarty", "KP_Smarty")->smarty->assign('tpl', $tpl_vars);
		
			if($headers) KPack::get_class("kp_smarty", "KP_Smarty")->smarty->display("header.html");
			KPack::get_class("kp_smarty", "KP_Smarty")->smarty->display($file);
			if($headers) KPack::get_class("kp_smarty", "KP_Smarty")->smarty->display("footer.html");
		}
	}
?>
