<?php
/*
Template Name: Group Setting
*/
get_header();

if ( ! is_user_logged_in() ) {
    echo '<p>لطفاً ابتدا وارد شوید.</p>';
    get_footer();
    exit;
}

$user = wp_get_current_user();
$user_id = $user->ID;

if ( ! array_intersect(['parent','teacher'], (array) $user->roles) ) {
    echo '<p>شما اجازه دسترسی به این بخش را ندارید.</p>';
    get_footer();
    exit;
}

// گرفتن اطلاعات قبلی گروه
$group_data = get_user_meta($user_id, '_group_info', true);
if ( ! is_array($group_data) ) {
    $group_data = [
        'name'     => '',
        'password' => '',
        'image'    => '',
    ];
}

// نام فعلی سرگروه از پروفایل کاربر
$leader_name = $user->display_name;


// مسیر عکس پیشفرض (یکبار تعریفش کن)
$default_img = get_template_directory_uri() . '/assets/images/default-group.png';

// اگر فرم ارسال شد
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // حذف عکس و جایگزینی با عکس پیشفرض
    if (isset($_POST['remove_group_image'])) {
        $group_data['image'] = $default_img;
        update_user_meta($user_id, '_group_info', $group_data);
        echo '<p class="text-green-600">عکس حذف شد و به حالت پیشفرض برگشت ✅</p>';
    }

    // ذخیره تغییرات گروه
    if (isset($_POST['update_group'])) {
        $group_data['name']     = sanitize_text_field($_POST['group_name']);
        $group_data['password'] = sanitize_text_field($_POST['group_password']);

        // آپلود تصویر جدید اگر انتخاب شد
        if (!empty($_FILES['group_image']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            $uploaded = wp_handle_upload($_FILES['group_image'], ['test_form' => false]);
            if (!isset($uploaded['error'])) {
                $group_data['image'] = $uploaded['url'];
            }
        }

        update_user_meta($user_id, '_group_info', $group_data);

        // بروزرسانی display_name کاربر
        if (isset($_POST['leader_name']) && !empty($_POST['leader_name'])) {
            wp_update_user([
                'ID'           => $user_id,
                'display_name' => sanitize_text_field($_POST['leader_name']),
            ]);
        }

        echo '<p class="text-green-600">تنظیمات با موفقیت ذخیره شد ✅</p>';
        $leader_name = get_the_author_meta('display_name', $user_id);
    }
}
?>

<main class="max-w-screen-md mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">تنظیمات گروه</h2>

    <form method="post" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-md flex flex-col gap-4">
        <label>نام گروه:
            <input type="text" name="group_name" class="border p-2 w-full"
                   value="<?php echo esc_attr($group_data['name']); ?>" required>
        </label>

        <label>رمز گروه:
            <input type="text" name="group_password" class="border p-2 w-full"
                   value="<?php echo esc_attr($group_data['password']); ?>" required>
        </label>

        <label>نام سرگروه:
            <input type="text" name="leader_name" class="border p-2 w-full"
                   value="<?php echo esc_attr($leader_name); ?>" required>
        </label>

        <label>تصویر گروه:
            <?php if (!empty($group_data['image'])): ?>
                <div class="mb-2">
                    <img src="<?php echo esc_url($group_data['image']); ?>" alt="Group Image" class="w-32 h-32 object-cover rounded">
                </div>
            <?php endif; ?>
            <input type="file" name="group_image" class="border p-2 w-full">
        </label>
        <button type="submit" name="remove_group_image" class="ml-145 bg-red-500 text-white p-2 rounded">حذف عکس</button>

        <div class="flex gap-4">
            <button type="submit" name="update_group" class="bg-blue-500 text-white px-4 py-2 rounded">ذخیره تغییرات</button>
            <a href="<?php echo home_url('/dashboard'); ?>" class="bg-gray-500 text-white px-4 py-2 rounded">
                بازگشت به داشبورد
            </a>
        </div>
    </form>
</main>

<?php get_footer(); ?>
