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
                تجربه آموزشی و انگیزشی برای کودکان در زمینه برنامه‌ریزی و مسئولیت‌پذیری
            </h2>

            <p class="text-base sm:text-base lg:text-lg leading-relaxed">
                فرصتی را فراهم کردیم تا با برنامه‌ریزی وظایف، پیگیری پیشرفت و جمع‌آوری امتیازها، کودکان و دانش آموزان را از همان
                <br class="hidden sm:block">
                سنین کم با مهارت های برنامه ریزی، مدیریت زمان و مسئولیت‌پذیری
                <br class="hidden sm:block">
                آشنا کنیم و با انگیزه و تمرکز در رشد و پیشرفت فرزندان ایران سهیم باشیم.
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
<section class="px-4 sm:px-8 md:px-16 lg:px-24 pt-30 pb-40 bg-[#fff8f0]">


    <!-- مستطیل بزرگ با گوشه‌های گرد -->
    <div class="relative overflow-visible bg-[#f2c57c] rounded-3xl h-[150px] sm:h-[120px] md:h-[150px] flex items-center justify-center shadow-lg overflow-hidden">

        <!-- نیم دایره بالایی    -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[90%] lg:w-[60%] md:w-[80%] lg:h-12 md:h-12 h-10 bg-[#fdfaf6] rounded-b-full">
            <h2 class="text-xl sm:text-4xl sm:-mt-3 mt-2 md:text-[38px] lg:text-4xl font-bold text-[#6B4C3B] max-w-3xl lg:mx-6 text-center leading-snug whitespace-nowrap">
                ویدیوهای پرورش کودک
            </h2>
        </div>

        <!-- تصاویر -->
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/planning.jpeg"
            alt="ویدیو ۱"
            class="slide absolute -bottom-10 sm:-bottom-20 lg:left-[20%] md:left-[11%] sm:left-[12%] h-30 sm:h-28 w-50 sm:w-48 md:w-60 md:h-40 lg:w-70 lg:h-40 shadow-lg rounded-xl transform hover:scale-105 transition z-20" />

        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/planning.jpeg"
            alt="ویدیو ۲"
            class="slide hidden absolute -bottom-10 sm:-bottom-20 lg:right-[20%] md:right-[11%] sm:right-[12%] h-30 sm:h-28 w-50 sm:w-48 md:w-60 md:h-40 lg:w-70 lg:h-40 shadow-lg rounded-xl transform hover:scale-105 transition z-20" />

        <!-- دکمه‌های ناوبری فقط در موبایل -->
        <button onclick="prevSlide()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-[#6B4C3B] text-white rounded-full p-2 sm:hidden z-30">
            ›
        </button>
        <button onclick="nextSlide()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-[#6B4C3B] text-white rounded-full p-2 sm:hidden z-30">
            ‹
        </button>
    </div>

</section>
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

    <!-- بخش متن -->
    <div class="text-right text-[#6B4C3B]">

        <h2 class="fancy-lines text-3xl sm:text-4xl font-bold mb-4">رازهای کوچولوهای موفق</h2>
        <p class="text-base sm:text-lg leading-relaxed mb-6">
            مقالات ما پر از نکات کاربردی و ساده برای والدین و معلمان است تا بتوانند مهارت‌های برنامه‌ریزی، مسئولیت‌پذیری و رشد کودک را به شکل سرگرم‌کننده و عملی آموزش دهند. با خواندن این مقالات، هر روز می‌توانید قدمی کوچک اما مؤثر در پرورش استعداد و اعتماد به نفس کودکان بردارید.
        </p>
        <a href="<?php echo esc_url(home_url('/blog')); ?>"
            class="font-semibold bg-[#f2c57c]/50 text-[#6B4C3B] px-3 py-1.5 text-lg sm:px-3.5 sm:py-2 
                sm:text-base md:px-1 md:mt-1 md:py-2 md:text-base lg:px-4 lg:py-2 lg:my-4 lg:text-lg mt-4 rounded-lg 
                shadow-md hover:bg-[#f2c57c] hover:text-[#8B5E3C] hover:shadow-lg transition inline-block">
            مشاهده همه
            <!-- فلش سمت راست متن -->
            <span class="text-[#6B4C3B] text-lg font-bold ml-2">&larr;</span>
        </a>
    </div>

    <!-- بخش کارت‌ها -->
    <div>
        <?php echo do_shortcode('[latest_two_posts]'); ?>
    </div>

</section>

<section class="px-4 sm:px-8 md:px-16 lg:px-24 py-16 bg-[#fff8f0] text-[#6B4C3B]">
    <div class="max-w-5xl mx-auto">
        <!-- تیتر -->
        <div class="flex justify-center items-center mb-8 relative">
            <div class="relative">
                <h2 class="half-circle text-3xl sm:text-4xl font-bold text-center">
                    سوالات متداول
                </h2>
                <!-- تصویر نزدیک متن -->
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/lamp.png"
                    alt="lamp"
                    class="absolute -top-2 -right-8 h-10 sm:h-9 md:h-9 animate-pulse -rotate-12">
            </div>
        </div>

        <p class="text-center text-lg sm:text-xl mb-12 text-[#8B5E3C]">
            پاسخ به سوالات پرتکرار شما کاربران درباره استفاده از سایت و امکانات آن </p>
        <!-- آکاردئون FAQ -->
        <div class="space-y-4">

            <!-- سوال 1 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <button class="w-full flex justify-between items-center p-4 font-semibold text-lg hover:bg-[#f2c57c]/20 transition focus:outline-none faq-btn text-right">
                    ویدیوهای آموزشی چه مهارت‌هایی را به کودکان آموزش می‌دهند و چرا برای والدین و معلمان مفید هستند؟
                    <span class="transform transition-transform duration-300">+</span>
                </button>
                <div class="p-4 hidden text-gray-700 text-right">
                    ویدیوهای آموزشی مجموعه‌ای جذاب و کاربردی هستند که به کودکان کمک می‌کنند مهارت‌های برنامه‌ریزی، مدیریت زمان، مسئولیت‌پذیری، تعیین هدف، حل مسئله و تقویت حافظه را به شکل سرگرم‌کننده یاد بگیرند و مهارت‌های زندگی خود را با انگیزه و تمرکز تقویت کنند. برای والدین و معلمان، این ویدیوها ابزار مفیدی برای راهنمایی و همراهی کودکان و هماهنگی بهتر فعالیت‌ها و وظایف روزانه هستند.
                </div>
            </div>


            <!-- سوال 2 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <button class="w-full flex justify-between items-center p-4 text-left font-semibold text-lg hover:bg-[#f2c57c]/20 transition focus:outline-none faq-btn text-right">
                    آیا والدین و معلمان می‌توانند چند کودک را همزمان مدیریت کنند؟
                    <span class="transform transition-transform duration-300">+</span>
                </button>
                <div class="p-4 hidden text-gray-700 text-right">
                    بله، امکان اضافه کردن چند کودک یا دانش‌آموز به داشبورد و مشاهده و ویرایش وظایف و سایر اطلاعات آنها وجود دارد.
                </div>
            </div>

            <!-- سوال 3 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <button class="w-full flex justify-between items-center p-4 text-left font-semibold text-lg hover:bg-[#f2c57c]/20 transition focus:outline-none faq-btn text-right">
                    این سایت برای چه بازه سنی مناسب است و کودکان چگونه می‌توانند به وظایف خود دسترسی داشته باشند؟
                    <span class="transform transition-transform duration-300">+</span>
                </button>
                <div class="p-4 hidden text-gray-700 text-right">
                    این سایت برای کودکان از ۵ سال به بالا طراحی شده و مناسب تمام سنینی است که والدین و معلمان می‌خواهند به فرزندان یا دانش‌آموزانشان در یادگیری برنامه‌ریزی، مدیریت زمان و مسئولیت‌پذیری کمک کنند. کودکان می‌توانند با هر دستگاه یا سیستمی که در اختیار دارند به راحتی به وظایف تعریف‌شده دسترسی پیدا کنند، آنها را تیک زده و پیشرفت خود را ثبت کنند، بدون اینکه امکان تغییر اطلاعات گروه یا دیگر تنظیمات اصلی را داشته باشند. والدین و معلمان هم میتواند روند پیشرفت کودکان را به راحتی نظارت و حمایت کنند.
                </div>
            </div>

            <!-- سوال 4 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <button class="w-full flex justify-between items-center p-4 text-left font-semibold text-lg hover:bg-[#f2c57c]/20 transition focus:outline-none faq-btn text-right">
                    نسخه پریمیوم چه امکاناتی دارد و چطور می‌توانم آن را خریداری کنم؟
                    <span class="transform transition-transform duration-300">+</span>
                </button>
                <div class="p-4 hidden text-gray-700 text-right">
                    با خرید نسخه پریمیوم میتوانید داشبورد کودک را شخصی‌سازی کنید، تم و جزئیات نمایش اطلاعات را تغییر دهید،
                    <br>
                    نمودار پیشرفت کودکان را مشاهده و مهارت‌های برنامه‌ریزی، مدیریت زمان و مسئولیت‌پذیری آنها را دقیق‌تر ارزیابی کنید،
                    <br>
                    اعلان‌ها و یادآوری‌ها را روشن کنید تا هیچ وظیفه‌ای فراموش نشود و به صورت مستقیم با مشاوران تربیتی و روانشناسی کودک
                    <br>
                    در ارتباط باشید و از راهنمایی‌های تخصصی برای رشد و پرورش کودکان استفاده کنید
                </div>
            </div>

            <!-- سوال 5 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <button class="w-full flex justify-between items-center p-4 text-left font-semibold text-lg hover:bg-[#f2c57c]/20 transition focus:outline-none faq-btn text-right">
                    آیا مدارس می‌توانند از سایت برای مدیریت کلاس و ایجاد انگیزه در دانش‌آموزان استفاده کنند؟
                    <span class="transform transition-transform duration-300">+</span>
                </button>
                <div class="p-4 hidden text-gray-700 text-right">
                    بله، مدارس و معلمان می‌توانند وظایف گروهی تعریف کنند و با استفاده از سیستم امتیاز و جایزه، انگیزه و رقابت سالم ایجاد کنند.
                </div>
            </div>

        </div>
    </div>
</section>


<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll(".slide");

    function showSlide(index) {
        slides.forEach((slide, i) => {
            // روی موبایل فقط یکی دیده بشه
            if (window.innerWidth < 640) {
                slide.classList.add("hidden");
                if (i === index) slide.classList.remove("hidden");
            } else {
                // روی دسکتاپ همه مثل قبل نمایش داده بشن
                slide.classList.remove("hidden");
            }
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }

    // نمایش اولیه
    showSlide(currentSlide);

    // بروزرسانی هنگام تغییر اندازه
    window.addEventListener("resize", () => showSlide(currentSlide));

    // جاوااسکریپت آکاردئون
    document.querySelectorAll('.faq-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const content = btn.nextElementSibling;
            const icon = btn.querySelector('span');

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.textContent = '−';
            } else {
                content.classList.add('hidden');
                icon.textContent = '+';
            }
        });
    });
</script>



<?php
get_footer();
?>