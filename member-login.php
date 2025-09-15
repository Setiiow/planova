<?php
/*
Template Name: Member Login
*/

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['member_login'])) {
    $first_name     = sanitize_text_field($_POST['first_name'] ?? '');
    $last_name      = sanitize_text_field($_POST['last_name'] ?? '');
    $group_password = sanitize_text_field($_POST['group_password'] ?? '');

    if ($first_name === '' || $last_name === '' || $group_password === '') {
        $login_error = 'همه فیلدها الزامی هستند.';
    } else {
        $args = [
            'role' => 'member',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key'     => 'group_password',
                    'value'   => $group_password,
                    'compare' => '='
                ],
                [
                    'key'     => 'first_name',
                    'value'   => $first_name,
                    'compare' => '='
                ],
                [
                    'key'     => 'last_name',
                    'value'   => $last_name,
                    'compare' => '='
                ],
            ],
            'number' => 1
        ];

        $users = get_users($args);

        if (empty($users)) {
            $login_error = 'عضوی با این اطلاعات یافت نشد.';
        } else {
            $member = $users[0];
            wp_set_current_user($member->ID);
            wp_set_auth_cookie($member->ID);
            do_action('wp_login', $member->user_login, $member);

            wp_redirect(home_url('/member-dashboard'));
            exit;
        }
    }
}
get_header();
?>

<main class="flex-1 w-full flex items-center justify-center bg-[#fdf0dc] px-3 sm:px-4 py-32" dir="rtl">

  <div class="w-full max-w-3xl grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10 
              bg-[#fff8f0] p-5 sm:p-8 md:p-10 rounded-[30px] shadow-2xl 
              border-4 border-[#f2c57c]/70">

    <!-- تصویر کارتونی -->
    <div class="flex justify-center items-center order-1 md:order-none">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/open.png"
           alt="کارتون"
           id="kidImage"
           class="w-28 sm:w-40 md:w-56 lg:w-64 h-auto drop-shadow-xl transition-all duration-500" />
    </div>

    <!-- فرم ورود -->
    <div class="flex flex-col justify-center order-2 md:order-none">
      <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold mb-6 text-center text-[#6B4C3B] drop-shadow-sm">
        🎈 افزودن / ورود اعضا
      </h1>

      <?php if (!empty($login_error)) : ?>
        <p class="text-red-500 text-center mb-4 font-bold"><?php echo esc_html($login_error); ?></p>
      <?php endif; ?>

      <form id="memberForm" method="post"
            class="bg-white p-4 sm:p-6 lg:p-8 rounded-[25px] shadow-lg flex flex-col gap-4 sm:gap-5 border-2 border-[#f2c57c]/50">

        <!-- نام -->
        <label class="flex flex-col gap-2 text-[#6B4C3B] font-semibold text-sm sm:text-base">
          ✏️ نام:
          <input type="text" name="first_name"
                 class="border-2 border-[#f2c57c]/50 px-3 py-2 sm:px-4 sm:py-2 rounded-full focus:ring-4 focus:ring-[#f2c57c] outline-none text-[#6B4C3B] placeholder:text-[#8B5E3C]/60 text-sm sm:text-base"
                 placeholder="نام خودت رو وارد کن"
                 required>
        </label>

        <!-- نام خانوادگی -->
        <label class="flex flex-col gap-2 text-[#6B4C3B] font-semibold text-sm sm:text-base">
          📛 نام خانوادگی:
          <input type="text" name="last_name"
                 class="border-2 border-[#f2c57c]/50 px-3 py-2 sm:px-4 sm:py-2 rounded-full focus:ring-4 focus:ring-[#f2c57c] outline-none text-[#6B4C3B] placeholder:text-[#8B5E3C]/60 text-sm sm:text-base"
                 placeholder="نام خانوادگی خودت رو وارد کن"
                 required>
        </label>

        <!-- رمز گروه -->
        <label class="flex flex-col gap-2 text-[#6B4C3B] font-semibold text-sm sm:text-base relative">
          🔑 رمز گروه:
          <div class="relative">
            <input type="password" name="group_password" id="passwordField"
                   class="border-2 border-[#f2c57c]/50 px-3 py-2 sm:px-4 sm:py-2 rounded-full w-full pr-10 sm:pr-12 focus:ring-4 focus:ring-[#f2c57c] outline-none text-[#6B4C3B] placeholder:text-[#8B5E3C]/60 text-sm sm:text-base"
                   placeholder="رمز گروه رو وارد کن"
                   inputmode="numeric"
                   required>
            <button type="button" id="togglePassword"
                    class="absolute top-1/2 right-2 sm:right-3 -translate-y-1/2 text-xl sm:text-2xl cursor-pointer transition-transform duration-300 hover:scale-125">
              <span id="eyeClosed">🫣</span>
              <span id="eyeOpen" class="hidden">🤗</span>
            </button>
          </div>
        </label>

        <!-- دکمه -->
        <button type="submit" name="member_login"
                class="bg-[#f2c57c] text-[#6B4C3B] font-extrabold py-2 sm:py-3 rounded-full text-base sm:text-lg transition-all duration-300 hover:scale-105 hover:bg-[#8B5E3C] hover:text-white shadow-[0_4px_0_#8B5E3C] sm:shadow-[0_6px_0_#8B5E3C] active:shadow-[0_2px_0_#8B5E3C] active:translate-y-1">
          🚀 ورود / ثبت
        </button>
      </form>
    </div>
  </div>
</main>

<script>
    const passwordField = document.getElementById("passwordField");
    const kidImage = document.getElementById("kidImage");
    const togglePassword = document.getElementById("togglePassword");
    const eyeOpen = document.getElementById("eyeOpen");
    const eyeClosed = document.getElementById("eyeClosed");

    togglePassword.addEventListener("click", () => {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeClosed.classList.add("hidden");
            eyeOpen.classList.remove("hidden");
            kidImage.src = "<?php echo get_template_directory_uri(); ?>/assets/images/open.png";
        } else {
            passwordField.type = "password";
            eyeClosed.classList.remove("hidden");
            eyeOpen.classList.add("hidden");
            kidImage.src = "<?php echo get_template_directory_uri(); ?>/assets/images/close.png";
        }
    });

    passwordField.addEventListener("focus", () => {
        if (passwordField.type === "password") {
            kidImage.src = "<?php echo get_template_directory_uri(); ?>/assets/images/close.png";
        }
    });

    passwordField.addEventListener("blur", () => {
        if (passwordField.type === "password") {
            kidImage.src = "<?php echo get_template_directory_uri(); ?>/assets/images/open.png";
        }
    });
</script>

<?php
get_footer();
?>
