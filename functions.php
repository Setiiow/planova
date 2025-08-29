<?php
function mytheme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('menus');
}
add_action('after_setup_theme', 'mytheme_setup');

register_nav_menus([
    'header_menu' => 'Header Menu',
]);

// Enqueue CSS و Tailwind
function mytheme_enqueue_scripts() {
    wp_enqueue_style('mytheme-style', get_stylesheet_uri());
    wp_enqueue_script('tailwind', 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4', [], false, true);
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');


function toPersianNumerals($input) {
    $english = ['0','1','2','3','4','5','6','7','8','9'];
    $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    return str_replace($english, $persian, (string) $input);
}
function add_custom_roles() {
    add_role('parent', 'والد', ['read' => true]);
    add_role('teacher', 'معلم', ['read' => true]);
}
add_action('init', 'add_custom_roles');
