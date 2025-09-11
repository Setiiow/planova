<?php
/*
Template Name: Add Member
*/
get_header();

// بررسی ورود کاربر
if (! is_user_logged_in()) {
    echo '<p>لطفاً ابتدا وارد شوید.</p>';
    get_footer();
    exit;
}

$user = wp_get_current_user();
$user_id = $user->ID;

// بررسی نقش کاربر
if (! array_intersect(['parent', 'teacher'], (array) $user->roles)) {
    echo '<p>شما اجازه دسترسی به این بخش را ندارید.</p>';
    get_footer();
    exit;
}

// مقدار پیش‌فرض تصاویر بر اساس جنسیت
$default_girl_img = get_template_directory_uri() . '/assets/images/default-girl.webp';
$default_boy_img  = get_template_directory_uri() . '/assets/images/default-boy.png';
$member_img_url = '';
$success_message = '';
$name = '';
$lastname = '';
$gender = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_member'])) {

    $name = sanitize_text_field($_POST['member_name'] ?? '');
    $lastname = sanitize_text_field($_POST['member_lastname'] ?? '');
    $gender = sanitize_text_field($_POST['gender'] ?? '');

    if (empty($name)) $errors[] = 'لطفاً نام عضو را وارد کنید.';
    if (empty($lastname)) $errors[] = 'لطفاً نام خانوادگی عضو را وارد کنید.';
    if (empty($gender) || !in_array($gender, ['girl', 'boy'])) $errors[] = 'لطفاً جنسیت عضو را انتخاب کنید.';

    // گرفتن اعضای قبلی
    $members = get_user_meta($user_id, '_group_members', true);
    if (!is_array($members)) $members = [];

    foreach ($members as $member_id) {
        $member_data = get_userdata($member_id);
        if ($member_data) {
            if (
                strcasecmp($member_data->first_name, $name) === 0 &&
                strcasecmp($member_data->last_name, $lastname) === 0
            ) {
                $errors[] = 'این عضو قبلاً در گروه شما ثبت شده است.';
                break;
            }
        }
    }



    // (با بررسی حجم و پسوند) آپلود تصویر
    if (!empty($_FILES['member_image']['name'])) {
        $file = $_FILES['member_image'];

        // بررسی حجم
        if ($file['size'] > 2 * 1024 * 1024) {
            $errors[] = 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.';
        }

        // بررسی فرمت
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

        // ساخت نام کاربری لاتین و یکتا
        do {
            $user_login = 'member' . rand(1000, 9999);
        } while (username_exists($user_login));

        $user_pass = wp_generate_password();
        $user_email = $user_login . '@example.com';

        $new_user_id = wp_create_user($user_login, $user_pass, $user_email);

        if (is_wp_error($new_user_id)) {
            $errors[] = 'خطا در ایجاد عضو: ' . $new_user_id->get_error_message();
        } else {
            wp_update_user([
                'ID' => $new_user_id,
                'first_name' => $name,
                'last_name'  => $lastname,
                'role'       => 'member'
            ]);
            update_user_meta($new_user_id, 'gender', $gender);
            update_user_meta($new_user_id, 'profile_image', $member_img_url);
            update_user_meta($new_user_id, 'points', 0); // اضافه کردن فیلد امتیاز با مقدار اولیه 0
            // ذخیره رمز گروه در پروفایل عضو هنگام افزودن عضو جدید
            $group_info = get_user_meta($user_id, '_group_info', true);
            if (!empty($group_info['password'])) {
                update_user_meta($new_user_id, 'group_password', $group_info['password']);
            }
        }

        // اضافه کردن به گروه سرگروه
        $members[] = $new_user_id;
        update_user_meta($user_id, '_group_members', $members);
        $success_message = '<p class="text-green-600">عضو با موفقیت اضافه شد ✅</p>';

        // خالی کردن فیلدها بعد از موفقیت
        $name = $lastname = $member_img_url = $gender = '';
    }
}

// نمایش خطا 
if (!empty($errors)) {
    echo '<div class="bg-red-200 text-red-800 p-3 rounded mb-4">';
    foreach ($errors as $error) {
        echo '<p>' . esc_html($error) . '</p>';
    }
    echo '</div>';
}
?>

<main class="max-w-screen-md mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">افزودن عضو</h2>

    <?php if ($success_message) echo $success_message; ?>

    <form method="post" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-md flex flex-col gap-4">
        <label>نام عضو:
            <input type="text" name="member_name" value="<?php echo esc_attr($name); ?>" class="border p-2 w-full" required>
        </label>
        <label>نام خانوادگی عضو:
            <input type="text" name="member_lastname" value="<?php echo esc_attr($lastname); ?>" class="border p-2 w-full">
        </label>
        <label>جنسیت:
            <select name="gender" class="border p-2" required>
                <option value="girl" <?php selected($gender, 'girl'); ?>>دختر</option>
                <option value="boy" <?php selected($gender, 'boy'); ?>>پسر</option>
            </select>
        </label>
        <label>تصویر عضو:
            <input type="file" name="member_image" class="border p-2 w-full">
        </label>

        <div class="flex gap-4">
            <button type="submit" name="add_member" class="bg-blue-500 text-white px-4 py-2 rounded">افزودن عضو</button>
            <a href="<?php echo home_url('/dashboard'); ?>" class="bg-gray-500 text-white px-4 py-2 rounded">
                بازگشت به داشبورد
            </a>
        </div>
    </form>
</main>

<?php get_footer(); ?>