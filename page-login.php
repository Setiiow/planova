<?php
/*
Template Name: Login Page
*/

$login_error = '';

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
?>
<?php get_header(); ?>
<main class="max-w-screen-md mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4"><?php the_title(); ?></h1>

    <?php if (!empty($login_error)) echo '<p class="text-red-500">' . esc_html($login_error) . '</p>'; ?>

    <form method="post" class="bg-white p-4 rounded shadow-md flex flex-col gap-4">
        <label>نام کاربری:
            <input type="text" name="log" class="border p-2" required>
        </label>
        <label>رمز عبور:
            <input type="password" name="pwd" class="border p-2" required>
        </label>
        <button type="submit" name="wp-submit" class="bg-blue-500 text-white p-2 rounded">ورود</button>
        <p class="mt-4 text-sm">
            هنوز ثبت‌نام نکردید؟ 
            <a href="<?php echo esc_url(home_url('/register')); ?>" class="text-blue-500 hover:underline">
                اینجا کلیک کنید
            </a>
        </p>
    </form>
</main>

<?php
get_footer();
?>
