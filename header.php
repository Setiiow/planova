<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <script src="https://cdn.tailwindcss.com"></script> <!--برای استفاده از کلاس های آماده tailwind -->
</head>
<body <?php body_class("bg-gray-100"); ?>>
<?php wp_body_open(); ?><!-- برای اضافه کردن هوک افزونه ها ووردپرس-->
<header class="relative overflow-hidden text-white" style="background: linear-gradient(135deg, #7B61FF, #8356FF); padding:40px 16px;">

  <!--کانتینر اصلی هدر -->
  <div class="max-w-[1100px] mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
    
    <!-- نمایش لوگو در صورتی که وجود داشت نشان داده میشود درغیر اینصورت با نام سایت به صفحه اصلی لینک میشود  -->
    <div class="site-branding">
      <?php if ( function_exists('the_custom_logo') && has_custom_logo() ) {
          the_custom_logo();
        } else { ?>
          <a class="text-white font-bold text-lg no-underline" href="<?php echo esc_url(home_url('/')); ?>">
            <?php bloginfo('name'); ?>
          </a>
      <?php } ?>
    </div>

  <!-- منوی وردپرس -->
<nav class="main-menu flex flex-col md:flex-row gap-4">
  <?php
  wp_nav_menu([
    'theme_location' => 'header_menu',
    'container'      => false,
    'menu_class'     => 'flex flex-col md:flex-row gap-4',
    'walker'         => new class extends Walker_Nav_Menu {
      function start_el(&$output, $item, $depth = 0, $args = [], $id = 0) {
        $classes = 'px-4 py-2 rounded-full transition-colors duration-200 hover:bg-yellow-400 hover:text-purple-700';
        $output .= '<a href="' . esc_url($item->url) . '" class="' . $classes . '">' . esc_html($item->title) . '</a>';
      }
    }
  ]);
  ?>
</nav>

<!--تب‌ها که به صفحات مختلف لینک میشوند  -->
<nav class="header-tabs mt-6 flex justify-center gap-3">
  <?php $current_page = get_post_field('post_name', get_post()); ?>
  
  <a href="/joayez" class="px-4 py-2 rounded-full font-semibold transition-colors duration-200 
     <?php echo ($current_page=='joayez') ? 'bg-purple-700 text-yellow-400' : 'bg-yellow-400 text-purple-700 hover:bg-purple-700 hover:text-yellow-400'; ?>">
     جوایز من
  </a>

  <a href="/ahdaf" class="px-4 py-2 rounded-full font-semibold transition-colors duration-200 
     <?php echo ($current_page=='ahdaf') ? 'bg-purple-700 text-yellow-400' : 'bg-white/50 text-white hover:bg-yellow-400 hover:text-purple-700'; ?>">
     اهداف
  </a>

  <a href="/packages" class="px-4 py-2 rounded-full font-semibold transition-colors duration-200 
     <?php echo ($current_page=='packages') ? 'bg-purple-700 text-yellow-400' : 'bg-white/50 text-white hover:bg-yellow-400 hover:text-purple-700'; ?>">
     پکیج های آموزشی
  </a>
</nav>


<!--  دکمه ورود و ثبت نام -->
<?php if ( !is_page('login') ) : ?>
  <div class="flex mt-4 space-x-5">
    <a href="<?php echo esc_url(get_permalink(get_page_by_path('login'))); ?>" 
       class="px-4 py-2 rounded-full font-semibold transition transform bg-yellow-400 text-purple-700 hover:bg-yellow-300 hover:-translate-y-1">
       ورود
    </a>
    <a href="<?php echo esc_url(get_permalink(get_page_by_path('regester'))); ?>" 
       class="px-4 py-2 rounded-full font-semibold transition transform bg-yellow-400 text-purple-700 hover:bg-yellow-300 hover:-translate-y-1">
       ثبت نام 
    </a>
  </div>
<?php endif; ?>


  

  <!-- موج پایین هدر که برا طراحی گرافیکی زیبا استفاده شده و سفید رنگ هستش  -->
  <svg class="absolute bottom-0 left-0 w-full h-16" viewBox="0 0 1440 100" preserveAspectRatio="none" aria-hidden="true">
    <path fill="#ffffff" d="M0,30 C320,90 1120,0 1440,30 L1440 100 L0 100 Z"></path>
  </svg>
</header>
