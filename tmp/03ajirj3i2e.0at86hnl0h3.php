
<div class="main">
	<h3>Pages</h3>
	<table>
		<?php $count=count($pages); ?>
		<?php $counter=0; foreach (($pages?:array()) as $page): $counter++; ?>
		<tr <?php echo $counter%2?'class="odd"':''; ?>>
			<td class="title"><a href="<?php echo $BASE; ?>/admin/pages/edit?id=<?php echo $page['id']; ?>"><?php echo $page['title']; ?></a><br /><small><?php echo $page['updated']?date($time_format,$page['updated']):'&nbsp;'; ?></small></td>
			
		</tr>
		<?php endforeach; ?>
	</table>
	<form method="get" action="<?php echo $BASE; ?>/admin/pages/edit">
		<button name="new" class="button-success pure-button">New</button>
	</form>
</div>