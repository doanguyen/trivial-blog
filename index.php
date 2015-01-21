<?php

// Retrieve instance of the framework
$f3=require('lib/base.php');

// Initialize CMS
$f3->config('app/config.ini');

// Define routes
$f3->config('app/routes.ini');

// Execute application
$f3->run();
