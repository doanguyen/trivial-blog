<?php

//! Admin back-end processor
class Admin extends Controller {

	//! HTTP route pre-processor
	function beforeroute($f3) {
		if ($f3->get('SESSION.user_id')!=$f3->get('user_id') ||
			$f3->get('SESSION.crypt')!=$f3->get('password'))
			// Invalid session
			$f3->reroute('/login');
		if ($f3->get('SESSION.lastseen')+$f3->get('expiry')*3600<time())
			// Session has expired
			$f3->reroute('/logout');
		// Update session data
		$f3->set('SESSION.lastseen',time());
		// Prepare admin menu
	}

	//! List content pages
	function pages($f3,$args) {
		$db=$this->db;
		// Retrieve list
		$f3->set('pages',
			$db->exec(
				'SELECT id,slug,title,updated FROM pages ORDER BY updated DESC;'));
		// Define HTML subtemplate
		$f3->set('toptitle','Admin');
		$f3->set('body','pages.htm');
	}

	function robots($f3){
		$db = $this->db;
		$slug = $db->exec('SELECT slug FROM pages ORDER BY updated DESC;');
		$myfile = fopen('robots.txt', "w") or die("Unable to open file!");
		$txt = "User-Agent: *\nDisallow: \nAllow: /\nAllow: /archives\n";
		foreach ($slug as $value=>$v){
			$txt = $txt ."Allow: /".$v['slug']."\n";			
		}
		fwrite($myfile, $txt);
		fclose($myfile);
		$f3->reroute('/admin/pages');
	}

	function sitemap($f3){
		$db = $this->db;
		$slug = $db->exec('SELECT slug FROM pages ORDER BY updated DESC;');
		$myfile = fopen('sitemap.xml', "w") or die("Unable to open file!");
		$now = date('Y-m-d\Th:i:sP');
		$txt = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
				'<urlset'."\n".
				"\t".'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"'."\n".
				"\t".'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'."\n".
				"\t".'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9'."\n".
				"\t".'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'."\n".
				'<url>'."\n".
				"\t".'<loc>http://doanguyen.com/</loc>'."\n".
				"\t"."<lastmod>$now</lastmod>\n".
				"\t".'<changefreq>daily</changefreq>'."\n".
				'</url>'."\n".
				'<url>'."\n".
				"\t".'<loc>http://doanguyen.com/archives</loc>'."\n".
				"\t".'<changefreq>daily</changefreq>'."\n".
				'</url>'."\n";

		foreach ($slug as $value=>$v){
			$txt .= "<url>\n".
					"\t<loc>http://doanguyen.com/".$v['slug']."</loc>\n".
					"\t<lastmod>$now</lastmod>\n".
					"\t<changefreq>daily</changefreq>\n".
					"</url>\n";
		}
		 $txt .="</urlset>";
		fwrite($myfile, $txt);
		fclose($myfile);
		$f3->reroute('/admin/pages');
	}

	//! Re-sequence pages
	function move($f3) {
		$db=$this->db;
		// Determine direction of re-sequencing (-1:up, +1:down)
		$vector=$f3->sign($f3->get('GET.vector'));
		// Get reference page
		$page=new DB\SQL\Mapper($db,'pages');
		$slug=($f3->get('GET.slug')?:'');
		$page->load(array('slug=?',$slug));
		if (!$page->dry()) {
			// Find page to swap positions with
			$swap=$page->findone(array('position=?+?',
				array(1=>$page->get('position'),2=>$vector)));
			// Swap positions
			$db->exec(
				array(
					'UPDATE pages '.
						'SET position=position+? WHERE slug=?;',
					'UPDATE pages '.
						'SET position=position-? WHERE slug=?;'
				),
				array(
					array(1=>$vector,2=>$slug),
					array(1=>$vector,2=>$swap->get('slug'))
				)
			);
		}
		// Redirect
		$f3->reroute('/admin/pages');
	}

	//! Display editor form
	function edit($f3) {
		$f3->set('toptitle','Edit');
		// Define empty form
		$empty=array(
			'id'=>NULL,
			'title'=>NULL,
			'contents'=>NULL,
			'updated'=>NULL,
		);
		if ($f3->exists('GET.id')) {
			// Find matching page
			$page=new DB\SQL\Mapper($this->db,'pages');
			$page->load(array('id=?',$f3->get('GET.id')));
			if ($page->dry())
				// No match; new page
				$f3->set('POST',$empty);
			else
				// Existing page; prepare to edit
				$page->copyto('POST');
		}
		else
			// New page
			$f3->set('POST',$empty);
		// Define HTML subtemplate
		$f3->set('body','editor.htm');
	}

	//! Process editor form
	function exec($f3) {
		$db=$this->db;
		$page=new DB\SQL\Mapper($db,'pages');
		$f3->set('toptitle','Edit');
		// Validate submitted form
		if (!$f3->exists('POST.title') || !strlen($f3->get('POST.title')))
			$f3->set('message','Title is required');
		elseif (!$f3->exists('POST.contents') || !strlen($f3->get('POST.contents')))
			$f3->set('message','Page contents cannot be blank');
		else {
			// Generate slug from title
			$slug=Web::instance()->slug($f3->get('POST.title'));
			$id=$f3->get('POST.id');
			if ($slug=='home')
				$slug='';

				// Find matching page
				$page->load(array('id=?',$id));
				if ($page->dry()) {
					// Determine highest position in sequence
					$query=current($db->exec('SELECT MAX(id) AS maxpos FROM pages;'));
					
					#echo $query['maxpos']+2;exit();
				}
				// Replace data
				$page->copyfrom('POST');
				$page->set('slug',$slug);
				if ($f3->get('POST.utime')){
					$page->set('updated',time());
				}
				$page->save();
				

			// Redirect
			$f3->reroute('/admin/pages');
		}
		// Define HTML subtemplate
		$f3->set('body','editor.htm');
	}
	
	function newpage($f3) {
		$db=$this->db;
		$page=new DB\SQL\Mapper($db,'pages');
		$f3->set('toptitle','New article');
		// Validate submitted form
		if (!$f3->exists('POST.title') || !strlen($f3->get('POST.title')))
			$f3->set('message','Title is required');
		elseif (!$f3->exists('POST.contents') || !strlen($f3->get('POST.contents')))
			$f3->set('message','Page contents cannot be blank');
		else {
			// Generate slug from title
			$slug=Web::instance()->slug($f3->get('POST.title'));
			$title = $f3->get('POST.title');

			// Determine highest position in sequence
			$query=current($db->exec('SELECT MAX(id) AS maxpos FROM pages;'));
			$pageid = $query['maxpos']+1;
			// Replace data
			$content = $f3->get('POST.title');
			$utime = time();
			$db->exec("INSERT INTO `pages`(`slug`,`id`,`title`,`contents`,`updated`) VALUES ('$slug','$pageid','$title','$content','$utime')");

			// Redirect
			$f3->reroute('/admin/pages');
		}
		// Define HTML subtemplate
		$f3->set('body','editor.htm');
	}
	//! List assets
	function assets($f3) {
		// Build list from files in the uploads folder
		$assets=array();
		foreach (glob($f3->get('UPLOADS').'*') as $file)
			$assets[]=array(
				'name'=>basename($file),
				'posted'=>filemtime($file)
			);
		$f3->set('assets',$assets);
		// Define HTML subtemplate
		$f3->set('inc','assets.htm');
	}

	//! Process asset upload
	function upload($f3) {
		$db=$this->db;
		if (Web::instance()->receive(
			function($file) use($f3) {
				// Permit only MIME types specified in config file
				$allowed=$f3->get('allowed');
				return is_array($allowed) && in_array($file['type'],$allowed);
			}))
			// Redirect
			$f3->reroute('/admin/assets');
		// Something's not right with this uploaded file
		$f3->set('message','Upload failed');
		$this->assets($f3);
	}

}
