<?php
/*
Template Name: Premium Page
*/
get_header();
?>

<main class="font-sans text-gray-800">

    <!-- بخش اول صفحه(مقدمه) -->
    <section class="bg-gradient-to-b from-[#fadfbb] to-[#f2c57c] text-white py-20 text-center rounded-b-4xl shadow-lg">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">نسخه پریمیوم؛ یک گام جلوتر</h1>
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
            <h2 class="text-3xl md:text-4xl font-extrabold mb-12">پلن‌های نسخه پریمیوم</h2>
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
                <div class="bg-[#6B4C3B] text-white rounded-2xl shadow-xl p-10 transform scale-105">
                    <h3 class="text-xl font-bold mb-4">سه ماهه</h3>
                    <p class="text-4xl font-extrabold mb-6">۲۴۹,۰۰۰ تومان</p>
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
                    <p class="text-4xl font-extrabold text-[#6B4C3B] mb-6">۷۹۹,۰۰۰ تومان</p>
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
        <h2 class="text-2xl md:text-3xl font-extrabold text-center mb-10 text-[#6B4C3B]">
            تفاوت نسخه رایگان و پریمیوم
        </h2>

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
                        <td class="py-4 px-3 text-right font-medium">امکان چند گروه و اعضای بیشتر</td>
                        <td class="text-red-500 font-bold">✖</td>
                        <td class="text-green-600 font-bold">✔</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- CTA پایانی -->
    <section class="text-center py-20 bg-gradient-to-b from-[#f2c57c] to-[#fadfbb] text-[#6B4C3B] rounded-t-4xl shadow-inner">
        <h2 class="text-3xl md:text-4xl font-extrabold mb-6">همین امروز به پریمیوم بپیوندید</h2>
        <p class="text-lg mb-6">با امکانات کامل و پشتیبانی اختصاصی، بهترین تجربه را برای خود و کودکانتان بسازید.</p>
        <a href="#buy" class="inline-block bg-[#6B4C3B] text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-[#8B5E3C] transition transform hover:scale-105 shadow-lg">
            ارتقا به پریمیوم
        </a>
    </section>

</main>

<?php get_footer(); ?>