<script src="/ui/ckeditor/ckeditor.js"></script>
<div class="main">
	<form method="post" action="<?php echo $BASE; ?>/admin/pages/exec" class="editor">
		<h1><?php echo isset($POST['title'])?'Edit':'New'; ?> Page</h1>
		<?php if (isset($message)): ?>
		<p class="message"><?php echo $message; ?></p>
		<?php endif; ?>
		<p>
		<table>
		<tr><td>
			<label for="title"><small>Title</small></label><br />
			<input id="title" name="title" type="text"  size="60" <?php echo isset($POST['title'])?('value="'.$POST['title'].'"'):''; ?> />
			<input type="hidden" id="id" name="id" value="<?php echo $POST['id']; ?>">
		</td>
		<?php if (isset($POST['title'])): ?>
		<td>
			<label for="checkbox"><small>Update time?</small></label><br />
			<input type="checkbox" id="utime" name="utime">
		</td>
		<?php endif; ?>
		</tr>
		</table>
		</p>
		<p>
			<label for="contents"><small>Contents</small></label><br />
			<textarea id="contents" name="contents" rows="40"><?php echo Base::instance()->raw(isset($POST['contents'])?$POST['contents']:''); ?></textarea>
		</p>
		<?php if (isset($POST['updated']) && $POST['updated']): ?>
		<p><small>Last updated <?php echo date($time_format,$POST['updated']); ?></small></p>
		<?php endif; ?>
		<p>
			<button id="save" name="save" class="button-success pure-button">Save</button>
		</p>
	</form>
</div>

<script>
	CKEDITOR.replace( 'contents' );
</script>