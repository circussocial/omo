<!DOCTYPE html>
<html>
<head>
<title>
<?php bloginfo('name'); ?>
<?php wp_title(); ?>
</title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<!-- leave this for stats please -->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_get_archives('type=monthly&format=link'); ?>
<?php //comments_popup_script(); // off by default ?>
<?php wp_head(); ?>
</head>

<body>
<div class="omoWrapper">
	<div class="omo">
    	<?php if(have_posts()) : ?>
    <?php while(have_posts()) : the_post();?>
			<div class="omoFeed">
			<?php the_content(); ?>
			</div>
	<?php endwhile; ?>
    <?php endif; ?>
    </div>
</div>
<?php wp_footer(); ?>
</body>
</html>
