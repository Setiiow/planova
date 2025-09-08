<?php
/* Template Name: Member Dashboard */

if (! is_user_logged_in()) {
    // کاربر وارد نشده -> ریدایرکت به صفحه ورود یا نمایش پیام
    wp_redirect(
        wp_redirect(home_url('/member-login'))
    );
    exit;
}

get_header();

// گرفتن ایدی کاربر جاری
$member_id = get_current_user_id();

// متاهای دلخواه
$first_name    = get_user_meta($member_id, 'first_name', true);
$last_name     = get_user_meta($member_id, 'last_name', true);
$gender        = get_user_meta($member_id, 'gender', true);
$points_raw    = get_user_meta($member_id, 'points', true);
$points        = ($points_raw === '') ? 0 : intval($points_raw); // مقدار پیش‌فرض 0
$profile_image = get_user_meta($member_id, 'profile_image', true);
// گرفتن جوایز عضو
$rewards = get_user_meta($member_id, '_member_rewards', true);
// گرفتن وظایف عضو
$tasks = get_user_meta($member_id, '_member_tasks', true);
if (!is_array($tasks)) $tasks = [];

// بررسی تغییر وضعیت انجام وظایف
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_tasks'])) {
    $done_tasks = $_POST['done_tasks'] ?? [];

    $points_change = 0; // تغییرات امتیاز

    foreach ($tasks as $i => $task) {
        $was_done = $task['done'];
        $is_done_now = in_array($i, $done_tasks) ? 1 : 0;

        // اگر وضعیت تغییر کرده
        if ($was_done != $is_done_now) {
            $tasks[$i]['done'] = $is_done_now;
            if ($is_done_now) {
                // اگر تازه انجام شده -> امتیاز اضافه شود
                $points_change += intval($task['points']);
            } else {
                // اگر تیک برداشته شده -> امتیاز کم شود
                $points_change -= intval($task['points']);
            }
        }
    }
    // بروزرسانی وظایف
    update_user_meta($member_id, '_member_tasks', $tasks);

    // بروزرسانی امتیاز کل
    $points += $points_change;
    update_user_meta($member_id, 'points', $points);

    echo '<p id="success-msg" class="text-green-600 mb-4">وضعیت وظایف و امتیازها به‌روزرسانی شد ✅</p>';
}
?>

<main class="max-w-screen-md mx-auto p-4">
    <div class="bg-white p-6 rounded shadow">
        <div class="flex items-center gap-4">
            <img src="<?php echo esc_url($profile_image); ?>" alt="<?php echo esc_attr($first_name . ' ' . $last_name); ?>" class="w-24 h-24 rounded-full object-cover">
            <div>
                <h1 class="text-2xl font-bold"><?php echo esc_html($first_name . ' ' . $last_name); ?></h1>
                <p class="text-sm text-gray-600">جنسیت: <?php echo $p_gender = ($gender === 'girl') ? 'دختر' : 'پسر'; ?></p>
            </div>
        </div>

        <div class="mt-6">
            <p>امتیاز: <strong><?php echo esc_html($points); ?></strong></p>
        </div>
    </div>

    <h2 class="text-xl font-bold my-4">جوایز من</h2>
    <?php if (!empty($rewards) && is_array($rewards)): ?>
        <div class="grid grid-cols-2 gap-4">
            <?php foreach ($rewards as $reward): ?>
                <div class="bg-white p-4 rounded shadow text-center">
                    <img src="<?php echo esc_url($reward['image']); ?>"
                        alt="<?php echo esc_attr($reward['title']); ?>"
                        class="w-24 h-24 mx-auto rounded-full object-cover">
                    <h3 class="mt-2 font-bold"><?php echo esc_html($reward['title']); ?></h3>
                    <p class="text-sm text-gray-600"><?php echo intval($reward['points']); ?> امتیاز</p>
                    <?php if ($points >= intval($reward['points'])): ?>
                        <div class="mt-2 p-2 rounded bg-green-100 text-green-700 font-semibold">
                            🎉 تبریک! این جایزه برایت باز شد!
                        </div>
                    <?php else: ?>
                        <div class="mt-2 p-2 rounded bg-yellow-100 text-yellow-700 font-semibold">
                            🔒 هنوز به این جایزه دسترسی نداری
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>فعلاً جایزه‌ای برای شما ثبت نشده است.</p>
    <?php endif; ?>

    <h2 class="text-xl font-bold my-4">وظایف من</h2>
    <form method="post" class="bg-white p-4 rounded shadow-md flex flex-col gap-4">
        <?php if (empty($tasks)) : ?>
            <p>فعلاً وظیفه‌ای برای شما تعریف نشده است.</p>
        <?php else: ?>
            <?php foreach ($tasks as $index => $task): ?>
                <div class="border p-3 rounded flex items-start gap-4">
                    <input type="checkbox" name="done_tasks[]" value="<?php echo $index; ?>" <?php checked($task['done'], 1); ?>>
                    <div>
                        <h3 class="font-bold"><?php echo esc_html($task['title']); ?> (<?php echo esc_html($task['points']); ?> امتیاز)</h3>
                        <?php if (!empty($task['desc'])): ?>
                            <p><?php echo esc_html($task['desc']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit" name="update_tasks" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">بروزرسانی وضعیت</button>
        <?php endif; ?>
    </form>

</main>

<script>
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