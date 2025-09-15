<?php
/*
Template Name: Login Page
*/

$login_error = '';

ob_start();
get_header();

// بررسی ارسال فرم
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wp-submit'])) {
    $creds = [
        'user_login'    => sanitize_user($_POST['log']),
        'user_password' => $_POST['pwd'],
        'remember'      => true
    ];

    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        $login_error = 'نام کاربری یا رمز عبور اشتباه است.';
    } else {
        $user_role = $user->roles[0] ?? '';
        if ($user_role === 'parent' || $user_role === 'teacher') {
            wp_redirect(home_url('/dashboard'));
            exit;
        } else {
            $login_error = 'شما اجازه ورود به این صفحه را ندارید.';
        }
    }
}

$theme_uri = get_template_directory_uri();
?>

<main class="min-h-screen flex flex-col lg:flex-row items-center justify-center px-6 py-12">

    <div class="flex flex-col lg:flex-row items-center justify-center w-full max-w-6xl bg-white rounded-2xl shadow-[0_10px_25px_rgba(92,58,33,0.5)]">

        <!-- بخش خوش‌آمدگویی / تصویر -->
        <div class="w-full lg:w-1/2 flex flex-col items-center justify-center bg-[#fff8f0] p-6 lg:p-10 mb-6 lg:mb-0 rounded-2xl overflow-hidden">
            <img src="<?php echo $theme_uri; ?>/assets/images/teacher.png"
                alt="معلم"
                class="w-48 md:w-56 lg:w-64 mb-4 object-cover">
            <h2 class="text-2xl font-bold text-[#6B4C3B] mb-3">خوش آمدید</h2>
            <p class="text-[#8B5E3C] text-center leading-relaxed">
                برای ورود به پنل سرگروه، نام کاربری و رمز عبور خود را وارد کنید.
            </p>
        </div>


        <!-- فرم ورود -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center p-6 lg:p-10">
            <h2 class="text-2xl font-bold text-[#6B4C3B] text-center mb-6">👩‍🏫 ورود سرگروه</h2>

            <?php if (!empty($login_error)) : ?>
                <p class="text-red-500 text-center mb-4 font-bold"><?php echo esc_html($login_error); ?></p>
            <?php endif; ?>

            <form method="post" class="space-y-4">
                <input type="text" name="log" placeholder="نام کاربری"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#fdfaf6] focus:ring-2 focus:ring-[#f2c57c] outline-none"
                    required>
                <div class="relative">
                    <input type="password" name="pwd" id="passwordField" placeholder="رمز عبور"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#fdfaf6] focus:ring-2 focus:ring-[#f2c57c] outline-none pr-12"
                        required>
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
                <p class="text-center">
                    هنوز ثبت نام نکردید؟
                    <a class="text-red-800 font-semibold" href="<?php echo esc_url(home_url('/register')); ?>">اینجا</a> کلیک کنید.
                </p>
            </form>
        </div>

    </div>
</main>


<script>
    const passwordField = document.getElementById("passwordField");
    const togglePassword = document.getElementById("togglePassword");
    const eyeOpen = document.getElementById("eyeOpen");
    const eyeClosed = document.getElementById("eyeClosed");

    togglePassword.addEventListener("click", () => {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeClosed.classList.add("hidden");
            eyeOpen.classList.remove("hidden");
        } else {
            passwordField.type = "password";
            eyeClosed.classList.remove("hidden");
            eyeOpen.classList.add("hidden");
        }
    });
</script>

<?php
get_footer();
ob_end_flush();
?>