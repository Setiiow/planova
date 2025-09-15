<?php
/*
Template Name: Register Page
*/

$errors = []; 
ob_start();

// بررسی ارسال فرم ثبت‌نام
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_user'])) {

    $username   = sanitize_user($_POST['username']);
    $password   = $_POST['password'];
    $email      = sanitize_email($_POST['email']);
    $role       = sanitize_text_field($_POST['role']);
    $group_name = sanitize_text_field($_POST['group_name']);

    // اعتبارسنجی
    if (empty($username)) $errors[] = 'نام کاربری را وارد کنید.';
    if (username_exists($username)) $errors[] = 'این نام کاربری قبلاً ثبت شده است.';
    if (!is_email($email)) $errors[] = 'ایمیل معتبر نیست.';
    if (email_exists($email)) $errors[] = 'این ایمیل قبلاً استفاده شده است.';
    if (empty($password)) $errors[] = 'رمز عبور را وارد کنید.';
    if (empty($group_name)) $errors[] = 'نام گروه را وارد کنید.';
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) $errors[] = 'نام کاربری باید فقط شامل حروف و اعداد انگلیسی باشد.';

    if (empty($errors)) {
        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            wp_update_user([
                'ID'   => $user_id,
                'role' => $role,
            ]);

            // رمز گروه ۴ رقمی
            do {
                $group_password = rand(1000, 9999);
            } while (!empty(get_users([
                'meta_key'   => '_group_info',
                'meta_value' => $group_password
            ])));

            $default_img = get_template_directory_uri() . '/assets/images/default-group.jpeg';

            update_user_meta($user_id, '_group_info', [
                'name'     => $group_name,
                'password' => $group_password,
                'image'    => $default_img,
            ]);

            // ورود خودکار
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);
            do_action('wp_login', $username, get_user_by('id', $user_id));

            wp_redirect(home_url('/dashboard'));
            exit;
        } else {
            $errors[] = $user_id->get_error_message();
        }
    }
}

get_header();
?>

<main class="min-h-screen flex items-center justify-center bg-[#f2c57c] relative overflow-hidden">

  <div class="w-full max-w-4xl flex flex-col md:flex-row items-center md:items-start lg:mr-85 md:mr-55 mx-4 gap-6 relative">

    <!-- فرم ثبت‌نام -->
    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-6 sm:p-8 relative z-10">

      <div class="flex justify-center mb-4">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png"
             alt="لوگو سایت"
             class="w-16 h-16 object-contain animate-bounce" />
      </div>

      <h1 class="text-xl font-bold mb-4 text-center text-[#6B4C3B]"><?php the_title(); ?></h1>

      <!-- نمایش خطاها -->
      <?php if (!empty($errors)) : ?>
        <div class="mb-4">
          <?php foreach ($errors as $error): ?>
            <p class="text-red-500 text-center"><?php echo esc_html($error); ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="post" class="flex flex-col gap-3">

        <label class="flex flex-col text-sm font-medium text-[#6B4C3B]">
          <span class="flex items-center gap-2"><span class="text-[#f2c57c]">👤</span> نام کاربری:</span>
          <input type="text" name="username"
            class="mt-1 px-3 py-2 border border-[#f2c57c]/50 rounded-lg focus:ring-2 focus:ring-[#f2c57c] outline-none"
            placeholder="فقط حروف و اعداد انگلیسی" required>
        </label>

        <label class="flex flex-col text-sm font-medium text-[#6B4C3B]">
          <span class="flex items-center gap-2"><span class="text-[#f2c57c]">📧</span> ایمیل:</span>
          <input type="email" name="email"
            class="mt-1 px-3 py-2 border border-[#f2c57c]/50 rounded-lg focus:ring-2 focus:ring-[#f2c57c] outline-none"
            required>
        </label>

        <label class="flex flex-col text-sm font-medium text-[#6B4C3B]">
          <span class="flex items-center gap-2"><span class="text-[#f2c57c]">🔒</span> رمز عبور:</span>
          <input type="password" name="password"
            class="mt-1 px-3 py-2 border border-[#f2c57c]/50 rounded-lg focus:ring-2 focus:ring-[#f2c57c] outline-none"
            required>
        </label>

        <label class="flex flex-col text-sm font-medium text-[#6B4C3B]">
          <span class="flex items-center gap-2"><span class="text-[#f2c57c]">🎭</span> نقش:</span>
          <select name="role"
            class="mt-1 px-3 py-2 border border-[#f2c57c]/50 rounded-lg focus:ring-2 focus:ring-[#f2c57c] outline-none"
            required>
            <option value="parent">والد</option>
            <option value="teacher">معلم</option>
          </select>
        </label>

        <label class="flex flex-col text-sm font-medium text-[#6B4C3B]">
          <span class="flex items-center gap-2"><span class="text-[#f2c57c]">👨‍👩‍👧‍👦</span> نام گروه:</span>
          <input type="text" name="group_name"
            class="mt-1 px-3 py-2 border border-[#f2c57c]/50 rounded-lg focus:ring-2 focus:ring-[#f2c57c] outline-none"
            required>
        </label>

        <button type="submit" name="register_user"
          class="w-full py-2 px-4 bg-[#f2c57c] text-[#6B4C3B] font-bold rounded-xl shadow-md hover:bg-[#8B5E3C] hover:text-white transition">
          ✨ ثبت‌نام و ایجاد گروه ✨
        </button>
      </form>
    </div>

    <!-- تصویر کنار فرم -->
    <div class="hidden lg:block absolute right-0 top-0 md:static md:flex md:items-start">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/boy.png"
           alt="پسر بچه سلام می‌کند"
           class="max-w-[160px] sm:max-w-[200px] md:max-w-[250px] lg:max-w-[300px] object-contain drop-shadow-xl md:-translate-y-6 md:translate-x-6" />
    </div>

  </div>
</main>

<?php
get_footer();
ob_end_flush();
?>
