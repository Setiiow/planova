<?php
/*
Template Name: Member Login
*/


$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['member_login'])) {
    // گرفتن و ایمن سازی ورودی‌ها
    $first_name     = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
    $last_name      = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
    $group_password = isset($_POST['group_password']) ? sanitize_text_field($_POST['group_password']) : '';

    if ($first_name === '' || $last_name === '' || $group_password === '') {
        $login_error = 'همه فیلدها الزامی هستند.';
    } else {
        //پیدا کردن سرگروه بر اساس رمز گروه
        $leader_id = 0;

        // فقط بین والد و معلم‌ها بگرد
        $leaders = get_users([
            'role__in' => ['parent', 'teacher'],
            'fields'   => ['ID'],
        ]);

        foreach ($leaders as $leader) {
            $group_info = get_user_meta($leader->ID, '_group_info', true);
            if (is_array($group_info) && isset($group_info['password'])) {
                if ((string)$group_info['password'] === (string)$group_password) {
                    $leader_id = (int)$leader->ID;
                    break;
                }
            }
        }

        if (!$leader_id) {
            $login_error = 'گروهی با این رمز یافت نشد.';
        } else {
            // ذخیره ایدی اعضای گروه سرگروه پیدا شده
            $member_ids = get_user_meta($leader_id, '_group_members', true);
            if (!is_array($member_ids)) {
                $member_ids = [];
            }

            $matched_member_id = 0;
            $matched_member_info = null;

            // پیدا کردن عضوی در گروه که هم نام با فردی که لاگین کرده باشه
            foreach ($member_ids as $id) {
                $info = get_userdata($id);
                if (!$info) continue;

                if (
                    strcasecmp(trim($info->first_name), trim($first_name)) === 0 &&
                    strcasecmp(trim($info->last_name), trim($last_name)) === 0
                ) {
                    $matched_member_id  = (int)$id;
                    $matched_member_info = $info;
                    break;
                }
            }

            if (!$matched_member_id) {
                $login_error = 'عضوی با این نام و نام خانوادگی در این گروه پیدا نشد.';
            } else {
                // ورود همان کاربر (ست کردن کوکی‌های وردپرس)
                wp_set_current_user($matched_member_id);
                wp_set_auth_cookie($matched_member_id);
                do_action('wp_login', $matched_member_info->user_login, $matched_member_info);

                // ریدایرکت به داشبورد اعضا
                $redirect_url = home_url('/member-dashboard');
                wp_redirect($redirect_url);
                exit;
            }
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
