<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body <?php body_class("bg-gray-100 text-gray-600"); ?>>

  <header class="bg-[#fdf7f0] border-b-2 border-[#e5cfa3] text-gray-800 rounded-b-2xl">
    <div class="max-w-[1100px] mx-auto flex items-center justify-between px-4 py-4 relative">

      <!--(منوی همبرگری (سمت راست -->
      <button id="hamburger-btn" class="p-2 md:hidden z-20">
        <i class="fa fa-bars text-[#d4a373] text-2xl"></i>
      </button>

      <!-- لوگو -->
      <div class="flex-1 flex justify-center md:justify-start">
        <?php if (function_exists("the_custom_logo")) {
          the_custom_logo();
        } ?>
      </div>

      <!-- منوی اصلی وسط هدر (دسکتاپ) -->
      <nav class="header-menu hidden md:flex absolute left-1/2 transform -translate-x-1/2 flex-row gap-6">
        <?php
        wp_nav_menu([
          'theme_location' => 'header_menu',
          'container' => false,
          'menu_class' => 'flex gap-6',
          'walker' => new class extends Walker_Nav_Menu {
            function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
            {
              $active = in_array('current-menu-item', (array) $item->classes) ? 'border-b-2 border-[#d4a373]' : '';
              $output .= '<li><a href="' . esc_url($item->url) . '" class="pb-1 hover:border-b-2 hover:border-[#d4a373] ' . $active . '">'
                . esc_html($item->title) . '</a></li>';
            }
          }
        ]);
        ?>
      </nav>

      <!-- دکمه ورود ، انتخاب نقش -->
      <div class="flex-none flex items-center relative">

        <?php if (is_user_logged_in()) : ?>
          <!-- دکمه خروج -->
          <a href="<?php echo wp_logout_url(home_url()); ?>"
            class="relative px-4 py-2 rounded-full font-semibold bg-[#f7d59c] text-gray-800
            shadow-[0_4px_10px_rgba(180,140,100,0.3)]
            hover:bg-[#f2c57c] hover:text-gray-900
            hover:shadow-[0_4px_10px_rgba(180,140,100,0.4)]
            transition transform duration-200 ease-in-out hover:scale-105 text-sm md:text-base">

            خروج

            <!-- ستاره -->
            <svg class="absolute top-0 left-0 w-4 h-4 text-gray-600 animate-pulse" fill="#f4c056" viewBox="0 0 24 24">
              <path d="M12 0L14.5 7.5L22.5 8.5L16.5 13L18 21L12 17.5L6 21L7.5 13L1.5 8.5L9.5 7.5L12 0Z" />
            </svg>
            <svg class="absolute right-1 w-4 h-4 text-gray-600 animate-pulse" fill="#f4c056" viewBox="0 0 24 24">
              <path d="M12 0L14.5 7.5L22.5 8.5L16.5 13L18 21L12 17.5L6 21L7.5 13L1.5 8.5L9.5 7.5L12 0Z" />
            </svg>
          </a>

        <?php else : ?>
          <!-- دکمه اصلی -->
          <button id="role-btn"
            class="relative px-4 py-2 rounded-full font-semibold bg-[#f7d59c] text-gray-800
           shadow-[0_4px_10px_rgba(180,140,100,0.3)]
           hover:bg-[#f2c57c] hover:text-gray-900
           hover:shadow-[0_4px_10px_rgba(180,140,100,0.4)]
           transition transform duration-200 ease-in-out hover:scale-105 text-sm md:text-base">

            ورود

            <!-- ستاره -->
            <svg class="absolute top-0 left-1 w-4 h-4 text-gray-600 animate-pulse" fill="#f4c056" viewBox="0 0 24 24">
              <path d="M12 0L14.5 7.5L22.5 8.5L16.5 13L18 21L12 17.5L6 21L7.5 13L1.5 8.5L9.5 7.5L12 0Z" />
            </svg>
            <svg class="absolute right-1 w-4 h-4 text-gray-600 animate-pulse" fill="#f4c056" viewBox="0 0 24 24">
              <path d="M12 0L14.5 7.5L22.5 8.5L16.5 13L18 21L12 17.5L6 21L7.5 13L1.5 8.5L9.5 7.5L12 0Z" />
            </svg>
          </button>
          <!-- منوی کشویی -->
          <div id="role-menu"
            class="absolute top-full mt-2 hidden flex-col 
          bg-white
          rounded-xl shadow-lg 
          min-w-[160px] sm:min-w-[192px] 
          max-w-[85vw] sm:max-w-xs
          origin-top-left left-0 
          flex text-sm sm:text-base border border-[#e5cfa3]
          transition-all duration-200 ease-in-out">

            <a href="<?php echo site_url('/login/'); ?>"
              class="px-3 sm:px-4 py-2 sm:py-3 text-center font-medium 
            bg-transparent hover:bg-[#f7d59c] hover:text-gray-900
            text-gray-800
            transition-all duration-200 ease-in-out
            rounded-t-xl">
              والدین / معلم
            </a>

            <a href="<?php echo site_url('/member-login/'); ?>"
              class="px-3 sm:px-4 py-2 sm:py-3 text-center font-medium 
            bg-transparent hover:bg-[#f2c57c] hover:text-gray-900
            text-gray-700
            transition-all duration-200 ease-in-out
            rounded-b-xl">
              اعضا
            </a>
          </div>
        <?php endif; ?>
      </div>

      <!-- منوی موبایل -->
      <?php
      wp_nav_menu([
        'theme_location' => 'header_menu',
        'container' => false,
        'menu_class' => 'mobile-menu absolute top-full right-0 mt-2 hidden flex-col gap-4 bg-[#fdf7f0] text-gray-800 p-4 rounded-lg shadow-lg w-56',
        'walker' => new class extends Walker_Nav_Menu {
          function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
          {
            $output .= '<li><a href="' . esc_url($item->url) . '" class="block py-2 px-3 hover:bg-[#f2c57c] hover:text-gray-900 rounded">'
              . esc_html($item->title) . '</a></li>';
          }
        }
      ]);
      ?>
    </div>


      <script>
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const mobileMenu = document.querySelector('.mobile-menu');

        hamburgerBtn.addEventListener('click', () => {
          mobileMenu.classList.toggle('hidden');
          const icon = hamburgerBtn.querySelector('i');
          if (icon.classList.contains('fa-bars')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-xmark');
          } else {
            icon.classList.remove('fa-xmark');
            icon.classList.add('fa-bars');
          }
        });

        const roleBtn = document.getElementById('role-btn');
        const roleMenu = document.getElementById('role-menu');

        roleBtn?.addEventListener('click', () => {
          roleMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(e) {
          if (!roleBtn?.contains(e.target) && !roleMenu?.contains(e.target) && !hamburgerBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
            roleMenu?.classList.add('hidden');
            mobileMenu?.classList.add('hidden');
            hamburgerBtn.querySelector('i').classList.remove('fa-xmark');
            hamburgerBtn.querySelector('i').classList.add('fa-bars');
          }
        });

        // لوگو وسط برای صفحه‌های کوچک
        const logoContainer = document.querySelector('.flex-1');

        function checkWidth() {
          if (window.innerWidth < 768) {
            logoContainer.classList.add('justify-center');
          } else {
            logoContainer.classList.remove('justify-center');
          }
        }
        window.addEventListener('resize', checkWidth);
        checkWidth();
      </script>
  </header>