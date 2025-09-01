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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_member'])) {

    // نام عضو
    $name = sanitize_text_field($_POST['group_name']);
    // دریافت جنسیت
    $gender = isset($_POST['gender']) ? sanitize_text_field($_POST['gender']) : '';
    if ($gender === 'girl') {
    $member_img_url = $default_girl_img;
    } else {
    $member_img_url = $default_boy_img;
    }


    // آپلود تصویر
    if (!empty($_FILES['group_image']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $upload = media_handle_upload('group_image', 0);
        if (!is_wp_error($upload)) {
            $member_img_url = wp_get_attachment_url($upload);
        }
    }

    // گرفتن اعضای قبلی
    $members = get_user_meta($user_id, '_group_members', true);
    if (!is_array($members)) $members = [];

    // اضافه کردن عضو جدید
    $members[] = [
        'name'  => $name,
        'gender' => $gender,
        'image' => $member_img_url,
    ];

    // ذخیره‌سازی
    update_user_meta($user_id, '_group_members', $members);

    $success_message = '<p class="text-green-600">عضو با موفقیت اضافه شد ✅</p>';
}
?>

<main class="max-w-screen-md mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">افزودن عضو</h2>

    <?php if ($success_message) echo $success_message; ?>

    <form method="post" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-md flex flex-col gap-4">
        <label>نام عضو:
            <input type="text" name="group_name" class="border p-2 w-full" value="" required>
        </label>
        <label>جنسیت:
            <select name="gender" class="border p-2" required>
                <option value="girl">دختر</option>
                <option value="boy">پسر</option>
            </select>
        </label>
        <label>تصویر عضو:
            <input type="file" name="group_image" class="border p-2 w-full">
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