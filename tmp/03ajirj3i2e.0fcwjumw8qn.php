<link rel="stylesheet" href="<?php echo $BASE; ?>/ui/css/trumbowyg.min.css">
<div class="main">
	<form method="post" action="<?php echo $BASE; ?>/admin/pages/exec" class="editor">
		<h1><?php echo isset($POST['title'])?'Edit':'New'; ?> Page</h1>
		<?php if (isset($message)): ?>
		<p class="message"><?php echo $message; ?></p>
		<?php endif; ?>
		<p>
			<label for="title"><small>Title</small></label><br />
			<input id="title" name="title" type="text"  size="100" <?php echo isset($POST['title'])?('value="'.$POST['title'].'"'):''; ?> />
			<input type="hidden" id="id" name="id" value="<?php echo $POST['id']; ?>">
		</p>
		<p>
			<label for="contents"><small>Contents</small></label><br />
			<textarea id="contents" name="contents"><?php echo isset($POST['contents'])?$POST['contents']:''; ?></textarea>
		</p>
		<?php if (isset($POST['updated']) && $POST['updated']): ?>
		<p><small>Last updated <?php echo date($time_format,$POST['updated']); ?></small></p>
		<?php endif; ?>
		<p>
			<button id="save" name="save" class="button-success pure-button">Save</button>
		</p>
	</form>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.1.min.js"><\/script>')</script>
<script src="<?php echo $BASE; ?>/ui/js/trumbowyg.min.js"></script>
<script>$('#contents').trumbowyg({


});</script>