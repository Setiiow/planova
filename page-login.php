<?php
/*
Template Name: Login Page
*/
// این بخش مشخص می‌کند که این فایل یک قالب صفحه ورود در وردپرس است

ob_start(); // شروع بافر خروج، برای اینکه بتوانیم قبل از نمایش، هدایت کنیم
get_header(); // بارگذاری هدر سایت

$login_error = ''; // متغیری برای ذخیره پیام خطای ورود

// بررسی می‌کنیم که فرم ارسال شده باشد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wp-submit'])) {
    // اطلاعات کاربر را از فرم می‌گیریم و امنیت آنها را بررسی می‌کنیم
    $creds = [
        'user_login'    => sanitize_user($_POST['log']), // نام کاربری را امن می‌کنیم
        'user_password' => $_POST['pwd'], // رمز عبور را مستقیم می‌گیریم
        'remember'      => true // کاربر را در حالت "مرا به یاد داشته باش" وارد می‌کنیم
    ];

    // تلاش برای ورود کاربر با اطلاعات داده شده
    $user = wp_signon($creds, false);

    // اگر خطا بود، پیام مناسب نشان می‌دهیم
    if (is_wp_error($user)) {
        $login_error = 'نام کاربری یا رمز عبور اشتباه است.';
    } else {
        // بررسی نقش کاربر
        $user_role = $user->roles[0] ?? '';
        if ($user_role === 'parent' || $user_role === 'teacher') {
            wp_redirect(home_url('/dashboard')); // اگر والد یا معلم بود، به داشبورد می‌فرستیم
            exit;
        } else {
            $login_error = 'شما اجازه ورود به این صفحه را ندارید.';
        }
    }
}

// مسیر قالب برای استفاده در تصاویر و فایل‌ها
$theme_uri = get_template_directory_uri();
?>

<!-- بخش اصلی صفحه -->
<main class="min-h-screen flex items-center justify-center bg-[#f2c57c] px-6 mt-16 mb-16 md:mt-5 md:mb-5">
    <div class="flex flex-col md:flex-row w-full max-w-6xl bg-white rounded-2xl overflow-hidden shadow-[0_10px_25px_rgba(92,58,33,0.5)]">

        <!-- فرم ورود -->
        <div class="w-full md:w-1/2 flex-1 p-6 md:p-10 flex flex-col justify-center border-b md:border-b-0 md:border-r border-gray-200">
            <h2 class="text-2xl font-bold text-[#6B4C3B] text-center mb-6">👩‍🏫 ورود سرگروه</h2>
            <!-- نمایش پیام خطا اگر وجود داشت -->
            <?php if (!empty($login_error)) : ?>
                <p class="text-red-500 text-center mb-4 font-bold"><?php echo esc_html($login_error); ?></p>
            <?php endif; ?>
            <!-- فرم ورود -->
            <form method="post" class="space-y-4">
                <input type="text" name="log" placeholder="نام کاربری"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#fdfaf6] focus:ring-2 focus:ring-[#f2c57c] outline-none"
                       required>
                <div class="relative">
                    <input type="password" name="pwd" id="passwordField" placeholder="رمز عبور"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#fdfaf6] focus:ring-2 focus:ring-[#f2c57c] outline-none pr-12"
                           required>
                    <!-- دکمه نمایش/عدم نمایش رمز عبور -->
                    <button type="button" id="togglePassword"
                            class="absolute top-1/2 right-3 -translate-y-1/2 text-xl cursor-pointer">
                        <span id="eyeClosed">🫣</span>
                        <span id="eyeOpen" class="hidden">🤗</span>
                    </button>
                </div>
                <button type="submit" name="wp-submit"
                        class="w-full bg-[#f2c57c] text-[#6B4C3B] font-semibold py-3 rounded-xl shadow-md hover:bg-[#8B5E3C] hover:text-white transition">
                    ورود
                </button>
            </form>
        </div>

        <!-- بخش خوش‌آمدگویی و تصویر -->
        <div class="w-full md:w-1/2 flex-1 flex flex-col justify-center items-center bg-[#fff8f0] p-6 md:p-10 border-t md:border-t-0 md:border-l border-gray-200">
            <img src="<?php echo $theme_uri; ?>/assets/images/teacher.png"
                 alt="معلم" class="w-48 mb-6">
            <h2 class="text-2xl font-bold text-[#6B4C3B] mb-3">خوش آمدید</h2>
            <p class="text-[#8B5E3C] text-center leading-relaxed">
                برای ورود به پنل سرگروه، نام کاربری و رمز عبور خود را وارد کنید.
            </p>
        </div>

    </div>
</main>

<!-- جاوااسکریپت برای نمایش/عدم نمایش رمز عبور -->
<script>
const passwordField = document.getElementById("passwordField");
const togglePassword = document.getElementById("togglePassword");
const eyeOpen = document.getElementById("eyeOpen");
const eyeClosed = document.getElementById("eyeClosed");

togglePassword.addEventListener("click", () => {
    if (passwordField.type === "password") {
        passwordField.type = "text"; // نمایش رمز عبور
        eyeClosed.classList.add("hidden");
        eyeOpen.classList.remove("hidden");
    } else {
        passwordField.type = "password"; // مخفی کردن رمز عبور
        eyeClosed.classList.remove("hidden");
        eyeOpen.classList.add("hidden");
    }
});
</script>

<?php
get_footer(); // بارگذاری فوتر سایت
ob_end_flush(); // پایان بافر خروج و نمایش محتوا
?>
