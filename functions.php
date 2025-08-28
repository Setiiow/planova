<?php
function mytheme_setup()
{
  add_theme_support('post-thumbnails');
  add_theme_support('custom-background');
  add_theme_support('title-tag');
  add_theme_support('custom-logo');
  register_nav_menus([
    "menu-left"  => "Menu Left",
    "menu-right" => "Menu Right",
  ]);
}
add_action('after_setup_theme', 'mytheme_setup');

function planova_enqueue_styles()
{
  wp_enqueue_style(
    'planova-style', // Handle name
    get_stylesheet_uri(), // This gets style.css in the root of the theme

  );
  wp_enqueue_script(
    'tailwind', // Handle name
    "https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4", // This gets style.css in the root of the theme

  );
}
add_action('wp_enqueue_scripts', 'planova_enqueue_styles');





