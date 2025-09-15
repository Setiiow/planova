<?php
/*
Template Name: Premium Page
*/
get_header();
?>

<main class="text-gray-800">

    <!-- بخش اول صفحه(مقدمه) -->
    <section class="bg-gradient-to-b from-[#fadfbb] to-[#f2c57c] text-white py-18 text-center rounded-b-4xl shadow-lg">
        <div class="inline-flex items-center justify-center relative">
            <h1 class="text-[25px] md:text-5xl mb-6 font-extrabold text-[#6B4C3B]">
                نسخه پریمیوم؛ یک گام جلوتر
            </h1>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/premium.png"
                alt="premium-icon"
                class="mb-8 -mr-3 md:mr-0 w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 -rotate-12">
        </div>
        <p class="text-lg md:text-xl font-medium mx-2">ابزارهای پیشرفته، پشتیبانی اختصاصی و تجربه‌ای کامل برای والدین، معلمان و کودکان</p>
        <a href="#plans" class="mt-8 inline-block bg-[#6B4C3B] text-white px-6 py-3 rounded-full text-lg font-bold hover:bg-[#8B5E3C] transition transform hover:scale-105 shadow-xl">
            مشاهده پلن‌ها
        </a>
    </section>

    <!-- مزایا -->
    <section class="max-w-6xl mx-auto py-16 px-6 grid md:grid-cols-3 gap-8 text-center">
        <div class="bg-white rounded-2xl p-8 shadow-md hover:shadow-xl transition">
            <i class="fa-solid fa-chart-line text-[#f2c57c] text-4xl mb-4"></i>
            <h3 class="text-xl font-bold mb-2">گزارش کامل پیشرفت</h3>
            <p>دریافت نمودارها و آمار دقیق از عملکرد، نقاط قوت و مسیر رشد هر کودک.</p>
        </div>
        <div class="bg-white rounded-2xl p-8 shadow-md hover:shadow-xl transition">
            <i class="fa-solid fa-sliders text-[#f2c57c] text-4xl mb-4"></i>
            <h3 class="text-xl font-bold mb-2">شخصی‌سازی داشبورد</h3>
            <p>انتخاب تم، رنگ‌ها و چینش دلخواه برای جذاب‌تر شدن تجربه کاربری.</p>
        </div>
        <div class="bg-white rounded-2xl p-8 shadow-md hover:shadow-xl transition">
            <i class="fa-solid fa-bell text-[#f2c57c] text-4xl mb-4"></i>
            <h3 class="text-xl font-bold mb-2">اعلان و یادآوری هوشمند</h3>
            <p>یادآوری خودکار وظایف و زمان‌بندی هوشمند برای مدیریت بهتر زمان.</p>
        </div>
    </section>

    <!-- پلن‌های پریمیوم -->
    <section id="plans" class="bg-[#fdf7f0] py-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#6B4C3B] relative inline-block mb-12">
                پلن‌های نسخه پریمیوم
                <!-- خط طلایی زیر عنوان -->
                <span class="block w-20 h-1 bg-[#f2c57c] mx-auto mt-2 rounded-full"></span>
            </h2>

            <div class="grid md:grid-cols-3 gap-8">

                <!-- پلن 1 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition">
                    <h3 class="text-xl font-bold mb-4">یک ماهه</h3>
                    <p class="text-4xl font-extrabold text-[#6B4C3B] mb-6">۹۹,۰۰۰ تومان</p>
                    <ul class="space-y-3 text-gray-700 mb-6">
                        <li>✔ گزارش کامل پیشرفت کودک</li>
                        <li>✔ شخصی‌سازی داشبورد</li>
                        <li>✔ اعلان و یادآوری هوشمند</li>
                        <li>✔ بدون تبلیغات</li>
                        <li>✔ دسترسی به مشاوران متخصص</li>
                    </ul>
                    <a href="#buy" class="block bg-[#f2c57c] text-[#6B4C3B] py-3 rounded-full font-bold hover:bg-[#e5cfa3] transition">خرید</a>
                </div>

                <!-- پلن 2 -->
                <div class="bg-[#8B5E3C]/90 text-white rounded-2xl shadow-xl p-10 transform scale-105">
                    <h3 class="text-xl font-bold mb-4">سه ماهه</h3>
                    <p class="text-4xl font-extrabold mb-6">۲۱۰,۰۰۰ تومان</p>
                    <ul class="space-y-3 mb-6">
                        <li>✔ گزارش کامل پیشرفت کودک</li>
                        <li>✔ شخصی‌سازی داشبورد</li>
                        <li>✔ اعلان و یادآوری هوشمند</li>
                        <li>✔ بدون تبلیغات</li>
                        <li>✔ دسترسی به مشاوران متخصص</li>
                    </ul>
                    <a href="#buy" class="block bg-white text-[#6B4C3B] py-3 rounded-full font-bold hover:bg-gray-100 transition">خرید</a>
                </div>

                <!-- پلن 3 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition">
                    <h3 class="text-xl font-bold mb-4">یک ساله</h3>
                    <p class="text-4xl font-extrabold text-[#6B4C3B] mb-6">۶۵۰,۰۰۰ تومان</p>
                    <ul class="space-y-3 text-gray-700 mb-6">
                        <li>✔ گزارش کامل پیشرفت کودک</li>
                        <li>✔ شخصی‌سازی داشبورد</li>
                        <li>✔ اعلان و یادآوری هوشمند</li>
                        <li>✔ بدون تبلیغات</li>
                        <li>✔ دسترسی به مشاوران متخصص</li>
                    </ul>
                    <a href="#buy" class="block bg-[#f2c57c] text-[#6B4C3B] py-3 rounded-full font-bold hover:bg-[#e5cfa3] transition">خرید</a>
                </div>

            </div>
        </div>
    </section>


    <!-- بخش مقایسه -->
    <section class="max-w-5xl mx-auto py-16 px-6">
        <div class="flex justify-center">
            <h2 class="fancy-lines text-2xl md:text-3xl font-extrabold text-center mb-10 text-[#6B4C3B]">
                تفاوت نسخه رایگان و پریمیوم
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full bg-[#fdf7f0] text-center border border-[#f2c57c]/50 rounded-2xl overflow-hidden shadow-md">
                <thead>
                    <tr class="bg-[#f2c57c] text-[#6B4C3B] text-lg">
                        <th class="py-4 px-3 text-right">ویژگی</th>
                        <th class="py-4 px-3">رایگان</th>
                        <th class="py-4 px-3">پریمیوم</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2c57c]/40 text-gray-800">
                    <tr class="hover:bg-[#fdf7f0] transition">
                        <td class="py-4 px-3 text-right font-medium">نمودار پیشرفت کودک</td>
                        <td class="text-red-500 font-bold">✖</td>
                        <td class="text-green-600 font-bold">✔</td>
                    </tr>
                    <tr class="hover:bg-[#fdf7f0] transition">
                        <td class="py-4 px-3 text-right font-medium">شخصی‌سازی داشبورد</td>
                        <td class="text-red-500 font-bold">✖</td>
                        <td class="text-green-600 font-bold">✔</td>
                    </tr>
                    <tr class="hover:bg-[#fdf7f0] transition">
                        <td class="py-4 px-3 text-right font-medium">پشتیبانی اختصاصی</td>
                        <td class="text-red-500 font-bold">✖</td>
                        <td class="text-green-600 font-bold">✔</td>
                    </tr>
                    <tr class="hover:bg-[#fdf7f0] transition">
                        <td class="py-4 px-3 text-right font-medium">امکان ایجاد چند گروه و اعضای بیش از 15 نفر</td>
                        <td class="text-red-500 font-bold">✖</td>
                        <td class="text-green-600 font-bold">✔</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- دعوت به اقدام -->
    <section class="text-center py-12 bg-gradient-to-b from-[#f2c57c] to-[#fadfbb] text-[#6B4C3B] rounded-t-4xl shadow-inner">
        <h2 class="text-3xl md:text-4xl font-extrabold mb-6">همین امروز به پریمیوم بپیوندید</h2>
        <p class="text-lg mb-4 leading-snug">با امکانات کامل و پشتیبانی اختصاصی، بهترین تجربه را برای خود و کودکانتان بسازید.</p>
        <div class="relative inline-block">
            <a href="#buy" class="inline-block relative bg-[#6B4C3B] text-white px-5 py-2 mt-2 rounded-full font-bold text-lg hover:bg-[#8B5E3C] transition transform hover:scale-105 shadow-lg">
                ارتقا به پریمیوم
            </a>
            <!-- تصویر روی دکمه -->
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/premium.png"
                alt="premium-icon"
                class="absolute -top-3 -left-3 w-7 h-7 sm:w-9 sm:h-9 md:w-10 md:h-8 -rotate-12">
        </div>
    </section>


</main>

<?php get_footer(); ?>