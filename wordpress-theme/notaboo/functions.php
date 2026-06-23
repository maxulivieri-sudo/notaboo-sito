<?php
/**
 * Funzioni del tema NoTaboo.
 */

if (!defined('ABSPATH')) {
    exit;
}

function notaboo_asset_url($path = '') {
    return get_template_directory_uri() . '/' . ltrim($path, '/');
}

function notaboo_enqueue_assets() {
    wp_enqueue_style('notaboo-fonts', 'https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700&family=Space+Grotesk:wght@400;500;600;700&display=swap', array(), null);
    $stylesheets = array('styles.css', 'project.css', 'brand.css', 'typography.css', 'deployment.css', 'wordpress.css');
    if (is_page_template(array('page-edizione-2024.php', 'page-edizione-2025.php', 'page-edizione-2026.php'))) {
        $stylesheets[] = 'edition.css';
    }
    if (is_page_template('page-edizione-2024.php')) {
        $stylesheets[] = 'edition-2024.css';
    }
    foreach ($stylesheets as $stylesheet) {
        $path = get_template_directory() . '/' . $stylesheet;
        wp_enqueue_style('notaboo-' . sanitize_title($stylesheet), notaboo_asset_url($stylesheet), array(), file_exists($path) ? filemtime($path) : null);
    }

    $script_path = get_template_directory() . '/app.js';
    wp_enqueue_script('notaboo-app', notaboo_asset_url('app.js'), array(), file_exists($script_path) ? filemtime($script_path) : null, true);
    wp_localize_script('notaboo-app', 'noTabooTheme', array('url' => get_template_directory_uri()));
}
add_action('wp_enqueue_scripts', 'notaboo_enqueue_assets');

function notaboo_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
}
add_action('after_setup_theme', 'notaboo_theme_setup');

/** Renderizza il markup statico del prototipo dentro la cornice WordPress. */
function notaboo_render_static($template) {
    $file = get_template_directory() . '/templates/' . $template;
    if (!file_exists($file)) {
        return;
    }

    $html = file_get_contents($file);
    if (!preg_match('/<body[^>]*>(.*)<\/body>/si', $html, $matches)) {
        return;
    }

    $content = preg_replace('/<script[^>]+src=["\']app\.js["\'][^>]*><\/script>/i', '', $matches[1]);
    $home = esc_url(home_url('/'));
    $replacements = array(
        'href="index.html"' => 'href="' . $home . '"',
        'href="index.html#' => 'href="' . $home . '#',
        'href="edizione-2024.html"' => 'href="' . esc_url(home_url('/edizione-2024/')) . '"',
        'href="edizione-2025.html"' => 'href="' . esc_url(home_url('/edizione-2025/')) . '"',
        'href="edizione-2026.html"' => 'href="' . esc_url(home_url('/edizione-2026/')) . '"',
    );

    echo strtr($content, $replacements); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- markup locale del tema.
}

function notaboo_edition_template($year, $template) {
    get_header();
    wp_add_inline_script('notaboo-app', "document.body.dataset.edition = '" . esc_js($year) . "';", 'before');
    notaboo_render_static($template);
    get_footer();
}
