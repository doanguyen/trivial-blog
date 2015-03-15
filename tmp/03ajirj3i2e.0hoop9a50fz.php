<div class="pure-g-r">
    <div class="pure-u-1-4 logo">
        <a href="<?php echo $BASE; ?>/" rel="home">
            <img src="ui/images/doa.jpg" alt="Doa Nguyen">
        </a>
        <?php if (isset($SESSION['user_id'])): ?>
        <p>
            <button id="save" name="save" class="button-success pure-button" onclick="window.location='<?php echo $BASE; ?>/admin/pages/edit?id=<?php echo $menu['id']; ?>';">Edit</button>
        </p>
        <?php endif; ?>
    </div>

    <article class="pure-u-3-4 blog content">
        <header>
            <h1 class="title"><a href="" rel="bookmark"><?php echo $menu['title']; ?></a></h1>
        </header>        
            <p><?php echo $content; ?></p>
        <footer>
            <p class="published">
                Published
                <time datetime="2013-10-04T22:23:21.468Z" pubdate>
                    <a href="" rel="bookmark"><?php echo date('d M Y h:ia',$menu['updated']); ?></a>
                </time>
            </p>

            <p class="copyright">
                From <?php echo $name; ?>. All rights reserved.
            </p>
        </footer>
    </article>
</div>