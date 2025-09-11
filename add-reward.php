<?php
/*
Template Name: Add Reward
*/

// بررسی ورود کاربر
if (!is_user_logged_in()) {
    wp_die('لطفاً ابتدا وارد شوید.');
}

$leader = wp_get_current_user();
$leader_id = $leader->ID;

// بررسی نقش کاربر
if (!array_intersect(['parent', 'teacher'], (array) $leader->roles)) {
    wp_die('شما اجازه دسترسی به این بخش را ندارید.');
}

// عکس پیشفرض جایزه
$default_reward_img  = get_template_directory_uri() . '/assets/images/default-reward.jpeg';
$member_img_url = $default_reward_img;

// گرفتن اعضای گروه
$members_id = get_user_meta($leader_id, '_group_members', true);
if (!is_array($members_id)) $members_id = [];

$success_message = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_reward'])) {
    $reward_title = sanitize_text_field($_POST['reward_title'] ?? '');
    $reward_points = intval($_POST['reward_points'] ?? 0);
    $selected_members = $_POST['selected_members'] ?? [];

    if (empty($reward_title)) $errors[] = 'عنوان جایزه را وارد کنید.';
    if ($reward_points <= 0) $errors[] = 'امتیاز جایزه باید بیشتر از 0 باشد.';
    if (empty($selected_members)) $errors[] = 'حداقل یک عضو را انتخاب کنید.';

    // آپلود تصویر
    if (!empty($_FILES['member_image']['name'])) {
        $file = $_FILES['member_image'];

        if ($file['size'] > 2 * 1024 * 1024) {
            $errors[] = 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.';
        }

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
            $upload = media_handle_upload('member_image', 0);
            if (!is_wp_error($upload)) {
                $member_img_url = wp_get_attachment_url($upload);
            } else {
                $errors[] = 'مشکلی در آپلود تصویر پیش آمد.';
            }
        }
    }

    // تعیین نوع جایزه
    $reward_type = (count($selected_members) === count($members_id)) ? 1 : 2;

    if (empty($errors)) {
        foreach ($selected_members as $member_id) {
            $member_id = absint($member_id);
            $member_rewards = get_user_meta($member_id, '_member_rewards', true);
            if (!is_array($member_rewards)) $member_rewards = [];

            $member_rewards[] = [
                'id' => uniqid(),      // شناسه یکتا
                'title' => $reward_title,
                'points' => $reward_points,
                'assigned_by' => $leader_id,
                'type' => $reward_type,
                'image' => $member_img_url,
                'created_at' => current_time('mysql')
            ];

            update_user_meta($member_id, '_member_rewards', $member_rewards);
        }

        // ریدایرکت با پیام موفقیت
        wp_redirect(add_query_arg('reward_added', '1', get_permalink()));
        exit;
    }
}

get_header();
?>

<main class="max-w-screen-md mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">ثبت جایزه جدید</h2>

    <?php if (!empty($errors)) : ?>
        <ul class="text-red-500 mb-4">
            <?php foreach ($errors as $error) : ?>
                <li><?php echo esc_html($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif;

    // نمایش پیام موفقیت
    if (isset($_GET['reward_added']) && $_GET['reward_added'] === '1') : ?>
        <p id="success-msg" class="text-green-600 mb-4">جایزه با موفقیت ثبت شد ✅</p>
        <script>
            // بعد از 2 ثانیه پیام مخفی شود
            setTimeout(function() {
                const msg = document.getElementById('success-msg');
                if (msg) {
                    msg.style.display = 'none';
                }
            }, 2000);
        </script>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-md flex flex-col gap-4">
        <label>عنوان جایزه:
            <input type="text" name="reward_title" value="<?php echo esc_attr($_POST['reward_title'] ?? '') ?>" class="border p-2 w-full" required>
        </label>

        <label>امتیاز جایزه:
            <input type="number" name="reward_points" value="<?php echo esc_attr($_POST['reward_points'] ?? '') ?>" min="0" class="border p-2 w-full" min="0" required>
        </label>

        <label>تصویر جایزه:
            <input type="file" name="member_image" class="border p-2 w-full">
        </label>

        <label>اعمال برای کدام اعضا:</label>
        <button type="button" id="toggle-members" class="bg-yellow-500 text-white px-2 py-1 rounded mb-2 hover:bg-yellow-600">
            انتخاب همه
        </button>
        <div class="flex flex-col gap-2 border p-2 rounded max-h-40 overflow-y-auto">
            <?php foreach ($members_id as $member_id) :
                $member_data = get_userdata($member_id);
                if ($member_data) :
            ?>
                    <label>
                        <input type="checkbox" name="selected_members[]" value="<?php echo esc_attr($member_id); ?>">
                        <?php echo esc_html($member_data->first_name . ' ' . $member_data->last_name); ?>
                    </label>
            <?php
                endif;
            endforeach; ?>
        </div>

        <div class="flex gap-4">
            <button type="submit" name="add_reward" class="bg-green-500 text-white p-2 rounded">ثبت جایزه</button>
            <a href="<?php echo home_url('/dashboard'); ?>" class="bg-gray-500 text-white px-4 py-2 rounded">بازگشت به داشبورد</a>
        </div>
    </form>
</main>

<script>
    const Btn = document.getElementById('toggle-members');
    Btn.addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('input[name="selected_members[]"]');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => cb.checked = !allChecked);
    });
</script>

<?php
get_footer();
?>