<?php
/* Template Name: Edit Member */

get_header();
if (! is_user_logged_in()) {
    echo '<p class="text-red-500">لطفاً ابتدا وارد شوید.</p>';
    get_footer();
    exit;
}

$user = wp_get_current_user();
if (! array_intersect(['parent', 'teacher'], (array) $user->roles)) {
    echo '<p class="text-red-500">شما اجازه دسترسی به این بخش را ندارید.</p>';
    get_footer();
    exit;
}

// مقدار پیش‌ فرض تصاویر بر اساس جنسیت
$default_girl_img = get_template_directory_uri() . '/assets/images/default-girl.webp';
$default_boy_img  = get_template_directory_uri() . '/assets/images/default-boy.png';
$user_id = $user->ID;
$errors = [];

// گرفتن member_id از URL
$member_id = isset($_GET['member_id']) ? intval($_GET['member_id']) : 0;
if (!$member_id) {
    echo '<p>عضو نامعتبر است.</p>';
    get_footer();
    exit;
}

// بررسی اینکه عضو انتخاب شده از گروه همین سرگروه باشد
$members = get_user_meta($user->ID, '_group_members', true);
if (!is_array($members) || !in_array($member_id, $members)) {
    echo '<p>این عضو جزو گروه شما نیست.</p>';
    get_footer();
    exit;
}


// گرفتن اطلاعات عضو
$member_data   = get_userdata($member_id);
$gender        = get_user_meta($member_id, 'gender', true);
$points        = get_user_meta($member_id, 'points', true);
$profile_image = get_user_meta($member_id, 'profile_image', true);
$tasks         = get_user_meta($member_id, '_member_tasks', true);

// بررسی درخواست حذف عکس یا ذخیره
$back_to_default = isset($_POST['del_image']) ? true : false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['save_member']) || $back_to_default)) {

    $name = sanitize_text_field($_POST['first_name'] ?? '');
    $lastname = sanitize_text_field($_POST['last_name'] ?? '');
    $gender = sanitize_text_field($_POST['gender'] ?? '');
    $points = intval($_POST['points']);

    if (empty($name)) $errors[] = 'لطفاً نام عضو را وارد کنید.';
    if (empty($lastname)) $errors[] = 'لطفاً نام خانوادگی عضو را وارد کنید.';
    if (empty($gender) || !in_array($gender, ['girl', 'boy'])) $errors[] = 'لطفاً جنسیت عضو را انتخاب کنید.';

    // بررسی آپلود تصویر جدید
    $member_img_url = '';
    if (!empty($_FILES['profile_image']['name'])) {
        $file = $_FILES['profile_image'];

        // بررسی حجم
        if ($file['size'] > 2 * 1024 * 1024) {
            $errors[] = 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.';
        }

        // بررسی فرمت
        if (!empty($file['tmp_name'])) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
            $file_type = mime_content_type($file['tmp_name']);
            if (!in_array($file_type, $allowed_types)) {
                $errors[] = 'فرمت تصویر معتبر نیست. فقط JPG, PNG, WEBP مجاز است.';
            }
        } else {
            $errors[] = 'مشکلی در آپلود فایل پیش آمد.';
        }

        if (empty($errors)) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $upload = media_handle_upload('profile_image', 0);
            if (!is_wp_error($upload)) {
                $member_img_url = wp_get_attachment_url($upload);
            } else {
                $errors[] = 'مشکلی در آپلود تصویر پیش آمد.';
            }
        }
    }

    // تعیین تصویر نهایی
    if (!empty($member_img_url)) {
        $final_image = $member_img_url;
    } elseif ($back_to_default) {
        $final_image = ($gender === 'girl') ? $default_girl_img : $default_boy_img;
    } else {
        $final_image = $profile_image ?: (($gender === 'girl') ? $default_girl_img : $default_boy_img);
    }

    // ذخیره اطلاعات در صورت عدم خطا
    if (empty($errors)) {
        wp_update_user([
            'ID' => $member_id,
            'first_name' => $name,
            'last_name'  => $lastname
        ]);
        update_user_meta($member_id, 'gender', $gender);
        update_user_meta($member_id, 'points', $points);
        update_user_meta($member_id, 'profile_image', $final_image);
        $profile_image = $final_image; // برای نمایش بعد از ذخیره
        $success_message = 'تغییرات با موفقیت ذخیره شد.';
    } else {
        echo '<div id="success-msg" class="bg-red-200 text-red-800 p-3 rounded mb-4">';
        foreach ($errors as $error) {
            echo '<p>' . esc_html($error) . '</p>';
        }
        echo '</div>';
    }
}
?>
<?php if (!empty($success_message)): ?>
    <div id="success-msg" class="bg-green-200 text-green-800 p-3 rounded mb-2">
        <?php echo esc_html($success_message); ?>
    </div>
<?php endif; ?>

<!-- فرم ویرایش اعضا -->
<form method="post" enctype="multipart/form-data" class="max-w-md rounded shadow-md flex flex-col  mx-auto bg-white p-6 my-4 gap-4">
    <label class="flex flex-col">
        نام:
        <input type="text" name="first_name" value="<?php echo esc_attr($member_data->first_name); ?>" required class="border p-2 rounded mt-1">
    </label>
    <label class="flex flex-col">
        نام خانوادگی:
        <input type="text" name="last_name" value="<?php echo esc_attr($member_data->last_name); ?>" required class="border p-2 rounded mt-1">
    </label>
    <label class="flex flex-col">
        جنسیت:
        <select name="gender" required class="border p-2 rounded mt-1">
            <option value="girl" <?php selected($gender, 'girl'); ?>>دختر</option>
            <option value="boy" <?php selected($gender, 'boy'); ?>>پسر</option>
        </select>
    </label>
    <label class="flex flex-col">
        امتیاز:
        <input type="number" name="points" value="<?php echo esc_attr($points); ?>" required class="border p-2 rounded mt-1">
    </label>
    <label class="flex flex-col">
        تصویر پروفایل:
        <img src="<?php echo esc_url($profile_image ?: ($gender === 'girl' ? $default_girl_img : $default_boy_img)); ?>" alt="Profile Image" class="w-24 h-24 object-cover rounded mb-2">
        <input type="file" name="profile_image" class="border p-2 rounded mt-1">
    </label>
    <button type="submit" name="del_image" class="bg-red-500 w-32 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
        حذف عکس
    </button>

    <button type="submit" name="save_member" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
        ذخیره تغییرات
    </button>
</form>

<script>
    // بعد از 2 ثانیه پیام مخفی شود
    setTimeout(function() {
        const msg = document.getElementById('success-msg');
        if (msg) {
            msg.style.display = 'none';
        }
    }, 2000);
</script>

<?php
get_footer();
?>