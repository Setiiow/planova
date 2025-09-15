<?php
/*
Template Name: Add Reward
*/

if (!is_user_logged_in()) {
    wp_die('لطفاً ابتدا وارد شوید.');
}

$leader = wp_get_current_user();
$leader_id = $leader->ID;

if (!array_intersect(['parent', 'teacher'], (array) $leader->roles)) {
    wp_die('شما اجازه دسترسی به این بخش را ندارید.');
}

$default_reward_img  = get_template_directory_uri() . '/assets/images/default-reward.jpeg';
$member_img_url = $default_reward_img;

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

    $reward_type = (count($selected_members) === count($members_id)) ? 1 : 2;

    if (empty($errors)) {
        foreach ($selected_members as $member_id) {
            $member_id = absint($member_id);
            $member_rewards = get_user_meta($member_id, '_member_rewards', true);
            if (!is_array($member_rewards)) $member_rewards = [];

            $member_rewards[] = [
                'id' => uniqid(),
                'title' => $reward_title,
                'points' => $reward_points,
                'assigned_by' => $leader_id,
                'type' => $reward_type,
                'image' => $member_img_url,
                'created_at' => current_time('mysql')
            ];

            update_user_meta($member_id, '_member_rewards', $member_rewards);
        }

        wp_redirect(add_query_arg('reward_added', '1', get_permalink()));
        exit;
    }
}

get_header();
?>

<!-- بارگذاری کتابخانه TailwindCSS از CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    // تنظیمات سفارشی برای رنگ‌ها در Tailwind
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primaryBrown: '#6B4C3B',   // رنگ اصلی قهوه‌ای
                    secondaryBrown: '#8B5E3C', // رنگ قهوه‌ای تیره‌تر
                    softYellow: '#f2c57c',     // زرد ملایم
                    creamBg: '#fdfaf6',        // پس‌زمینه کرمی
                    beigeBg: '#fff8f0'         // پس‌زمینه بژ
                }
            }
        }
    }
</script>

<main class="max-w-screen-md mx-auto my-10 p-6 bg-beigeBg rounded-3xl shadow-2xl border-4 border-softYellow/50">
    <!-- عنوان اصلی صفحه -->
    <h2 class="text-3xl font-extrabold mb-6 text-center text-primaryBrown">
        🎁 ثبت جایزه جدید 🎉
    </h2>

    <!-- نمایش خطاها (در صورتی که وجود داشته باشند) -->
    <?php if (!empty($errors)) : ?>
        <ul class="text-red-600 mb-4 space-y-1 px-3 py-2 bg-creamBg/90 rounded-lg shadow-inner border-2 border-secondaryBrown/40">
            <?php foreach ($errors as $error) : ?>
                <li>⚠️ <?php echo esc_html($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- نمایش پیام موفقیت بعد از ثبت جایزه -->
    <?php if (isset($_GET['reward_added']) && $_GET['reward_added'] === '1') : ?>
        <p id="success-msg" class="text-green-600 font-semibold mb-4 text-center text-lg">
            ✅ جایزه با موفقیت ثبت شد 🎊
        </p>
    <?php endif; ?>

    <!-- فرم ثبت جایزه جدید -->
    <form method="post" enctype="multipart/form-data" class="flex flex-col gap-4 bg-beigeBg p-6 rounded-2xl shadow-lg border-2 border-softYellow/50">

        <!-- فیلد عنوان جایزه -->
        <label class="text-primaryBrown font-semibold">
            عنوان جایزه:
            <input type="text" name="reward_title" value="<?php echo esc_attr($_POST['reward_title'] ?? '') ?>" 
                   class="w-full border-2 border-softYellow rounded-xl p-3 mt-1 focus:outline-none" 
                   placeholder="مثلاً شکلات خوشمزه 🍫" required>
        </label>

        <!-- فیلد امتیاز جایزه -->
        <label class="text-primaryBrown font-semibold">
            امتیاز جایزه:
            <input type="number" name="reward_points" value="<?php echo esc_attr($_POST['reward_points'] ?? '') ?>" min="0"
                   class="w-full border-2 border-softYellow rounded-xl p-3 mt-1 focus:outline-none"
                   placeholder="مثلاً 50 🏆" required>
        </label>

        <!-- فیلد آپلود تصویر جایزه -->
        <label class="text-primaryBrown font-semibold">
            تصویر جایزه:
            <input type="file" name="member_image" 
                   class="w-full border-2 border-softYellow rounded-xl p-2 mt-1 bg-white">
        </label>

        <!-- انتخاب اعضایی که جایزه برای آن‌ها اعمال شود -->
        <label class="text-primaryBrown font-semibold">اعمال برای کدام اعضا:</label>
        <button type="button" id="toggle-members" 
                class="bg-softYellow text-primaryBrown font-bold px-3 py-2 rounded-xl mb-2 transform transition-transform duration-200 hover:scale-105">
            انتخاب همه
        </button>

        <!-- لیست اعضا با قابلیت انتخاب -->
        <div class="flex flex-col gap-2 border-2 border-softYellow/30 rounded-xl p-3 max-h-48 overflow-y-auto bg-white shadow-inner">
            <?php if (!empty($members_id)) : ?>
                <?php foreach ($members_id as $member_id) :
                    $member_data = get_userdata($member_id);
                    if ($member_data) : ?>
                        <label class="flex items-center gap-2 cursor-pointer rounded-xl p-2">
                            <input type="checkbox" name="selected_members[]" value="<?php echo esc_attr($member_id); ?>" 
                                   class="accent-softYellow w-5 h-5">
                            <span class="text-primaryBrown font-medium"><?php echo esc_html($member_data->first_name . ' ' . $member_data->last_name); ?></span>
                        </label>
                <?php endif; endforeach; ?>
            <?php else: ?>
                <p class="text-secondaryBrown text-center font-medium">هیچ عضوی برای نمایش وجود ندارد 😢</p>
            <?php endif; ?>
        </div>

        <!-- دکمه ثبت جایزه و بازگشت به داشبورد -->
        <div class="flex gap-4 mt-3">
            <button type="submit" name="add_reward" 
                    class="flex-1 bg-primaryBrown text-creamBg font-bold py-3 rounded-xl transform transition-transform duration-200 hover:scale-105">
                ثبت جایزه 🎁
            </button>
            <a href="<?php echo home_url('/dashboard'); ?>" 
               class="flex-1 text-center bg-secondaryBrown text-creamBg font-bold py-3 rounded-xl transform transition-transform duration-200 hover:scale-105">
                بازگشت به داشبورد
            </a>
        </div>
    </form>
</main>

<script>
    // دکمه انتخاب همه اعضا
    const Btn = document.getElementById('toggle-members');
    Btn.addEventListener('click', function() {
        // همه چک ‌باکس‌ها را انتخاب یا لغو انتخاب می‌کند
        const checkboxes = document.querySelectorAll('input[name="selected_members[]"]');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => cb.checked = !allChecked);
    });
</script>

<?php get_footer(); ?> <!-- نمایش فوتر سایت -->
