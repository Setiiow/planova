<?php
/*
Template Name: Group Setting
*/
get_header(); // شروع قالب و وارد کردن هدر سایت

// اگه کاربر وارد نشده باشه، پیغام میدیم و صفحه رو متوقف می‌کنیم
if ( ! is_user_logged_in() ) {
    echo '<p>لطفاً ابتدا وارد شوید.</p>';
    get_footer();
    exit;
}

// گرفتن اطلاعات کاربر فعلی
$user = wp_get_current_user();
$user_id = $user->ID;

// بررسی نقش کاربر: فقط والدین و معلم‌ها اجازه دارن این صفحه رو ببینن
if ( ! array_intersect(['parent','teacher'], (array) $user->roles) ) {
    echo '<p>شما اجازه دسترسی به این بخش را ندارید.</p>';
    get_footer();
    exit;
}

// گرفتن اطلاعات قبلی گروه از متای کاربر
$group_data = get_user_meta($user_id, '_group_info', true);
if ( ! is_array($group_data) ) {
    // اگه چیزی پیدا نشد، یه آرایه خالی می‌سازیم تا فرم خالی باشه
    $group_data = [
        'name'     => '',
        'password' => '',
        'image'    => '',
    ];
}

// نام فعلی سرگروه از پروفایل کاربر
$leader_name = $user->display_name;

// مسیر عکس پیشفرض گروه (اگه تصویری انتخاب نشده باشه)
$default_img = get_template_directory_uri() . '/assets/images/default-group.png';

// بررسی اگه فرم ارسال شده باشه
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // اگه دکمه حذف عکس زده شده باشه
    if (isset($_POST['remove_group_image'])) {
        $group_data['image'] = $default_img; // برمی‌گردونیم به عکس پیشفرض
        update_user_meta($user_id, '_group_info', $group_data); // ذخیره در دیتابیس
        echo '<p class="text-green-600">عکس حذف شد و به حالت پیشفرض برگشت ✅</p>';
    }

    // اگه دکمه ذخیره تغییرات زده شده باشه
    if (isset($_POST['update_group'])) {
        // گرفتن داده‌ها از فرم و تمیز کردنشون
        $group_data['name']     = sanitize_text_field($_POST['group_name']);
        $group_data['password'] = sanitize_text_field($_POST['group_password']);

        // اگه کاربر یه عکس جدید انتخاب کرده باشه
        if (!empty($_FILES['group_image']['name'])) {
            $uploaded = wp_handle_upload($_FILES['group_image'], ['test_form' => false]);
            if (!isset($uploaded['error'])) {
                $group_data['image'] = $uploaded['url']; // مسیر عکس جدید
            }
        }

        // ذخیره اطلاعات گروه در دیتابیس
        update_user_meta($user_id, '_group_info', $group_data);

        // بروزرسانی نام سرگروه در پروفایل کاربر
        if (isset($_POST['leader_name']) && !empty($_POST['leader_name'])) {
            wp_update_user([
                'ID'           => $user_id,
                'display_name' => sanitize_text_field($_POST['leader_name']),
            ]);
        }

        // پیام موفقیت
        echo '<p class="text-green-600">تنظیمات با موفقیت ذخیره شد ✅</p>';
        $leader_name = get_the_author_meta('display_name', $user_id);
    }
}
?>

<main class="relative w-full min-h-screen overflow-x-hidden">
    <!-- relative → برای موقعیت‌دهی داخلی
         w-full → عرض کامل صفحه
         min-h-screen → حداقل ارتفاع برابر با ارتفاع صفحه
         overflow-x-hidden → جلوگیری از اسکرول افقی -->

    <div class="max-w-2xl mx-auto px-4 py-12">
        <!-- max-w-2xl → حداکثر عرض کانتینر
             mx-auto → مرکز کردن افقی
             px-4 → padding افقی
             py-12 → padding عمودی -->

        <div class="bg-[#fdfaf6] border-4 border-[#f2c57c]/40 rounded-2xl p-8 shadow-2xl">
            <!-- bg-[#fdfaf6] → پس‌زمینه کرمی
                 border-4 border-[#f2c57c]/40 → حاشیه زرد ملایم با شفافیت 40٪
                 rounded-2xl → گوشه‌های گرد
                 p-8 → padding داخلی
                 shadow-2xl → سایه قوی برای جلوه سه‌بعدی -->

            <header class="mb-6 text-center">
                <!-- mb-6 → margin-bottom
                     text-center → متن وسط‌چین -->
                <h1 class="text-3xl md:text-4xl font-extrabold text-[#6B4C3B] inline-flex items-center justify-center gap-3">
                    <!-- text-3xl → اندازه فونت بزرگ
                         md:text-4xl → برای صفحات متوسط به بالا فونت بزرگ‌تر
                         font-extrabold → ضخامت بسیار زیاد
                         text-[#6B4C3B] → رنگ قهوه‌ای
                         inline-flex → برای استفاده از flex داخل متن
                         items-center → وسط چین عمودی آیکون‌ها و متن
                         justify-center → وسط چین افقی
                         gap-3 → فاصله بین آیکون‌ها و متن -->
                    <span class="text-4xl">🌈</span>
                    تنظیمات گروه
                    <span class="text-2xl">✨</span>
                </h1>
            </header>

            <form method="post" enctype="multipart/form-data" class="space-y-6" novalidate>
                <!-- space-y-6 → فاصله عمودی بین عناصر فرم -->

                <!-- نام گروه -->
                <label class="form-label">
                    <span class="inline-flex items-center gap-3">
                        <span class="text-2xl">🏷️</span>
                        <span>نام گروه</span>
                    </span>
                    <input type="text" name="group_name" required
                           value="<?php echo esc_attr($group_data['name']); ?>"
                           class="mt-2 block w-full rounded-xl p-3 border-2 border-[#f2c57c]/50 bg-white 
                                  focus:outline-none focus:ring-2 focus:ring-[#f2c57c]/40 focus:border-[#8B5E3C] 
                                  text-[#6B4C3B] font-medium" />
                    <!-- mt-2 → فاصله از بالا
                         block → نمایش به صورت بلاک
                         w-full → عرض کامل
                         rounded-xl → گوشه‌های گرد
                         p-3 → padding داخلی
                         border-2 → ضخامت حاشیه
                         border-[#f2c57c]/50 → رنگ حاشیه زرد با شفافیت 50٪
                         bg-white → پس‌زمینه سفید
                         focus:outline-none → حذف حاشیه پیش‌فرض هنگام فوکوس
                         focus:ring-2 → حلقه هنگام فوکوس
                         focus:ring-[#f2c57c]/40 → رنگ حلقه زرد با شفافیت 40٪
                         focus:border-[#8B5E3C] → تغییر رنگ حاشیه هنگام فوکوس
                         text-[#6B4C3B] → رنگ متن قهوه‌ای
                         font-medium → ضخامت متوسط متن -->

                </label>

                <!-- رمز گروه (مشابه input نام گروه) -->
                <label class="form-label">
                    <span class="inline-flex items-center gap-3">
                        <span class="text-2xl">🔑</span>
                        <span>رمز گروه</span>
                    </span>
                    <input type="text" name="group_password" required
                           value="<?php echo esc_attr($group_data['password']); ?>"
                           class="mt-2 block w-full rounded-xl p-3 border-2 border-[#f2c57c]/50 bg-white 
                                  focus:outline-none focus:ring-2 focus:ring-[#f2c57c]/40 focus:border-[#8B5E3C] 
                                  text-[#6B4C3B] font-medium" />
                </label>

                <!-- نام سرگروه -->
                <label class="form-label">
                    <span class="inline-flex items-center gap-3">
                        <span class="text-2xl">👩‍🏫</span>
                        <span>نام سرگروه</span>
                    </span>
                    <input type="text" name="leader_name" required
                           value="<?php echo esc_attr($leader_name); ?>"
                           class="mt-2 block w-full rounded-xl p-3 border-2 border-[#f2c57c]/50 bg-white 
                                  focus:outline-none focus:ring-2 focus:ring-[#f2c57c]/40 focus:border-[#8B5E3C] 
                                  text-[#6B4C3B] font-medium" />
                </label>

                <!-- تصویر گروه -->
                <div class="flex flex-col gap-3">
                    <!-- flex → برای چینش افقی یا عمودی
                         flex-col → چینش عمودی
                         gap-3 → فاصله بین عناصر -->
                    <span class="form-label inline-flex items-center gap-3">
                        <span class="text-2xl">🖼️</span>
                        <span>تصویر گروه</span>
                    </span>

                    <?php if (!empty($group_data['image'])): ?>
                        <div class="flex items-center gap-4">
                            <!-- flex → چینش افقی
                                 items-center → وسط چین عمودی
                                 gap-4 → فاصله بین تصویر و متن -->
                            <img src="<?php echo esc_url($group_data['image']); ?>" alt="Group Image"
                                 class="w-24 h-24 rounded-full object-cover border-4 border-[#f2c57c]/70 shadow-lg">
                            <!-- w-24 h-24 → اندازه تصویر
                                 rounded-full → گرد کامل
                                 object-cover → تصویر بدون کشیدگی
                                 border-4 → ضخامت حاشیه
                                 border-[#f2c57c]/70 → رنگ حاشیه زرد با شفافیت
                                 shadow-lg → سایه قوی -->

                            <div class="flex-1">
                                <p class="text-[#6B4C3B] font-medium">تصویر فعلی</p>
                                <p class="text-sm text-[#6B4C3B]/60">اگر می‌خواهی آن را تغییر دهی، فایل جدید انتخاب کن.</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <input type="file" name="group_image"
                           class="mt-2 block w-full rounded-xl p-3 border-2 border-dashed border-[#f2c57c]/70 
                                  bg-[#fff8f0] text-[#6B4C3B] cursor-pointer" />
                </div>

                <!-- دکمه حذف عکس -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" name="remove_group_image"
                            class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl 
                                   bg-red-500 text-white w-full sm:w-auto hover:bg-red-600 transition">
                        حذف عکس
                    </button>
                </div>

                <!-- دکمه‌های پایانی -->
                <div class="flex gap-4 flex-col sm:flex-row">
                    <!-- ذخیره تغییرات -->
                    <button type="submit" name="update_group"
                            class="px-6 py-3 rounded-xl font-bold text-[#6B4C3B] bg-[#f2c57c] 
                                   hover:bg-[#8B5E3C] hover:text-white transition duration-200 ease-in-out flex-1">
                        💾 ذخیره تغییرات
                    </button>

                    <!-- بازگشت به داشبورد -->
                    <a href="<?php echo home_url('/dashboard'); ?>"
                       class="px-6 py-3 rounded-xl font-bold text-[#6B4C3B] bg-[#f2c57c] 
                              hover:bg-[#8B5E3C] hover:text-white transition duration-200 ease-in-out flex-1 text-center">
                         بازگشت به داشبورد
                    </a>
                </div>

            </form>
        </div>
    </div>
</main>


<?php get_footer(); // پایان قالب و وارد کردن فوتر سایت ?>
