<?php
/*
Template Name: Register Page
*/

// بافر خروجی برای جلوگیری از خطاهای هدر
ob_start();

// نمایش هدر سایت
get_header();


// بررسی ارسال فرم ثبت‌نام
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_user'])) {

    // دریافت و ایمن‌سازی داده‌ها
    $username       = sanitize_user($_POST['username']);
    $password       = $_POST['password'];
    $email          = sanitize_email($_POST['email']);
    $role           = sanitize_text_field($_POST['role']);
    $group_name     = sanitize_text_field($_POST['group_name']);

    // آرایه خطاها
    $errors = [];

    // اعتبارسنجی داده‌ها
    if (empty($username)) $errors[] = 'نام کاربری را وارد کنید.';
    if (username_exists($username)) $errors[] = 'این نام کاربری قبلاً ثبت شده است.';
    if (!is_email($email)) $errors[] = 'ایمیل معتبر نیست.';
    if (email_exists($email)) $errors[] = 'این ایمیل قبلاً استفاده شده است.';
    if (empty($password)) $errors[] = 'رمز عبور را وارد کنید.';
    if (empty($group_name)) $errors[] = 'نام گروه را وارد کنید.';
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) $errors[] = 'لطفاً نام کاربری را فقط به حروف و اعداد انگلیسی وارد کنید.';

    // اگر خطایی وجود نداشت → ایجاد کاربر
    if (empty($errors)) {

        $user_id = wp_create_user($username, $password, $email);
        if (!is_wp_error($user_id)) {

            // تعیین نقش کاربر
            wp_update_user([
                'ID'   => $user_id,
                'role' => $role,
            ]);

            // تولید رمز یکتا ۴ رقمی برای گروه
            do {
                $group_password = rand(1000, 9999);
            } while (!empty(get_users([
                'meta_key' => '_group_info',
                'meta_value' => $group_password
            ])));

            // تصویر پیش‌فرض گروه
            $default_img = get_template_directory_uri() . '/assets/images/default-group.png';

            // ذخیره اطلاعات گروه در متای کاربر
            update_user_meta($user_id, '_group_info', [
                'name'     => $group_name,
                'password' => $group_password,
                'image'    => $default_img,
            ]);

            // ورود خودکار بعد از ثبت‌نام
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);
            do_action('wp_login', $username, get_user_by('id', $user_id));

            // ریدایرکت به داشبورد
            wp_redirect(home_url('/dashboard'));
            exit;
        } else {
            // نمایش خطای وردپرس در صورت شکست ایجاد کاربر
            echo '<p class="text-red-500">' . esc_html($user_id->get_error_message()) . '</p>';
        }
    } else {
        // نمایش لیست خطاها
        foreach ($errors as $error) {
            echo '<p class="text-red-500">' . esc_html($error) . '</p>';
        }
    }
}
?>

<!-- محتوای اصلی صفحه ثبت‌نام -->
<main class="min-h-screen flex items-center justify-center bg-[#f2c57c] px-4 relative overflow-hidden">
  
  <!-- کانتینر اصلی: فرم + تصویر -->
  <div class="w-full max-w-4xl flex flex-col md:flex-row items-center md:items-start gap-6 relative md:ml-[-490px]">
    
    <!-- فرم ثبت‌نام -->
    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-6 sm:p-8 relative z-10">
      
      <!-- لوگوی سایت -->
      <div class="flex justify-center mb-4">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png"
             alt="لوگو سایت"
             class="w-16 h-16 object-contain animate-bounce" />
      </div>

      <!-- عنوان صفحه -->
      <h1 class="text-xl font-bold mb-4 text-center text-[#6B4C3B]">
        <?php the_title(); ?>
      </h1>

      <!-- فرم ثبت‌نام -->
      <form method="post" class="flex flex-col gap-3">
        
        <!-- نام کاربری -->
        <label class="flex flex-col text-sm font-medium text-[#6B4C3B]">
          <span class="flex items-center gap-2">
            <span class="text-[#f2c57c]">👤</span> نام کاربری:
          </span>
          <input type="text" name="username"
            class="mt-1 px-3 py-2 border border-[#f2c57c]/50 rounded-lg focus:ring-2 focus:ring-[#f2c57c] focus:outline-none transition"
            placeholder="لطفا نام انگلیسی انتخاب کنید." required>
        </label>

        <!-- ایمیل -->
        <label class="flex flex-col text-sm font-medium text-[#6B4C3B]">
          <span class="flex items-center gap-2">
            <span class="text-[#f2c57c]">📧</span> ایمیل:
          </span>
          <input type="email" name="email"
            class="mt-1 px-3 py-2 border border-[#f2c57c]/50 rounded-lg focus:ring-2 focus:ring-[#f2c57c] focus:outline-none transition"
            required>
        </label>

        <!-- رمز عبور -->
        <label class="flex flex-col text-sm font-medium text-[#6B4C3B]">
          <span class="flex items-center gap-2">
            <span class="text-[#f2c57c]">🔒</span> رمز عبور:
          </span>
          <input type="password" name="password"
            class="mt-1 px-3 py-2 border border-[#f2c57c]/50 rounded-lg focus:ring-2 focus:ring-[#f2c57c] focus:outline-none transition"
            required>
        </label>

        <!-- انتخاب نقش -->
        <label class="flex flex-col text-sm font-medium text-[#6B4C3B]">
          <span class="flex items-center gap-2">
            <span class="text-[#f2c57c]">🎭</span> نقش:
          </span>
          <select name="role"
            class="mt-1 px-3 py-2 border border-[#f2c57c]/50 rounded-lg focus:ring-2 focus:ring-[#f2c57c] focus:outline-none transition"
            required>
            <option value="parent">والد</option>
            <option value="teacher">معلم</option>
          </select>
        </label>

        <!-- نام گروه -->
        <label class="flex flex-col text-sm font-medium text-[#6B4C3B]">
          <span class="flex items-center gap-2">
            <span class="text-[#f2c57c]">👨‍👩‍👧‍👦</span> نام گروه:
          </span>
          <input type="text" name="group_name"
            class="mt-1 px-3 py-2 border border-[#f2c57c]/50 rounded-lg focus:ring-2 focus:ring-[#f2c57c] focus:outline-none transition"
            required>
        </label>

        <!-- دکمه ارسال فرم -->
        <button type="submit" name="register_user"
          class="w-full py-2 px-4 bg-[#f2c57c] text-[#6B4C3B] font-bold rounded-xl shadow-md hover:bg-[#8B5E3C] hover:text-white transition transform hover:scale-105 duration-300">
          ✨ ثبت‌ نام و ایجاد گروه ✨
        </button>
      </form>
    </div>

    <!-- تصویر پسر بچه در کنار فرم -->
    <div class="absolute right-0 top-0 md:static md:flex md:items-start">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/boy.png"
           alt="پسر بچه سلام می‌کند"
           class="max-w-[160px] sm:max-w-[200px] md:max-w-[250px] lg:max-w-[300px] object-contain drop-shadow-xl md:-translate-y-6 md:translate-x-6" />
    </div>

  </div>
</main>

<?php
// بستن بافر خروجی و نمایش فوتر سایت
ob_end_flush();
get_footer();
?>
