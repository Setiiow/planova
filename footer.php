<footer class="bg-purple1 border-t-4 border-[#f4c056] text-white rounded-t-4xl">
  <div class="max-w-[1100px] mx-auto flex flex-col md:flex-row justify-between items-start px-4 py-10 gap-6">
    <!-- ستون راست: لوگو + درباره ما --><!-- ستون راست: لوگو + درباره ما -->
<div class="flex-1 flex flex-col md:flex-row items-center md:items-start justify-center md:justify-end gap-4 order-1">

  <!-- لوگو -->
  <div class="flex-shrink-0">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" 
         alt="لوگو" 
         class="h-12 md:h-16 w-auto">
  </div>

  <!-- درباره ما -->
  <div class="text-center md:text-right">
    <h3 class="text-xl font-semibold mb-2">درباره ما</h3>
    <p class="text-gray-200 text-sm leading-6 md:leading-8">
      ما بهترین پلتفرم آموزشی هستیم که در کنار والدین، معلمان و مربیان برای تربیت کودکان و ایجاد الگوی نظم همراه شما هستیم.
    </p>
  </div>

</div>



    <!-- معرفی بخش‌های سایت (وسط) -->
<div class="flex-1 text-center order-2 mx-auto">
  <h3 class="text-xl font-semibold mb-2">بخش‌های سایت</h3>
  <ul class="space-y-5 text-sm">
    <li><a href="<?php echo site_url('/blog'); ?>" class="hover:text-yellow-400 transition">مقالات</a></li>
    <li><a href="<?php echo site_url('/courses'); ?>" class="hover:text-yellow-400 transition">دوره‌ها</a></li>
    <li><a href="<?php echo site_url('/about'); ?>" class="hover:text-yellow-400 transition">درباره ما</a></li>
    <li><a href="<?php echo site_url('/contact'); ?>" class="hover:text-yellow-400 transition">تماس با ما</a></li>
  </ul>
</div>


<!-- ارتباط با ما (چپ) -->
<div class="flex-1 text-center md:text-right order-3">
  <h3 class="text-xl font-semibold mb-4">ارتباط با ما</h3>
  <ul class="space-y-5 text-sm">

    <!-- ایمیل -->
    <li class="flex items-center gap-2 justify-start">
      <i class="fa-solid fa-envelope text-yellow-400 text-lg"></i>
      <span class="font-semibold">ایمیل:</span>
      <a href="mailto:planova@gmail.com" class="hover:text-yellow-400 transition">
        planova@gmail.com
      </a>
    </li>

    <!-- تلفن -->
    <li class="flex items-center gap-2 justify-start">
      <i class="fa-solid fa-phone text-yellow-400 text-lg"></i>
      <span class="font-semibold">تلفن:</span>
      <a href="tel:+98037317070" class="hover:text-yellow-400 transition">
        037317070
      </a>
    </li>

    <!-- آدرس -->
    <li class="flex items-center gap-2 justify-start">
      <i class="fa-solid fa-location-dot text-yellow-400 text-lg"></i>
      <span class="font-semibold">آدرس:</span>
      <span>مشهد _ خیابان شهید مطهری _ مطهری 36</span>
    </li>

    <!-- شبکه‌های اجتماعی -->
    <li class="flex items-center gap-3 justify-start">
      <i class="fa-solid fa-share-nodes text-yellow-400 text-lg"></i>
      <span class="font-semibold">شبکه‌های اجتماعی:</span>
      <div class="flex gap-3 text-lg">
        <a href="https://t.me/example" target="_blank" class="hover:text-yellow-400 transition"><i class="fa-brands fa-telegram"></i></a>
        <a href="https://instagram.com/example" target="_blank" class="hover:text-yellow-400 transition"><i class="fa-brands fa-instagram"></i></a>
      </div>
    </li>

  </ul>
</div>


  </div>

  <!-- کپی‌رایت پایین -->
  <div class="border-t border-yellow-400 mt-6 pt-4 text-center text-gray-300 text-sm">
    © <?php echo date('Y'); ?> کلیه حقوق این سایت محفوظ است.
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
