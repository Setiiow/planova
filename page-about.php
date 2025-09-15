<?php
/*
Template Name: About Page
*/
get_header();
?>
<!-- بخش درباره ما -->
<section class="mt-12 px-4 sm:px-6 lg:px-20">
    <div class="grid grid-cols-1 md:grid-cols-8 gap-6 items-center">

        <!-- ستون راست -->
        <div class="hidden md:flex lg:ml-15 md:-mr-30 relative">
            <!-- نیم‌دایره  -->
            <div class="w-50 h-47 bg-[#f2c57c] rounded-l-full relative"></div>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/planner.png"
                alt="planner"
                class="absolute top-1/2 -translate-y-1/2 -left-3 w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-26 shadow-lg ">
        </div>


        <!-- ستون وسط -->
        <div class="col-span-1 md:col-span-6 text-center flex flex-col items-center gap-6">

            <p class="text-[#8B5E3C] text-base sm:text-lg md:text-2xl leading-relaxed">
                درباره ما
            </p>

            <div class="fancy-lines flex flex-col sm:flex-row items-center justify-center gap-4">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-[#6B4C3B]">
                    گامی به سوی فردایی بهتر
                </h2>

            </div>

            <p class="text-[#6B4C3B]/80 text-base sm:text-base md:text-lg leading-relaxed">
                شعاری که نشان‌دهنده تعهد ما به پرورش نسلی خلاق و توانمند است؛ کودکانی که با مهارت‌های برنامه‌ریزی، مسئولیت‌پذیری، تفکر تحلیلی و حل مسئله مجهز شده‌اند و آماده‌اند با اعتماد به نفس و نوآوری، چالش‌های فردای خود را در مسیر رشد و یادگیری مدیریت کنند.
            </p>
        </div>

        <!-- ستون چپ -->
        <div class="hidden md:flex lg:mr-35 md:mr-20 flex-col items-center gap-6">
            <!-- نیم‌دایره بالا -->
            <div class="w-30 h-20 bg-[#f2c57c] rounded-r-full"></div>
            <!-- نیم‌دایره پایین -->
            <div class="w-30 h-20 bg-[#6B4C3B] rounded-r-full"></div>
        </div>

    </div>
</section>
<!-- بخش اهداف ما -->
<section class="mt-20 px-4 sm:px-6 lg:px-20">
    <div class="text-center mb-10">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-[#6B4C3B]">
            ارزش های ما
        </h2>
        <p class="text-[#8B5E3C] mt-3 text-base sm:text-base">
            آنچه ما برای رشد و موفقیت فرزندان شما دنبال می‌کنیم
        </p>
    </div>

    <!-- کارت‌ها -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- کارت ۱ -->
        <div class="bg-white/80 shadow-xl rounded-2xl p-6 flex flex-col items-center text-center hover:-translate-y-2 hover:shadow-2xl transition duration-300">
            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-[#f2c57c]/80 mb-4 shadow-md">
                <!-- آیکون تقویم -->
                <svg class="w-8 h-8 text-[#6B4C3B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-12 8h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-[#6B4C3B] mb-2">یادگیری مهارت‌ها</h3>
            <p class="text-base text-[#6B4C3B]/80">
                برنامه‌ریزی، مدیریت زمان و مسئولیت‌پذیری برای رشد فردی و موفقیت آینده
            </p>
        </div>

        <!-- کارت ۲ -->
        <div class="bg-white/80 shadow-xl rounded-2xl p-6 flex flex-col items-center text-center hover:-translate-y-2 hover:shadow-2xl transition duration-300">
            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-[#f2c57c]/80 mb-4 shadow-md">
                <!-- آیکون ستاره -->
                <svg class="w-8 h-8 text-[#6B4C3B]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 .587l3.668 7.429L24 9.753l-6 5.853L19.336 24 12 19.897 4.664 24 6 15.606 0 9.753l8.332-1.737z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-[#6B4C3B] mb-2">انگیزه و نظم</h3>
            <p class="text-base text-[#6B4C3B]/80">
                ایجاد انگیزه با امتیازدهی و پیگیری پیشرفت کودکان
            </p>
        </div>

        <!-- کارت ۳ -->
        <div class="bg-white/80 shadow-xl rounded-2xl p-6 flex flex-col items-center text-center hover:-translate-y-2 hover:shadow-2xl transition duration-300">
            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-[#f2c57c]/80 mb-4 shadow-md">
                <!-- آیکون چک‌ لیست -->
                <svg class="w-8 h-8 text-[#6B4C3B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 11l3 3L22 4M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-[#6B4C3B] mb-2">ابزار ساده</h3>
            <p class="text-base text-[#6B4C3B]/80">
                کمک به والدین و معلمان برای مدیریت بهتر وظایف و تکالیف
            </p>
        </div>

        <!-- کارت ۴ -->
        <div class="bg-white/80 shadow-xl rounded-2xl p-6 flex flex-col items-center text-center hover:-translate-y-2 hover:shadow-2xl transition duration-300">
            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-[#f2c57c]/80 mb-4 shadow-md">
                <!-- آیکون ویدیو -->
                <svg class="w-8 h-8 text-[#6B4C3B]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M4 6h8a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-[#6B4C3B] mb-2">یادگیری کاربردی</h3>
            <p class="text-base text-[#6B4C3B]/80">
                دسترسی به ویدیوها و مقالات آموزشی برای تقویت یادگیری
            </p>
        </div>

    </div>
</section>
<!-- بخش اهداف سایت -->
<section class="mt-16 px-4 sm:px-6 lg:px-20">
    <div class="flex flex-col lg:flex-row items-center gap-8">

        <!-- لیست اهداف-->
        <div class="lg:w-2/3 flex flex-col gap-4">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#6B4C3B] mb-4">اهداف ما</h2>

            <!--  خط منحنی زیر متن-->
            <svg class="-mt-8 w-35 h-6" viewBox="0 0 100 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 10 C 25 0, 75 20, 100 10" stroke="#f2c57c" stroke-width="3" fill="transparent" />
            </svg>

            <ul class="list-disc list-inside space-y-2 text-[#6B4C3B]/90 text-base sm:text-lg">
                <li>پرورش کودکان با مهارت‌های برنامه‌ریزی و مدیریت زمان از سنین کم</li>
                <li>ایجاد نسلی مسئول و خودانگیخته که بتواند مستقل تصمیم بگیرد</li>
                <li>فراهم کردن ابزاری هوشمند برای والدین و معلمان جهت حمایت از رشد کودکان</li>
                <li>تقویت تفکر خلاق و حل مسئله در کودکان از طریق محتوای آموزشی</li>
                <li>گسترش فرصت‌های یادگیری جذاب و مؤثر که کودک را برای آینده آماده کند</li>
            </ul>
        </div>

        <!-- بخش چپ (تصویر)-->
        <div class="w-full lg:w-1/3 flex justify-center lg:justify-end mt-6 lg:mt-0">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/success.png"
                alt="goals"
                class="w-2/4 sm:w-1/4 md:w-1/4 lg:w-full h-auto">
        </div>

    </div>
</section>
<!-- بخش همکاری با ما -->
<section class="mt-16 mb-5 px-4 sm:px-6 lg:px-20">
    <div class="text-center mb-10">
        <h2 class="text-4xl sm:text-5xl font-extrabold text-[#6B4C3B] relative inline-block">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#6B4C3B]">همکاری با ما</h2>
            <!-- خط طلایی زیر عنوان -->
            <span class="block w-20 h-1 bg-[#f2c57c] mx-auto mt-2 rounded-full"></span>
        </h2>
        <p class="text-[#8B4C3B] mt-2 text-sm sm:text-base">همراهی در مسیر رشد و موفقیت</p>
    </div>

    <!-- کارت‌ ها و عکس -->
    <div class="flex flex-wrap justify-center items-center gap-4">

        <!-- کارت ۱: مدرسه -->
        <div class="bg-white/70 shadow-lg rounded-2xl flex flex-col items-center text-center px-4 py-3 min-w-[160px] sm:min-w-[180px] md:min-w-[200px] hover:shadow-2xl transition flex-1">
            <div class="text-3xl sm:text-4xl font-bold text-[#6B4C3B] flex items-center justify-center mb-1">
                30+
            </div>
            <h3 class="font-semibold text-sm sm:text-base text-[#6B4C3B] mb-1">مدرسه</h3>
            <p class="text-xs sm:text-sm text-[#6B4C3B]/80">پرورش استعدادهای آینده</p>
        </div>

        <!-- عکس بین کارت‌ها (مخفی در موبایل) -->
        <div class="hidden sm:flex items-center justify-center w-20 md:w-28">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Collaboration.png"
                alt="Collaboration" class="w-full h-auto">
        </div>

        <!-- کارت ۲: مشاور -->
        <div class="bg-white/70 shadow-lg rounded-2xl flex flex-col items-center text-center px-4 py-3 min-w-[160px] sm:min-w-[180px] md:min-w-[200px] hover:shadow-2xl transition flex-1">
            <div class="text-3xl sm:text-4xl font-bold text-[#6B4C3B] flex items-center justify-center mb-1">
                10+
            </div>
            <h3 class="font-semibold text-sm sm:text-base text-[#6B4C3B] mb-1">مشاور</h3>
            <p class="text-xs sm:text-sm text-[#6B4C3B]/80">راهنمایی از قدم صفر</p>
        </div>

    </div>
</section>

<?php get_footer(); ?>