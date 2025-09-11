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

add_action('wp_enqueue_scripts', function(){
  // استایل اصلی
  wp_enqueue_style('planova-style', get_stylesheet_uri(), [], wp_get_theme()->get('Version'));
  
  // استایل هدر
  wp_enqueue_style('planova-header', get_template_directory_uri() . '/assets/css/header.css', ['planova-style'], '1.0');
  
  // اسکریپت تب‌ها
  wp_enqueue_script('planova-header-js', get_template_directory_uri() . '/assets/js/header.js', [], '1.0', true);
});

// بارگذاری توابع آپلود و رسانه وردپرس برای کل سایت
function planova_load_media_functions() {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
}
add_action('init', 'planova_load_media_functions');

// بارگزاری IRANYekanX فونت
function mytheme_enqueue_fonts() {
    wp_enqueue_style(
        'fontiran',
        get_template_directory_uri() . '/assets/fontiran.css',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_fonts');

function two_posts_shortcode() {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 2,
        'orderby'        => 'date',
        'order'          => 'DESC'
    );
    $query = new WP_Query($args);
    ob_start();
    if ($query->have_posts()) : ?>
        <div class="grid gap-8 sm:grid-cols-2">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-2xl transition transform hover:-translate-y-1 duration-300">
                    
                    <!-- دسکتاپ و تبلت: کارت بزرگ بالای متن -->
                    <a href="<?php the_permalink(); ?>" class="hidden sm:block">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large', [
                                'class' => 'w-full h-56 object-cover group-hover:scale-105 transition duration-300'
                            ]); ?>
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.png"
                                class="w-full h-56 object-cover" alt="no image">
                        <?php endif; ?>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-[#6B4C3B] mb-2 group-hover:text-[#f2c57c] transition">
                                <?php the_title(); ?>
                            </h3>
                            <p class="text-sm text-gray-500">
                                منتشر شده در <?php echo get_the_date('j F Y'); ?>
                            </p>
                        </div>
                    </a>

                    <!-- موبایل: کارت باریک افقی زیر هم -->
                    <a href="<?php the_permalink(); ?>" class="flex sm:hidden flex-row items-center bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition p-3 mb-4">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', [
                                'class' => 'w-20 h-20 object-cover rounded-lg flex-shrink-0 mr-3'
                            ]); ?>
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.png"
                                class="w-20 h-20 object-cover rounded-lg flex-shrink-0 mr-3" alt="no image">
                        <?php endif; ?>
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-[#6B4C3B] mb-1"><?php the_title(); ?></h3>
                            <p class="text-xs text-gray-500"><?php echo get_the_date('j F Y'); ?></p>
                        </div>
                    </a>

                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    <?php endif;
    return ob_get_clean();
}
add_shortcode('latest_two_posts', 'two_posts_shortcode');
