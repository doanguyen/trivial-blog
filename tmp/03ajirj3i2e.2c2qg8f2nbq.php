<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<link rel="icon" type="image/png" href="<?php echo $BASE; ?>/ui/images/favicon.png" sizes="96x96">
		<title><?php echo $toptitle; ?> - doanguyen.com</title>
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/pure/0.4.2/pure-min.css">
		<link rel="stylesheet" href="<?php echo $BASE; ?>/ui/css/core.css" type="text/css" />
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/styles/default.min.css">
	</head>
	<body>
		<?php echo $this->render($body,$this->mime,get_defined_vars()); ?>
	</body>
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/highlight.min.js"></script>	
	<script>hljs.initHighlightingOnLoad();</script>
</html>
