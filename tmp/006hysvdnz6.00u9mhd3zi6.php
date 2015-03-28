<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<link rel="icon" type="image/png" href="<?php echo $BASE; ?>/ui/images/favicon.png" sizes="96x96">
		<title><?php echo $toptitle; ?> - doanguyen.com</title>
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/pure/0.4.2/pure-min.css">
		<link rel="stylesheet" href="<?php echo $BASE; ?>/ui/css/core.css" type="text/css" />
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/styles/default.min.css">
		<script type="text/x-mathjax-config">
  MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
</script>
	<script type="text/javascript"  src="//cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>
	</head>
	<body>
		<?php echo $this->render($body,$this->mime,get_defined_vars()); ?>
	</body>
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/highlight.min.js"></script>	
	<script>hljs.initHighlightingOnLoad();</script>
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-37376311-1', 'auto');
	ga('send', 'pageview');
	</script>
	

</html>
