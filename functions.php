<?php
// بارگذاری فایل style.css
function planova_enqueue_styles() {
    wp_enqueue_style('planova-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'planova_enqueue_styles');
