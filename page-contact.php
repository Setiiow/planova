<?php
/*
Template Name: Contact Page
*/
get_header();
?>

<main class="container mx-auto px-4 sm:px-6 lg:px-20 py-10">

  <!-- عنوان صفحه -->
  <div class="text-center mb-8">
    <h1 class="text-4xl sm:text-5xl font-extrabold text-[#6B4C3B] relative inline-block">
      <?php the_title(); ?>
      <!-- خط طلایی زیر عنوان -->
      <span class="block w-20 h-1 bg-[#f2c57c] mx-auto mt-2 rounded-full"></span>
    </h1>
    <p class="text-[#8B5E3C] mt-2 text-base sm:text-lg">
      ارتباط با ما و ارسال پیام برای پلانووا
    </p>
  </div>

  <form class="wpcf7-form rounded-xl overflow-hidden relative">

    <div class="flex flex-wrap">

      <!-- بخش اول: فرم اصلی -->
      <div class="w-full md:w-2/4 p-4">
        <input type="text" name="your-name" placeholder="نام شما" required>
        <input type="email" name="your-email" placeholder="ایمیل شما" required>
        <textarea name="your-message" placeholder="پیام شما" rows="4" required></textarea>
        <input type="submit" value="ارسال">

        <!-- نسخه موبایل: متن تماس زیر فرم -->
        <div class="block md:hidden mt-4 bg-[#e5cfa3]/40 text-center rounded-xl p-4 shadow-lg">
          <ul class="space-y-5 text-md text-[#6B4C3B]">
            <li class="flex items-center gap-2 justify-start">
              <i class="fa-solid fa-envelope text-[#f2c57c] text-lg"></i>
              <span class="font-semibold">ایمیل:</span>
              <a href="mailto:planova@gmail.com" class="transition">planova@gmail.com</a>
            </li>
            <li class="flex items-center gap-2 justify-start">
              <i class="fa-solid fa-phone text-[#f2c57c] text-lg"></i>
              <span class="font-semibold">تلفن:</span>
              <a href="tel:+98037317070" class="transition">09150001122</a>
            </li>
          </ul>
        </div>
      </div>

      <!-- بخش سوم: بی‌رنگ، حذف در موبایل -->
      <div class="hidden md:block w-full md:w-1/4 p-0 bg-transparent">
      </div>

      <!-- بخش چهارم: کل قهوه‌ای، حذف در موبایل -->
      <div class="hidden md:flex w-full md:w-1/4 p-0 -my-7.5 bg-[#f2c57c] flex justify-center items-center relative overflow-visible">
        <!-- مستطیل وسط با متن و عکس -->
        <div class="min-w-[210%] h-70 bg-[#FFDDC7] rounded-r-4xl py-4 flex justify-center border-r-2 border-[#f2c57c] items-center absolute left-5/6 -translate-x-1/2 shadow-lg">
          <div class="absolute inset-0 flex justify-center items-center">
            <ul class="space-y-5 mb-22 text-md text-[#6B4C3B]">
              <li class="flex items-center gap-2 justify-start">
                <i class="fa-solid fa-envelope text-[#f2c57c] text-lg"></i>
                <span class="font-semibold">ایمیل:</span>
                <a href="mailto:planova@gmail.com" class="transition">planova@gmail.com</a>
              </li>
              <li class="flex items-center gap-2 justify-start">
                <i class="fa-solid fa-phone text-[#f2c57c] text-lg"></i>
                <span class="font-semibold">تلفن:</span>
                <a href="tel:+98037317070" class="transition">09150001122</a>
              </li>
            </ul>
          </div>
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/background.jpeg"
            alt="contact" class="w-full h-auto -mb-35 rounded-r-4xl">
        </div>
      </div>

    </div>

  </form>
</main>

<?php get_footer(); ?>