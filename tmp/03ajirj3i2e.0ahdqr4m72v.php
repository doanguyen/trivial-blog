<div class="pure-g-r">
    <div class="pure-u-1-4 logo">
        <a href="<?php echo $BASE; ?>/" rel="home">
            <img src="<?php echo $BASE; ?>/ui/images/doa.jpg" alt="Doa Nguyen">
        </a>
    </div>

    <div class="pure-u-3-4 content">
        <h1>Blogs</h1>

<p>Since Jan 2015, after almost 2 years survived in Seoul, my vision is changed. I need to do blogging. I want to write not only important things but also a lot of trivial things. </p>

	<ul>
	<?php foreach (($menu?:array()) as $link): ?>
		<li><a href="<?php echo $BASE; ?>/<?php echo $link['slug']; ?>"><?php echo $link['title']; ?></a> <small>[<?php echo date($time_format,$link['updated']); ?>]</small></li>
	<?php endforeach; ?>
	</ul>
</div>
</div>