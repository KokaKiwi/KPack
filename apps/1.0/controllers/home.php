<?php
	KPack2::add_page("", "KP_Home/home");
	
	class KP_Home extends Controller {
		function home() {
			$this->set_config("logged", $_SESSION['logged']);
			$this->set_config("active", "home");
		
			$this->load->view("home.html");
		}
	}
?>