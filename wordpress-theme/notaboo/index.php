<?php
get_header();
if (have_posts()) {
    while (have_posts()) {
        the_post();
        echo '<main class="section-wrap" style="padding-top:160px;padding-bottom:120px">';
        the_title('<h1>', '</h1>');
        the_content();
        echo '</main>';
    }
}
get_footer();
