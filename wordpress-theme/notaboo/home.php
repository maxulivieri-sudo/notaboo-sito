<?php
get_header();
?>
<header class="nt-wp-header"><a class="brand" href="<?php echo esc_url(home_url('/')); ?>"><span class="brand-mark">N!</span><span>NOTABOO</span></a><a href="<?php echo esc_url(home_url('/')); ?>">Torna alla home</a></header>
<main class="nt-wp-shell">
  <p class="nt-wp-kicker">Diario NoTaboo</p>
  <h1>STORIE E<br><em>RISORSE.</em></h1>
  <div class="nt-wp-list">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article class="nt-wp-card"><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p><?php echo esc_html(get_the_excerpt()); ?></p></article>
    <?php endwhile; else : ?><p>Nessun articolo pubblicato per ora.</p><?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>
