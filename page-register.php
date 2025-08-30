<?php
/*
Template Name: Register Page
*/

ob_start();

get_header();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_user'])) {

    $username       = sanitize_user($_POST['username']);
    $password       = $_POST['password'];
    $email          = sanitize_email($_POST['email']);
    $role           = sanitize_text_field($_POST['role']);
    $group_name     = sanitize_text_field($_POST['group_name']); 
    $group_password = sanitize_text_field($_POST['group_password']); 

    $errors = [];

    if (empty($username)) $errors[] = 'نام کاربری را وارد کنید.';
    if (username_exists($username)) $errors[] = 'این نام کاربری قبلاً ثبت شده است.';
    if (!is_email($email)) $errors[] = 'ایمیل معتبر نیست.';
    if (email_exists($email)) $errors[] = 'این ایمیل قبلاً استفاده شده است.';
    if (empty($password)) $errors[] = 'رمز عبور را وارد کنید.';
    if (empty($group_name)) $errors[] = 'نام گروه را وارد کنید.';
    if (empty($group_password)) $errors[] = 'رمز گروه را وارد کنید.';

    if (empty($errors)) {

        $user_id = wp_create_user($username, $password, $email);
        if (!is_wp_error($user_id)) {

            wp_update_user([
                'ID'   => $user_id,
                'role' => $role,
            ]);

            $default_img = get_template_directory_uri() . '/assets/images/default-group.png';
            
            update_user_meta($user_id, '_user_group', [
                'name'     => $group_name,
                'password' => $group_password,
                'image'    => !empty($uploaded_image) ? $uploaded_image : $default_img,
            ]);

            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);
            do_action('wp_login', $username, get_user_by('id', $user_id));

            wp_redirect(home_url('/dashboard'));
            exit;
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

<main class="max-w-screen-md mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4"><?php the_title(); ?></h1>

    <!-- فرم ثبت‌ نام , ایجاد گروه -->
    <form method="post" class="bg-white p-4 rounded shadow-md flex flex-col gap-4">
        <label>نام کاربری:
            <input type="text" name="username" class="border p-2" required>
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

        <label>نام گروه:
            <input type="text" name="group_name" class="border p-2" required>
        </label>
        <label>رمز گروه:
            <input type="password" name="group_password" class="border p-2" required>
        </label>

        <button type="submit" name="register_user" class="bg-blue-500 text-white p-2 rounded">
            ثبت‌ نام و ایجاد گروه
        </button>
    </form>
</main>

<?php 
ob_end_flush(); 
get_footer();
?>
