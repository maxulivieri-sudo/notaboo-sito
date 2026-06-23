<?php
get_header();
?>
<header class="nt-wp-header"><a class="brand" href="<?php echo esc_url(home_url('/')); ?>"><span class="brand-mark">N!</span><span>NOTABOO</span></a><a href="<?php echo esc_url(home_url('/')); ?>">Torna alla home</a></header>
<main class="nt-wp-shell">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article>
      <p class="nt-wp-kicker"><?php echo esc_html(get_the_date()); ?></p>
      <h1><?php the_title(); ?></h1>
      <?php if (has_post_thumbnail()) : ?><p><?php the_post_thumbnail('large'); ?></p><?php endif; ?>
      <div class="nt-wp-entry"><?php the_content(); ?></div>
    </article>
  <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
