<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body <?php body_class("bg-gray-100 text-gray-600"); ?>>

  <header class="bg-purple1 border-b-3 border-[#f4c056] text-white">
    <div class="max-w-[1100px] mx-auto flex items-center justify-between px-4 py-4">

      <!-- لوگو سمت راست -->
      <div class="flex-none flex ">
        <?php if (function_exists("the_custom_logo")) {
          the_custom_logo();
        } ?>
      </div>

      <!-- منوی اصلی وسط هدر -->
      <?php
      wp_nav_menu([
        'theme_location' => 'header_menu',
        'container' => false,
        'menu_class' => 'flex gap-6',
        'walker' => new class extends Walker_Nav_Menu {
          function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
          {
            $active = in_array('current-menu-item', $item->classes) ? 'border-b-2 border-yellow-400' : '';
            $output .= '<li><a href="' . esc_url($item->url) . '" class="pb-1 hover:border-b-2 hover:border-yellow-400 ' . $active . '">'
              . esc_html($item->title) . '</a></li>';
          }
        }
      ]);
      ?>


      <!-- دکمه ورود ، انتخاب نقش -->
      <div class="flex-none flex items-center relative">

        <?php if (is_user_logged_in()) : ?>
          <!-- دکمه خروج -->
          <a href="<?php echo wp_logout_url(home_url()); ?>"
            class="relative px-4 py-2 rounded-full font-semibold bg-[#f4c056] text-white
              shadow-[0_6px_15px_rgba(126,103,139,0.3)]
              hover:bg-[#efce7b] hover:text-[#7c51e0]
              hover:shadow-[0_6px_15px_rgba(254,200,154,0.5)]
              transition transform duration-200 ease-in-out hover:scale-105 text-sm md:text-base">

            خروج

            <!-- ستاره -->
            <svg class="absolute top-0 left-1 w-3 h-3 text-white animate-pulse" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 0L14.5 7.5L22.5 8.5L16.5 13L18 21L12 17.5L6 21L7.5 13L1.5 8.5L9.5 7.5L12 0Z" />
            </svg>
          </a>

        <?php else : ?>
          <!-- دکمه اصلی -->
          <button id="role-btn"
            class="relative px-4 py-2 rounded-full font-semibold bg-[#f4c056] text-white
             shadow-[0_6px_15px_rgba(126,103,139,0.3)]
             hover:bg-[#efce7b] hover:text-[#7c51e0]
             hover:shadow-[0_6px_15px_rgba(254,200,154,0.5)]
             transition transform duration-200 ease-in-out hover:scale-105 text-sm md:text-base">

            ورود

            <!-- ستاره -->
            <svg class="absolute top-0 left-1 w-3 h-3 text-white animate-pulse" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 0L14.5 7.5L22.5 8.5L16.5 13L18 21L12 17.5L6 21L7.5 13L1.5 8.5L9.5 7.5L12 0Z" />
            </svg>
          </button>
          <!-- منوی کشویی -->
          <div id="role-menu"
            class="absolute top-full mt-2 hidden flex-col 
            bg-gradient-to-br from-[#ffffff] to-[#fefcf9]
            rounded-xl shadow-xl 
            min-w-[160px] sm:min-w-[192px] 
            max-w-[85vw] sm:max-w-xs   <!-- کنترل عرض -->
            origin-top-left left-0 
            flex text-sm sm:text-base border border-[#f4c056]
            transition-all duration-200 ease-in-out">

            <a href="http://localhost/planova/login/"
              class="px-3 sm:px-4 py-2 sm:py-3 text-center font-medium 
              bg-transparent hover:bg-[#f4c056] hover:text-white
              text-[#7c51e0]
              transition-all duration-200 ease-in-out
              rounded-t-xl">
              والدین / معلم
            </a>

            <a href="http://localhost/planova/member-login/"
              class="px-3 sm:px-4 py-2 sm:py-3 text-center font-medium 
              bg-transparent hover:bg-[#7c51e0] hover:text-white
              text-[#f4c056]
              transition-all duration-200 ease-in-out
              rounded-b-xl">
              اعضا
            </a>
          </div>



        <?php endif; ?>

      </div>

      <script>
        // باز و بسته کردن منو
        const roleBtn = document.getElementById('role-btn');
        const roleMenu = document.getElementById('role-menu');

        roleBtn?.addEventListener('click', () => {
          roleMenu.classList.toggle('hidden');
        });

        // کلیک بیرون منو = بسته شدن
        document.addEventListener('click', function(e) {
          if (!roleBtn.contains(e.target) && !roleMenu.contains(e.target)) {
            roleMenu.classList.add('hidden');
          }
        });
      </script>
    </div>
  </header>