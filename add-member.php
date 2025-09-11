<?php
/*
Template Name: Add Member
*/
get_header();

// بررسی ورود کاربر
if (! is_user_logged_in()) {
    echo '<p class="text-center text-red-600 mt-10 font-bold">لطفاً ابتدا وارد شوید.</p>';
    get_footer();
    exit;
}

$user    = wp_get_current_user();
$user_id = $user->ID;

// مقداردهی اولیه برای جلوگیری از خطا
$success_message = '';
$errors          = [];
$name            = '';
$lastname        = '';
$gender          = '';
$member_img_url  = '';

// پیش‌فرض تصاویر
$default_girl_img = get_template_directory_uri() . '/assets/images/default-girl.webp';
$default_boy_img  = get_template_directory_uri() . '/assets/images/default-boy.png';

// وقتی فرم ارسال شد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_member'])) {
    $name     = sanitize_text_field($_POST['member_name'] ?? '');
    $lastname = sanitize_text_field($_POST['member_lastname'] ?? '');
    $gender   = sanitize_text_field($_POST['gender'] ?? '');

    if (empty($name)) $errors[] = 'لطفاً نام عضو را وارد کنید.';
    if (empty($lastname)) $errors[] = 'لطفاً نام خانوادگی عضو را وارد کنید.';
    if (empty($gender) || !in_array($gender, ['girl', 'boy'])) $errors[] = 'لطفاً جنسیت عضو را انتخاب کنید.';

    // آپلود تصویر
    if (!empty($_FILES['member_image']['name'])) {
        $file = $_FILES['member_image'];
        if ($file['size'] > 2 * 1024 * 1024) {
            $errors[] = 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.';
        }
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
        $file_type = mime_content_type($file['tmp_name']);
        if (!in_array($file_type, $allowed_types)) {
            $errors[] = 'فرمت تصویر معتبر نیست. فقط JPG, PNG, WEBP مجاز است.';
        }
        if (empty($errors)) {
            $upload = media_handle_upload('member_image', 0);
            if (!is_wp_error($upload)) {
                $member_img_url = wp_get_attachment_url($upload);
            } else {
                $errors[] = 'مشکلی در آپلود تصویر پیش آمد.';
            }
        }
    }

    if (empty($errors)) {
        if (empty($member_img_url)) {
            $member_img_url = ($gender === 'girl') ? $default_girl_img : $default_boy_img;
        }

        // ایجاد یوزر جدید
        do {
            $user_login = 'member' . rand(1000, 9999);
        } while (username_exists($user_login));

        $user_pass  = wp_generate_password();
        $user_email = $user_login . '@example.com';
        $new_user_id = wp_create_user($user_login, $user_pass, $user_email);

        if (!is_wp_error($new_user_id)) {
            wp_update_user([
                'ID'         => $new_user_id,
                'first_name' => $name,
                'last_name'  => $lastname,
                'role'       => 'member'
            ]);
            update_user_meta($new_user_id, 'gender', $gender);
            update_user_meta($new_user_id, 'profile_image', $member_img_url);
            update_user_meta($new_user_id, 'points', 0);
        }

        // افزودن به لیست اعضا
        $members = get_user_meta($user_id, '_group_members', true);
        if (!is_array($members)) $members = [];
        $members[] = $new_user_id;
        update_user_meta($user_id, '_group_members', $members);

        $success_message = '<p class="text-green-600 text-center font-bold">✅ عضو با موفقیت اضافه شد</p>';

        $name = $lastname = $gender = $member_img_url = '';
    }
}
?>

<main class="max-w-md mx-auto p-6 bg-[#fdfaf6] rounded-2xl shadow-lg mt-10">
    <h2 class="text-2xl font-bold text-[#6B4C3B] mb-6 text-center">✨ افزودن عضو جدید ✨</h2>

    <?php if ($success_message) echo $success_message; ?>

    <?php if (!empty($errors)) : ?>
        <div class="bg-red-200 text-red-800 p-4 rounded-xl mb-6 space-y-1 font-semibold text-sm">
            <?php foreach ($errors as $error) : ?>
                <p>❌ <?php echo esc_html($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" 
          class="bg-[#fff8f0] p-6 rounded-2xl shadow-md flex flex-col gap-5 border border-[#f2c57c]/30">

        <label class="flex flex-col gap-2 text-[#6B4C3B] font-medium">
            نام عضو
            <input type="text" name="member_name" value="<?php echo esc_attr($name); ?>"
                   class="border border-[#f2c57c]/50 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#f2c57c] w-full bg-white" required>
        </label>

        <label class="flex flex-col gap-2 text-[#6B4C3B] font-medium">
            نام خانوادگی
            <input type="text" name="member_lastname" value="<?php echo esc_attr($lastname); ?>"
                   class="border border-[#f2c57c]/50 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#f2c57c] w-full bg-white">
        </label>

        <label class="flex flex-col gap-2 text-[#6B4C3B] font-medium">
            جنسیت
            <select name="gender" class="border border-[#f2c57c]/50 rounded-xl p-3 bg-white focus:outline-none focus:ring-2 focus:ring-[#f2c57c]" required>
                <option value="">-- انتخاب کنید --</option>
                <option value="girl" <?php selected($gender, 'girl'); ?>>👧 دختر</option>
                <option value="boy" <?php selected($gender, 'boy'); ?>>👦 پسر</option>
            </select>
        </label>

        <label class="flex flex-col gap-2 text-[#6B4C3B] font-medium">
            تصویر عضو
            <input type="file" name="member_image"
                   class="border-2 border-dashed border-[#f2c57c]/50 rounded-xl p-3 bg-white cursor-pointer hover:bg-[#f2c57c]/30 transition">
        </label>

        <div class="flex gap-4 justify-center mt-4">
            <button type="submit" name="add_member"
                    class="bg-[#f2c57c] text-[#6B4C3B] font-bold px-6 py-3 rounded-2xl shadow-md hover:bg-[#8B5E3C] hover:text-white transition">
                ➕ افزودن
            </button>
            <a href="<?php echo home_url('/dashboard'); ?>"
               class="bg-[#6B4C3B] text-white font-bold px-6 py-3 rounded-2xl shadow-md hover:bg-[#8B5E3C] transition">
                 بازگشت
            </a>
        </div>
    </form>
</main>

<?php get_footer(); ?>
