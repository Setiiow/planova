<footer dir="rtl" class="bg-[#fdf7f0] text-[#6B4C3B] border-t-2 border-[#e5cfa3] rounded-t-4xl">
  <div class="max-w-[1100px] mx-auto px-4 py-10 md:py-14 flex flex-col justify-center">

    <!-- محتوای اصلی فوتر -->
    <div class="flex flex-wrap items-start justify-between gap-x-8 gap-y-12">
      
      <!-- ستون: لوگو (اول در موبایل) -->
      <div class="order-1 md:order-4 flex-1 min-w-[200px] flex justify-center md:justify-center items-center">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png"
             alt="Planova Logo"
             class="h-20 md:h-28 w-auto object-contain">
      </div>

      <!-- ستون: درباره ما -->
      <div class="order-2 md:order-1 flex-1 min-w-[200px] flex flex-col md:items-start text-center md:text-right">
        <h3 class="text-xl font-bold mb-4 text-center w-full">درباره ما</h3>
        <p class="text-sm leading-6">
          پلانووا با هدف ترویج مهارت‌های برنامه‌ریزی، مدیریت زمان و مسئولیت‌پذیری در کودکان، بستری آموزشی و انگیزشی فراهم کرده تا والدین و معلمان بتوانند رشد و یادگیری کودکان را به شکل هدفمند و مؤثر همراهی کنند.
        </p>
      </div>

   <!-- ستون: بخش‌های سایت -->
<div class="order-3 md:order-2 flex-1 min-w-[150px] flex flex-col items-center text-center md:text-right">
  <h3 class="text-xl font-bold mb-4">بخش‌های سایت</h3>
  <ul class="space-y-2 text-sm">
    <li>
      <a href="<?php echo site_url('/about'); ?>" class="hover:text-[#8B5E3C] transition">درباره ما</a>
    </li>
    <li>
      <a href="<?php echo site_url('/contact'); ?>" class="hover:text-[#8B5E3C] transition">ارتباط با ما</a>
    </li>
    <li>
      <a href="<?php echo site_url('/courses'); ?>" class="hover:text-[#8B5E3C] transition">دوره‌ها</a>
    </li>
    <li>
      <a href="<?php echo site_url('/blog'); ?>" class="hover:text-[#8B5E3C] transition">بلاگ</a>
    </li>
    <li>
      <a href="<?php echo site_url('/premium'); ?>" class="hover:text-[#8B5E3C] transition font-semibold">نسخه ویژه</a>
    </li>
  </ul>
</div>


      <!-- ستون: ارتباط با ما -->
      <div class="order-4 md:order-3 flex-1 min-w-[180px] flex flex-col items-center text-center md:text-right">
        <h3 class="text-xl font-bold mb-4">ارتباط با ما</h3>
        
        <!-- ایمیل -->
        <a href="mailto:planova@gmail.com"
           class="inline-flex items-center gap-2 bg-[#f2c57c] text-[#6B4C3B] px-4 py-2 rounded-full shadow-[0_4px_10px_rgba(180,140,100,0.3)] hover:shadow-[0_4px_10px_rgba(180,140,100,0.4)] transition mb-4">
          <i class="fa-solid fa-envelope"></i>
          <span class="font-medium">planova@gmail.com</span>
        </a>

        <!-- شماره تماس -->
        <a href="tel:09120000000"
           class="inline-flex items-center gap-2 bg-[#f2c57c] text-[#6B4C3B] px-4 py-2 rounded-full shadow-[0_4px_10px_rgba(180,140,100,0.3)] hover:shadow-[0_4px_10px_rgba(180,140,100,0.4)] transition mb-6">
          <i class="fa-solid fa-phone"></i>
          <span class="font-medium">09150001122</span>
        </a>

        <!-- شبکه‌های اجتماعی -->
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

    </div>

    <!-- کپی‌رایت -->
    <div class="text-center text-xs text-[#8B5E3C] mt-10 border-t border-[#f2c57c]/30 pt-4">
      © <?php echo date('Y'); ?> پلانووا | همه حقوق محفوظ است.
    </div>

  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
