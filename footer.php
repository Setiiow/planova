<footer dir="rtl" class="bg-[#fdf7f0] text-[#6B4C3B] border-t-2 border-[#e5cfa3] rounded-t-4xl">
  <div class="max-w-[1100px] mx-auto px-4 flex flex-col justify-center min-h-[350px]">

    <!-- محتوای اصلی فوتر -->
    <div class="flex flex-wrap items-start justify-between gap-x-8 gap-y-8">
      
      <!-- ستون: درباره ما -->
      <div class="flex-1 min-w-[200px] flex flex-col md:items-start text-center md:text-right">
        <h3 class="text-xl font-bold mb-4 text-center w-full">درباره ما</h3>
        <p class="text-sm leading-6">
          پلانووا با هدف ترویج مهارت‌های برنامه‌ریزی، مدیریت زمان و مسئولیت‌پذیری در کودکان، بستری آموزشی و انگیزشی فراهم کرده تا والدین و معلمان بتوانند رشد و یادگیری کودکان را به شکل هدفمند و مؤثر همراهی کنند.
        </p>
      </div>

      <!-- ستون: بخش‌های سایت -->
      <div class="flex-1 min-w-[150px] flex flex-col items-center text-center md:text-right">
        <h3 class="text-xl font-bold mb-4">بخش‌های سایت</h3>
        <ul class="space-y-2 text-sm">
          <li><a href="<?php echo site_url('/'); ?>" class="hover:text-[#8B5E3C] transition">🏠 صفحه اصلی</a></li>
          <li><a href="<?php echo site_url('/tasks'); ?>" class="hover:text-[#8B5E3C] transition">🎯 وظایف</a></li>
          <li><a href="<?php echo site_url('/rewards'); ?>" class="hover:text-[#8B5E3C] transition">🏆 جوایز</a></li>
          <li><a href="<?php echo site_url('/members'); ?>" class="hover:text-[#8B5E3C] transition">👨‍👩‍👧‍👦 اعضا</a></li>
        </ul>
      </div>

      <!-- ستون: ارتباط با ما -->
      <div class="flex-1 min-w-[180px] flex flex-col items-center text-center md:text-right">
        <h3 class="text-xl font-bold mb-4">ارتباط با ما</h3>
        <a href="mailto:planova@gmail.com"
           class="inline-flex items-center gap-2 bg-[#f2c57c] text-[#6B4C3B] px-4 py-2 rounded-full shadow-[0_4px_10px_rgba(180,140,100,0.3)] hover:shadow-[0_4px_10px_rgba(180,140,100,0.4)] transition mb-4">
          <i class="fa-solid fa-envelope"></i>
          <span class="font-medium">planova@gmail.com</span>
        </a>

        <div class="flex items-center justify-center gap-4">
          <a href="https://t.me/example" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-[#6B4C3B] text-white hover:bg-[#f2c57c] hover:text-[#6B4C3B] transition">
            <i class="fa-brands fa-telegram-plane text-lg"></i>
          </a>
          <a href="https://instagram.com/example" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-[#6B4C3B] text-white hover:bg-[#f2c57c] hover:text-[#6B4C3B] transition">
            <i class="fa-brands fa-instagram text-lg"></i>
          </a>
          <a href="https://linkedin.com/example" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-[#6B4C3B] text-white hover:bg-[#f2c57c] hover:text-[#6B4C3B] transition">
            <i class="fa-brands fa-linkedin-in text-lg"></i>
          </a>
        </div>
      </div>

      <!-- ستون: لوگو -->
      <div class="flex-1 min-w-[200px] flex justify-center md:justify-center items-center">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png"
             alt="Planova Logo"
             class="h-24 md:h-32 w-auto object-contain">
      </div>

    </div>

    <!-- کپی‌رایت -->
    <div class="text-center text-xs text-[#8B5E3C] mt-8 border-t border-[#f2c57c]/30 pt-4">
      © <?php echo date('Y'); ?> پلانووا | همه حقوق محفوظ است.
    </div>

  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
