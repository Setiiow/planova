<?php
function mytheme_setup()
{
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
function mytheme_enqueue_scripts()
{
    wp_enqueue_style('mytheme-style', get_stylesheet_uri());
    wp_enqueue_script('tailwind', 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4', [], false, true);
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');

function toPersianNumerals($input)
{
    $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return str_replace($english, $persian, (string) $input);
}

add_action('init', function () {
    if (!get_role('parent')) {
        add_role('parent', 'والد', ['read' => true]);
    }
    if (!get_role('teacher')) {
        add_role('teacher', 'معلم', ['read' => true]);
    }
});

add_action('admin_init', function () {
    if (!current_user_can('administrator') && is_admin() && !defined('DOING_AJAX')) {
        wp_redirect(home_url('/dashboard'));
        exit;
    }
});

add_filter('login_redirect', function ($redirect_to, $request, $user) {
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('parent', $user->roles)) {
            return home_url('/dashboard');
        } elseif (in_array('teacher', $user->roles)) {
            return home_url('/dashboard');
        }
    }
    return $redirect_to;
}, 10, 3);

add_filter('login_url', function ($login_url) {
    if (!is_admin()) {
        return home_url('/login');
    }
    return $login_url;
});

// بارگذاری توابع آپلود و رسانه وردپرس برای کل سایت
function planova_load_media_functions() {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
}
add_action('init', 'planova_load_media_functions');
