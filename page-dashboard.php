<?php
/* Template Name: Dashboard */
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

$user_id = $user->ID;
$errors = [];

// گرفتن اعضای قبلی
$members = get_user_meta($user_id, '_group_members', true);
if (!is_array($members)) $members = [];

$success_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_member'])) {
    $member_id = intval($_POST['member_id']);
    if (in_array($member_id, $members)) {
        $first_name = sanitize_text_field($_POST['first_name'] ?? '');
        $last_name  = sanitize_text_field($_POST['last_name'] ?? '');
        $gender     = sanitize_text_field($_POST['gender'] ?? '');
        $points     = intval($_POST['points'] ?? 0);

        if (empty($first_name)) $errors[] = 'لطفاً نام عضو را وارد کنید.';
        if (empty($last_name)) $errors[] = 'لطفاً نام خانوادگی عضو را وارد کنید.';
        if (empty($gender) || !in_array($gender, ['girl', 'boy'])) $errors[] = 'لطفاً جنسیت عضو را انتخاب کنید.';

        // بررسی تصویر (حجم و فرمت)
        if (!empty($_FILES['profile_image']['name'])) {
            $file = $_FILES['profile_image'];

            // حجم (حداکثر ۲ مگابایت)
            if ($file['size'] > 2 * 1024 * 1024) {
                $errors[] = 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.';
            }

            // فرمت
            $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
            $file_type = mime_content_type($file['tmp_name']);
            if (!in_array($file_type, $allowed_types)) {
                $errors[] = 'فرمت تصویر معتبر نیست. فقط JPG, PNG, WEBP مجاز است.';
            }
        }
        
        if (empty($errors)) {


            wp_update_user([
                'ID' => $member_id,
                'first_name' => $first_name,
                'last_name'  => $last_name
            ]);

            update_user_meta($member_id, 'gender', $gender);
            update_user_meta($member_id, 'points', $points);

            // آپلود تصویر
            if (!empty($_FILES['profile_image']['name'])) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $upload = media_handle_upload('profile_image', 0);
                if (!is_wp_error($upload)) {
                    update_user_meta($member_id, 'profile_image', wp_get_attachment_url($upload));
                } else {
                    $errors[] = 'مشکلی در آپلود تصویر پیش آمد.';
                }
            }
            

            if (empty($errors)) {
                $success_message = 'عضو با موفقیت ویرایش شد.';
            }
        }
    }
}

$group = get_user_meta($user_id, '_group_info', true);
if (! is_array($group) || empty($group)) {
    $group = get_user_meta($user_id, '_group_info', true);
    if (! is_array($group)) $group = [];
}

$group_name     = $group['name']     ?? '';
$group_password = $group['password'] ?? '';
$group_img = $group['image'] ?? '';
$leader_name    = get_the_author_meta('display_name', $user_id);

if ($group_name) {
    echo '<div class="bg-white shadow-md rounded p-4 mb-4">';
    echo '<h2 class="text-xl font-bold mb-4">گروه شما</h2>';
    echo '<div class="flex flex-wrap gap-6 items-center">';
    echo '<p><strong>نام گروه:</strong> <span class="text-blue-600">' . esc_html($group_name) . '</span></p>';
    echo '<p><strong>نام سرگروه:</strong> <span class="text-green-600">' . esc_html($leader_name) . '</span></p>';
    echo '<p><strong>عکس گروه: </strong><img src="' . esc_url($group_img) . '" alt="Group Image" class="w-32 h-32 object-cover rounded"></p>';
    // echo '<p><strong>رمز گروه:</strong> <span class="text-red-600">' . esc_html($group_password) . '</span></p>';
    echo '</div>';
    echo '<a href="' . esc_url(home_url('/group-settings')) . '" 
        class="inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
        ⚙️ تنظیمات گروه
      </a>';
    echo '<a href="' . esc_url(home_url('/add-member')) . '" 
        class="fixed bottom-6 right-6 bg-blue-600 text-white w-14 h-14 flex items-center justify-center rounded-full shadow-lg text-3xl hover:bg-blue-700">
        +
      </a>';

    echo '</div>';
} else {
    echo '<p>شما هنوز گروهی ایجاد نکرده‌اید.</p>';
}


// نمایش پیام خطا یا موفقیت
if (!empty($errors)) {
    echo '<div class="bg-red-200 text-red-800 p-3 rounded mb-4">';
    foreach ($errors as $error) {
        echo '<p>' . esc_html($error) . '</p>';
    }
    echo '</div>';
}
if (!empty($success_message)) {
    echo '<div id="success-msg" class="bg-green-200 text-green-800 p-3 rounded mb-4">' . esc_html($success_message) . '</div>';
}



if (is_array($members) && !empty($members)) {
    echo '<div class="bg-white shadow-md rounded p-4 mt-6">';
    echo '<h2 class="text-xl font-bold mb-4">اعضای گروه</h2>';
    echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">';
    foreach ($members as $member_id) {
        $member_data = get_userdata($member_id);
        if ($member_data) {
            $member_name     = esc_html($member_data->first_name);
            $member_lastname = esc_html($member_data->last_name);
            $member_gender   = esc_html(get_user_meta($member_id, 'gender', true));
            $member_img      = esc_html(get_user_meta($member_id, 'profile_image', true));
            $member_points   = esc_html(get_user_meta($member_id, 'points', true));
        }
    ?>

        <div class="bg-gray-50 rounded-lg shadow p-4 text-center member-card" data-member-id="<?php echo $member_id; ?>">
            <form method="post" enctype="multipart/form-data" class="flex flex-col items-center">
                <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">

                <img src="<?php echo $member_img; ?>" alt="<?php echo $member_name; ?>" class="w-24 h-24 mx-auto rounded-full object-cover mb-3 member-img">

                <div class="member-view">
                    <h3 class="text-lg font-semibold"><?php echo $member_name . ' ' . $member_lastname; ?></h3>
                    <p class="text-sm text-gray-600">جنسیت: <?php echo ($member_gender === 'girl' ? 'دختر' : 'پسر'); ?></p>
                    <p class="text-sm text-gray-600">امتیاز: <?php echo $member_points; ?></p>
                    <button type="button" class="bg-blue-500 text-white px-3 py-1 mt-2 rounded edit-btn">ویرایش</button>
                </div>

                <div class="member-edit hidden flex flex-col gap-2 w-full">
                    <input type="text" name="first_name" value="<?php echo $member_name; ?>" class="border p-1 w-full">
                    <input type="text" name="last_name" value="<?php echo $member_lastname; ?>" class="border p-1 w-full">
                    <select name="gender" class="border p-1 w-full">
                        <option value="girl" <?php selected($member_gender, 'girl'); ?>>دختر</option>
                        <option value="boy" <?php selected($member_gender, 'boy'); ?>>پسر</option>
                    </select>
                    <input type="number" name="points" value="<?php echo $member_points; ?>" class="border p-1 w-full">
                    <input type="file" name="profile_image" class="border p-1 w-full">
                    <button type="submit" name="save_member" class="bg-green-500 text-white px-4 py-2 rounded mt-2">ثبت تغییرات</button>
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mt-1 cancel-btn">لغو</button>
                </div>
            </form>
        </div>
<?php }
    echo '</div>';
    echo '</div>';
} else {
    echo '<p class="mt-4 text-gray-600">هنوز عضوی به گروه اضافه نشده است.</p>';
}
echo '<a href="' . esc_url(home_url('/add-task')) . '" 
    class="fixed bottom-6 left-6 bg-green-600 text-white w-14 h-14 flex items-center justify-center rounded-full shadow-lg text-2xl hover:bg-green-700">
    📝
  </a>';
?>
<!-- دکمه ثبت جایزه  -->
<a href="<?php echo esc_url(home_url('/add-reward')); ?>"
    class="fixed top-24 right-6 z-50 bg-pink-500 text-white w-14 h-14 flex items-center justify-center rounded-full shadow-lg text-2xl hover:bg-pink-600 hover:scale-110 transition-transform duration-300">
    🎁
</a>

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
    });

    // بعد از 1 ثانیه پیام مخفی شود
    setTimeout(function() {
        const msg = document.getElementById('success-msg');
        if (msg) {
            msg.style.display = 'none';
        }
    }, 1000);
</script>

<?php
get_footer();
?>