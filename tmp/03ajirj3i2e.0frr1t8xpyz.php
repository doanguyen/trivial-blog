<div class="login">
	<form method="post" action="<?php echo $BASE; ?>/login" class="login">
		<h5>Login</h5>
		<?php if (isset($message)): ?>
		<p class="message"><?php echo $message; ?></p>
		<?php endif; ?>
		<p>
			<label for="user_id"><small>User ID</small></label><br />
			<input id="user_id" name="user_id" type="text" autocomplete="off" <?php echo isset($POST['user_id'])?('value="'.$POST['user_id'].'"'):''; ?> />
		</p>
		<p>
			<label for="password"><small>Password</small></label><br />
			<input id="password" name="password" type="password" autocomplete="off"/>
		</p>
		<p>
			<input type="submit" class="button-success pure-button"/>
		</p>
	</form>
</div>