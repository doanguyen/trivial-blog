<?php

//! Front-end processor
class CMS extends Controller {

	//! display index page
	function index($f3,$args){
		$f3->set('toptitle','Index');
		$f3->set('body','index.htm');
	}

	//! display archives pages
	function archives($f3,$args) {
		$db=$this->db;
		$page=new DB\SQL\Mapper($db,'pages');
		$slug=empty($args['slug'])?'':$args['slug'];		
		$page->load(array('slug=?',$slug));
		$f3->set('toptitle','Archives');
		$f3->set('menu',
			$db->exec('SELECT * FROM pages ORDER BY updated DESC;'));
		#if ($page->dry()) {
			#$f3->error(404);
		#	$f3->set('body','error.htm'); #die;
		#}
		#else {
			$f3->set('body','archives.htm');
		#}
	}
	
	function publications($f3,$args){
		$db=$this->db;
		$f3->set('toptitle','Publications');
		$f3->set('body','publications-index.htm');
	}

	function singleblog($f3,$args) {
		$db=$this->db;
		$page=new DB\SQL\Mapper($db,'pages');
		$slug=empty($args['slug'])?'':$args['slug'];		
		$page->load(array('slug=?',$slug));
		
		$menu = $db->exec("SELECT * FROM pages WHERE slug='$slug';");
		$f3->set('toptitle',$menu[0]['title']);
		$f3->set('menu',$menu[0]);
		$f3->set('content',$menu[0]['contents']);
		if ($page->dry()) {
			#$f3->error(404);
			$f3->set('body','error.htm'); #die;
		}
		else {
			$f3->set('body','singleblog.htm');
		}
	}

	//! Display login form
	function login($f3) {
		$f3->clear('SESSION');
		if ($f3->get('eurocookie')) {
			$loc=Web\Geo::instance()->location();
			if (isset($loc['continent_code']) && $loc['continent_code']=='EU')
				$f3->set('message',
					'The administrator pages of this Web site uses cookies '.
					'for identification and security. Without these '.
					'cookies, these pages would simply be inaccessible. By '.
					'using these pages you agree to this safety measure.');
		}
		$f3->set('COOKIE.sent',TRUE);
		$f3->set('toptitle','Login');
		$f3->set('body','login.htm');
	}

	//! Custom error page
	function error($f3) {
		$log=new Log('error.log');
		#$log->write($f3->get('ERROR.text'));
		foreach ($f3->get('ERROR.trace') as $frame)
			if (isset($frame['file'])) {
				// Parse each backtrace stack frame
				$line='';
				$addr=$f3->fixslashes($frame['file']).':'.$frame['line'];
				if (isset($frame['class']))
					$line.=$frame['class'].$frame['type'];
				if (isset($frame['function'])) {
					$line.=$frame['function'];
					if (!preg_match('/{.+}/',$frame['function'])) {
						$line.='(';
						if (isset($frame['args']) && $frame['args'])
							$line.=$f3->csv($frame['args']);
						$line.=')';
					}
				}
				// Write to custom log
				$log->write($addr.' '.$line);
			}
		#$f3->set('body','error.htm');
	}


	//! Process login form
	function auth($f3) {
		if (!$f3->get('COOKIE.sent'))
			$f3->set('message','Cookies must be enabled to enter this area');
		else {
			$crypt=$f3->get('password');
			$captcha=$f3->get('SESSION.captcha');
			if ($captcha && strtoupper($f3->get('POST.captcha'))!=$captcha)
				$f3->set('message','Invalid CAPTCHA code');
			elseif ($f3->get('POST.user_id')!=$f3->get('user_id') ||
				crypt($f3->get('POST.password'),$crypt)!=$crypt)
				$f3->set('message','Invalid user ID or password');
			else {
				$f3->clear('COOKIE.sent');
				$f3->clear('SESSION.captcha');
				$f3->set('SESSION.user_id',$f3->get('POST.user_id'));
				$f3->set('SESSION.crypt',$crypt);
				$f3->set('SESSION.lastseen',time());
				$f3->reroute('/admin/pages');
			}
		}
		$this->login($f3);
	}

	//! Terminate session
	function logout($f3) {
		$f3->clear('SESSION');
		$f3->reroute('/login');
	}

}
