<?php
/*
Template Name: Member Login
*/



$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['member_login'])) {
    // گرفتن و ایمن سازی ورودی‌ها
    $first_name     = sanitize_text_field($_POST['first_name'] ?? '');
    $last_name      = sanitize_text_field($_POST['last_name'] ?? '');
    $group_password = sanitize_text_field($_POST['group_password'] ?? '');

    if ($first_name === '' || $last_name === '' || $group_password === '') {
        $login_error = 'همه فیلدها الزامی هستند.';
    } else {
        // جستجو بین تمام اعضای گروه بر اساس نام، نام خانوادگی و رمز گروه
        $args = [
            'role' => 'member',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key'     => 'group_password', // متای رمز گروه
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

            // ورود همان کاربر (ست کردن کوکی‌های وردپرس)
            wp_set_current_user($member->ID);
            wp_set_auth_cookie($member->ID);
            do_action('wp_login', $member->user_login, $member);

            // ریدایرکت به داشبورد اعضا
            wp_redirect(home_url('/member-dashboard'));
            exit;
        }
    }
}
get_header();
?>

<main class="max-w-screen-md mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">ورود اعضا</h2>

    <?php if (!empty($login_error)) : ?>
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            <?php echo esc_html($login_error); ?>
        </div>
    <?php endif; ?>

    <form method="post" class="bg-white p-4 rounded shadow-md flex flex-col gap-4">
        <label>نام:
            <input type="text" name="first_name" class="border p-2 w-full" required>
        </label>
        <label>نام خانوادگی:
            <input type="text" name="last_name" class="border p-2 w-full" required>
        </label>
        <label>رمز گروه:
            <input type="text" name="group_password" class="border p-2 w-full" inputmode="numeric" pattern="[0-9]*" required>
        </label>

        <button type="submit" name="member_login" class="bg-blue-500 text-white px-4 py-2 rounded">
            ورود
        </button>
    </form>
</main>

<?php
get_footer();
?>
