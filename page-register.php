<?php
/*
Template Name: Register Page
*/
get_header();
?>

<main class="max-w-screen-md mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4"><?php the_title(); ?></h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_user'])) {
        $username     = sanitize_user($_POST['username']);
        $password     = $_POST['password'];
        $email        = sanitize_email($_POST['email']);
        $role         = sanitize_text_field($_POST['role']);
        $display_name = sanitize_text_field($_POST['display_name']);

        $errors = [];

        if (empty($username)) $errors[] = 'نام کاربری را وارد کنید.';
        if (username_exists($username)) $errors[] = 'این نام کاربری قبلاً ثبت شده است.';
        if (!is_email($email)) $errors[] = 'ایمیل معتبر نیست.';
        if (email_exists($email)) $errors[] = 'این ایمیل قبلاً استفاده شده است.';
        if (empty($password)) $errors[] = 'رمز عبور را وارد کنید.';
        if (empty($display_name)) $errors[] = 'نام نمایشی را وارد کنید.';

        if (empty($errors)) {
            $user_id = wp_create_user($username, $password, $email);
            if (!is_wp_error($user_id)) {
                wp_update_user([
                    'ID'           => $user_id,
                    'role'         => $role,
                    'display_name' => $display_name,
                    'nickname'     => $display_name
                ]);
                echo '<p class="text-green-500">ثبت‌نام با موفقیت انجام شد. اکنون می‌توانید وارد شوید.</p>';
            } else {
                echo '<p class="text-red-500">' . esc_html($user_id->get_error_message()) . '</p>';
            }
        } else {
            foreach ($errors as $error) {
                echo '<p class="text-red-500">' . esc_html($error) . '</p>';
            }
        }
    }
    ?>

    <form method="post" class="bg-white p-4 rounded shadow-md flex flex-col gap-4">
        <label>نام کاربری (انگلیسی):
            <input type="text" name="username" class="border p-2" required>
        </label>
        <label>نام نمایشی (فارسی):
            <input type="text" name="display_name" class="border p-2" required>
        </label>
        <label>ایمیل:
            <input type="email" name="email" class="border p-2" required>
        </label>
        <label>رمز عبور:
            <input type="password" name="password" class="border p-2" required>
        </label>
        <label>نقش:
            <select name="role" class="border p-2" required>
                <option value="parent">والد</option>
                <option value="teacher">معلم</option>
            </select>
        </label>
        <button type="submit" name="register_user" class="bg-blue-500 text-white p-2 rounded">
            ثبت‌نام
        </button>
    </form>
</main>

<?php get_footer(); ?>
