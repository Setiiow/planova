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

$errors = [];
$success_message = '';

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
$first_name    = $member_data->first_name;
$last_name     = $member_data->last_name;
$gender        = get_user_meta($member_id, 'gender', true);
$points        = get_user_meta($member_id, 'points', true);
$profile_image = get_user_meta($member_id, 'profile_image', true);
$tasks         = get_user_meta($member_id, '_member_tasks', true);

$delete_photo = 0; // متغیر برای حذف عکس


if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // بررسی اینکه آیا دکمه حذف عکس زده شده
    if (isset($_POST['del_photo'])) {
        $delete_photo = 1;
        $success_message = 'عکس حذف شد.';
        $profile_image = ''; // برای نمایش پیش‌فرض
    }

    if (isset($_POST['save_member'])) {

        $name = sanitize_text_field($_POST['first_name'] ?? '');
        $lastname = sanitize_text_field($_POST['last_name'] ?? '');
        $gender = sanitize_text_field($_POST['gender'] ?? '');
        $points = intval($_POST['points'] ?? 0);

        if (empty($first_name)) $errors[] = 'لطفاً نام عضو را وارد کنید.';
        if (empty($last_name)) $errors[] = 'لطفاً نام خانوادگی عضو را وارد کنید.';
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
                    $profile_image = $member_img_url; // بروزرسانی متغیر برای نمایش بعد از ثبت
                } else {
                    $errors[] = 'مشکلی در آپلود تصویر پیش آمد.';
                }
            }
       }
    // اگر دکمه حذف عکس زده شده
    if ($delete_photo && empty($_FILES['profile_image']['name'])) {
        $profile_image = ($gender === 'girl' ? $default_girl_img : $default_boy_img);
        update_user_meta($member_id, 'profile_image', '');
    }

    if (empty($errors)) {
        wp_update_user([
            'ID'         => $member_id,
            'first_name' => $first_name,
            'last_name'  => $last_name
        ]);
        update_user_meta($member_id, 'gender', $gender);
        update_user_meta($member_id, 'points', $points);

        if (!$delete_photo && !empty($member_img_url)) {
            update_user_meta($member_id, 'profile_image', $member_img_url);
        }

        $success_message = 'تغییرات با موفقیت ذخیره شد.';
    }
}
}

  

// حذف عضو
if (isset($_POST['delete_member'])) {
    if (in_array($member_id, $members)) {
        $members = array_diff($members, [$member_id]);
        update_user_meta($user->ID, '_group_members', $members);

        require_once(ABSPATH . 'wp-admin/includes/user.php');
        wp_delete_user($member_id);

        $success_message = 'عضو با موفقیت حذف شد.';
    }
}


// نمایش پیام‌ها
if (!empty($errors)) {
    echo '<div id="success-msg" class="bg-red-200 text-red-800 p-3 rounded mb-4">';
    foreach ($errors as $error) {
        echo '<p>' . esc_html($error) . '</p>';
    }
    echo '</div>';
}
if (!empty($success_message)) {
    echo '<div id="success-msg" class="bg-green-200 text-green-800 p-3 rounded mb-4">' . esc_html($success_message) . '</div>';
}
?>

<?php if ($member_data): ?>
    <div class="bg-gray-50 rounded-lg shadow p-4 text-center member-card max-w-md mx-auto" data-member-id="<?php echo $member_id; ?>">
        <form method="post" enctype="multipart/form-data" class="flex flex-col items-center">
            <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">

            <img src="<?php echo esc_url($profile_image ?: ($gender === 'girl' ? $default_girl_img : $default_boy_img)); ?>"
                alt="<?php echo esc_attr($first_name); ?>"
                class="w-24 h-24 mx-auto rounded-full object-cover mb-3 member-img">

            <div class="member-view">
                <h3 class="text-lg font-semibold"><?php echo esc_html($first_name . ' ' . $last_name); ?></h3>
                <p class="text-sm text-gray-600">جنسیت: <?php echo ($gender === 'girl' ? 'دختر' : 'پسر'); ?></p>
                <p class="text-sm text-gray-600">امتیاز: <?php echo esc_html($points); ?></p>
                <button type="button" class="bg-blue-500 text-white px-3 py-1 mt-2 rounded edit-btn">ویرایش</button>
                <button type="submit" name="delete_member" class="bg-red-500 text-white px-3 py-1 mt-2 rounded del-btn" data-name="<?php echo esc_attr(trim($first_name . ' ' . $last_name)); ?>">حذف</button>
            </div>

            <div class="member-edit hidden flex flex-col gap-2 w-full">
                <input type="text" name="first_name" value="<?php echo esc_attr($first_name); ?>" class="border p-1 w-full">
                <input type="text" name="last_name" value="<?php echo esc_attr($last_name); ?>" class="border p-1 w-full">
                <select name="gender" class="border p-1 w-full">
                    <option value="girl" <?php selected($gender, 'girl'); ?>>دختر</option>
                    <option value="boy" <?php selected($gender, 'boy'); ?>>پسر</option>
                </select>
                <input type="number" name="points" value="<?php echo esc_attr($points); ?>" class="border p-1 w-full">
                <input type="file" name="profile_image" class="border p-1 w-full">
                <button type="submit" name="del_photo" class="bg-red-500 text-white px-4 py-2 rounded mt-2">حذف عکس</button>
                <button type="submit" name="save_member" class="bg-green-500 text-white px-4 py-2 rounded mt-2">ثبت تغییرات</button>
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mt-1 cancel-btn">لغو</button>
            </div>
        </form>
    </div>
<?php endif; ?>
<!-- نمایش وظایف عضو -->
<?php if (!empty($tasks) && is_array($tasks)): ?>
    <div class="bg-white shadow-md rounded p-4 mt-6">
        <h2 class="text-lg font-bold mb-4">وظایف عضو</h2>
        <ul class="space-y-2">
            <?php foreach ($tasks as $task): ?>
                <li class="flex justify-between items-center border-b pb-2">
                    <div class="flex">
                        <span><?php echo esc_html($task['title']); ?></span>
                        <span class="mr-2 text-green-700">(امتیاز: <?php echo esc_html($task['points']); ?>)</span>
                    </div>
                    <?php if (!empty($task['done']) && $task['done'] == 1): ?>
                        <span class="text-green-600 font-semibold">انجام شده ✅</span>
                    <?php else: ?>
                        <span class="text-red-600 font-semibold">انجام نشده ❌</span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php else: ?>
    <p class="mt-4 text-gray-600">هنوز وظیفه‌ای برای این عضو ثبت نشده است.</p>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const card = btn.closest('.member-card');
                card.querySelector('.member-view').classList.add('hidden');
                card.querySelector('.member-edit').classList.remove('hidden');
            });
        });
        document.querySelectorAll('.cancel-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const card = btn.closest('.member-card');
                card.querySelector('.member-edit').classList.add('hidden');
                card.querySelector('.member-view').classList.remove('hidden');
            });
        });
        document.querySelectorAll('.del-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                const memberName = btn.getAttribute('data-name');
                if (!confirm("آیا مطمئن هستید که می‌خواهید «" + memberName + "» حذف شود؟")) {
                    e.preventDefault();
                }
            });
        });
    });

    // بعد از 2 ثانیه پیام مخفی شود
    setTimeout(function() {
        const msg = document.getElementById('success-msg');
        if (msg) {
            msg.style.display = 'none';
        }
    }, 2000);
</script>

<?php get_footer(); ?>