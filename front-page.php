<?php
get_header();
?>
<section class="px-4 sm:px-8 md:px-16 lg:px-10">
    <div class="flex flex-col md:flex-row items-center md:items-start mb-8">


        <!-- متن + عکس -->
        <div class="relative mt-8 md:mr-6 lg:mr-10 md:mt-5 lg:mt-12 mx-4 sm:mx-10 md:mx-20 text-[#6B4C3B] text-right">
            <div class="relative inline-block">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-[50px] font-semibold ">پلانووا؛</h1>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/check.png"
                    alt="task-checkbox"
                    class="absolute -top-2 -left-9 w-7 h-7 sm:w-9 sm:h-9 md:w-10 md:h-9 
                    animate-pulse -rotate-12">
            </div>


            <h2 class="text-lg sm:text-lg md:text-xl lg:text-2xl font-medium mb-4 mt-2">
                تجربه آموزشی و انگیزشی برای کودکان در برنامه‌ریزی و مسئولیت‌پذیری
            </h2>

            <p class="text-base sm:text-base lg:text-lg leading-relaxed">
                با برنامه‌ریزی وظایف، پیگیری پیشرفت و جمع‌آوری امتیازها، فرصتی را
                <br class="hidden sm:block">
                فراهم کردیم که کودکان و دانش آموزان از همان سنین کم برنامه‌ریزی،
                <br class="hidden sm:block">
                مدیریت زمان و مسئولیت‌پذیری را یاد گرفته و با انگیزه و تمرکز رشد کنند.
            </p>

            <span>
                <a href="<?php echo esc_url(home_url('/register')); ?>"
                    class="font-semibold bg-[#f2c57c]/50 text-[#6B4C3B] px-3 py-1.5 text-sm sm:px-3.5 sm:py-2 
                sm:text-base md:px-1 md:mt-1 md:py-2 md:text-base lg:px-4 lg:py-2 lg:my-4 lg:text-lg mt-4 rounded-lg 
                shadow-md hover:bg-[#f2c57c] hover:text-[#8B5E3C] hover:shadow-lg transition inline-block">
                    همین حالا شروع کنید!
                </a>
            </span>

        </div>

        <!-- باکس تصویر -->
        <div class="relative w-[90%] lg:mx-1 sm:w-[80%] md:w-90 h-[250px] sm:h-[320px] md:h-[330px] 
        md:w-[600px] mt-6 sm:mt-8 md:mt-7 ml-0 md:ml-10 lg:ml-20 shadow-2xl"
            style="border-radius: 60% 30% 70% 20% / 40% 80% 20% 60%; background-color:#f2c57c;">

            <!-- عکس روی پس زمینه -->
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/image.png"
                alt="planning-for-kids"
                class="absolute lg:h-68 lg:w-70 top-[14px] sm:top-8 md:top-10 left-1/2 transform -translate-x-1/2
            w-[190px] h-[210px] sm:w-[220px] sm:h-[240px] md:w-60 md:h-60">

            <!-- متن روی عکس در گوشه بالا-چپ -->
            <div class="absolute top-3 md:top-6 left-2 bg-[#6B4C3B] text-white -rotate-12 rounded-md text-center 
            px-3 sm:px-4 py-1 text-[13px] sm:text-[18px]  md:text-base whitespace-nowrap">
                با انگیزه پیش برو! 🚀
            </div>
        </div>

    </div>
</section>
<section class="px-4 sm:px-8 md:px-16 lg:px-24 py-12 bg-[#fdfaf6] text-[#6B4C3B]">

    <!-- تیتر اصلی -->
    <div class="text-center mb-10">
        <h2 class="text-3xl sm:text-4xl md:text-4xl font-bold mb-4">چرا ما؟</h2>

        <!-- خط منحنی -->
        <svg class="mx-auto -mt-5 w-24 h-6" viewBox="0 0 100 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 10 C 25 0, 75 20, 100 10" stroke="#f2c57c" stroke-width="3" fill="transparent" />
        </svg>

        <p class="text-base sm:text-lg md:text-xl mt-3 text-[#8B5E3C]">
            یادگیری مهارت‌های برنامه‌ریزی و مدیریت زمان به شیوه‌ای جذاب و کاربردی
        </p>
    </div>

    <!-- کارت‌ها -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

        <!-- کارت ۱ -->
        <div class="bg-[#f2c57c]/30 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
            <h3 class="text-xl font-semibold mb-3">سرگرم‌کننده و آموزنده</h3>
            <p class="text-sm sm:text-base leading-relaxed">
                تجربه‌ای تعاملی برای یادگیری برنامه‌ریزی و مسئولیت‌پذیری.
            </p>
        </div>

        <!-- کارت ۲ -->
        <div class="bg-[#f2c57c]/30 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
            <h3 class="text-xl font-semibold mb-3">تقویت مهارت‌های زندگی</h3>
            <p class="text-sm sm:text-base leading-relaxed">
                تقویت و پیشرفت مرحله به مرحله مهارت های مدیریت زمان
            </p>
        </div>

        <!-- کارت ۳ -->
        <div class="bg-[#f2c57c]/30 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
            <h3 class="text-xl font-semibold mb-3">همراهی خانواده و مدارس</h3>
            <p class="text-sm sm:text-base leading-relaxed">
                امکان تعریف وظایف و پیگیری پیشرفت بچه‌ها.
            </p>
        </div>

        <!-- کارت ۴ -->
        <div class="bg-[#f2c57c]/30 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
            <h3 class="text-xl font-semibold mb-3">الهام‌بخش و انگیزشی</h3>
            <p class="text-sm sm:text-base leading-relaxed">
                ایجاد اشتیاق با سیستم تعاملی و پاداش‌دهی.
            </p>
        </div>

    </div>
</section>




<?php
get_footer();
?>