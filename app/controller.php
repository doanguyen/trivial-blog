<?php

//! Base controller
class Controller {

	protected
		$db;

	//! HTTP route pre-processor
	function beforeroute($f3) {
		#$db=$this->db;
		// Prepare user menu
		#$f3->set('menu',
			#$db->exec('SELECT slug,title FROM pages ORDER BY position;'));
	}

	//! HTTP route post-processor
	function afterroute() {
		// Render HTML layout
		echo Template::instance()->render('layout.htm');
	}

	//! Instantiate class
	function __construct() {
		$f3=Base::instance();
		// Connect to the database
		$db=new DB\SQL($f3->get('db'));
		// Use database-managed sessions
		new DB\SQL\Session($db);
		// Save frequently used variables
		$this->db=$db;
	}

}
