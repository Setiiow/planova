<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class("bg-gray-100"); ?>>

  <header class="bg-white py-3 border-b border-gray-200">
    <div class="max-w-screen-lg mx-auto flex gap-4 items-center">
      <?php if (function_exists('the_custom_logo')) the_custom_logo(); ?>
      <?php
      wp_nav_menu([
        'theme_location' => 'header_menu',
        'menu_class' => 'main-nav flex grow gap-3',
        'container' => false
      ]);
      ?>
      <?php 
// بررسی اینکه آیا صفحه فعلی صفحه ورود است یا خیر
if ( !is_page('login') ) : ?>
    <a href="<?php echo esc_url(get_permalink(get_page_by_path('login'))); ?>" 
       class="ml-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-blue-600">
       ورود
    </a>
<?php endif; ?>


    </div>
  </header>