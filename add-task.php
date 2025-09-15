<?php
/*
Template Name: Add Task
*/
get_header();

if (!is_user_logged_in()) {
    echo '<p class="text-[#6B4C3B]">لطفاً ابتدا وارد شوید.</p>';
    get_footer();
    exit;
}

$leader = wp_get_current_user();
$leader_id = $leader->ID;

if (! array_intersect(['parent', 'teacher'], (array) $leader->roles)) {
    echo '<p class="text-[#6B4C3B]">شما اجازه دسترسی به این بخش را ندارید.</p>';
    get_footer();
    exit;
}

// گرفتن ایدی اعضای گروه
$members_id = get_user_meta($leader_id, '_group_members', true);
if (!is_array($members_id)) $members_id = [];

$success_message = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $task_title = sanitize_text_field($_POST['task_title'] ?? '');
    $task_desc = sanitize_textarea_field($_POST['task_desc'] ?? '');
    $task_points = intval($_POST['task_points'] ?? 0);
    $selected_members = $_POST['selected_members'] ?? [];

    // اعتبارسنجی
    if (empty($task_title)) $errors[] = 'عنوان وظیفه را وارد کنید.';
    if ($task_points <= 0) $errors[] = 'امتیاز وظیفه باید بیشتر از 0 باشد.';
    if (empty($selected_members)) $errors[] = 'حداقل یک عضو را انتخاب کنید.';

    if (empty($errors)) {
        foreach ($selected_members as $member_id) {
            $member_id = absint($member_id); // مطمئن شدن از عدد بودن id
            $member_tasks = get_user_meta($member_id, '_member_tasks', true);
            if (!is_array($member_tasks)) $member_tasks = [];

            $member_tasks[] = [
                'id' => uniqid(),
                'title' => $task_title,
                'desc' => $task_desc,
                'points' => $task_points,
                'assigned_by' => $leader_id,
                'created_at' => current_time('mysql'),
                'done' => 0
            ];
            update_user_meta($member_id, '_member_tasks', $member_tasks);
        }
        $success_message = '<p id="success-msg" class="font-bold">وظیفه با موفقیت ثبت شد ✅</p>';
        $_POST = [];
    }
}
?>

<main class="max-w-screen-md mx-auto my-12 p-8 rounded-3xl border-4 border-[#f2c57c] relative bg-gradient-to-br from-[#fdfaf6] via-[#fff8f0] to-[#fdfaf6]">

    <!-- عنوان و بخش بالای فرم -->
    <h2 class="text-3xl md:text-4xl font-extrabold mb-6 text-center text-[#6B4C3B] flex items-center justify-center gap-3 drop-shadow-lg">
        🎯 افزودن وظیفه جدید 🧸
    </h2>

    <?php
    // نمایش خطاها در صورت وجود
    if (!empty($errors)) {
        echo '<ul class="bg-[#f2c57c]/30 border-2 border-[#8B5E3C] text-[#6B4C3B] p-4 mb-6 rounded-xl shadow-md">';
        foreach ($errors as $error) {
            echo '<li class="mb-1">⚠️ ' . esc_html($error) . '</li>';
        }
        echo '</ul>';
    }

    // نمایش پیام موفقیت در صورت ثبت موفق
    if ($success_message) {
        echo '<div class="bg-[#f2c57c]/50 border-2 border-[#8B5E3C] text-[#6B4C3B] p-4 mb-6 rounded-xl shadow-md text-center">';
        echo $success_message;
        echo '</div>';
    }
    ?>

    <!-- فرم افزودن وظیفه -->
    <form method="post" class="bg-[#fdfaf6] p-6 rounded-2xl border-2 border-[#f2c57c] shadow-inner flex flex-col gap-4 relative z-10" enctype="multipart/form-data">

        <!-- عنوان وظیفه -->
        <label class="block">
            <span class="text-[#6B4C3B] font-bold mb-2 inline-block">🏆 عنوان وظیفه</span>
            <input type="text" name="task_title" value="<?php echo esc_attr($_POST['task_title'] ?? '') ?>" class="w-full p-3 border-2 border-[#f2c57c] rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#f2c57c] transition-transform" placeholder="مثلاً: انجام تکالیف ریاضی" required>
        </label>

        <!-- توضیحات وظیفه -->
        <label class="block">
            <span class="text-[#6B4C3B] font-bold mb-2 inline-block">✍️ توضیحات وظیفه</span>
            <textarea name="task_desc" class="w-full p-3 border-2 border-[#f2c57c] rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#f2c57c] transition-transform" placeholder="اختیاری"><?php echo esc_textarea($_POST['task_desc'] ?? '') ?></textarea>
        </label>

        <!-- امتیاز وظیفه -->
        <label class="block">
            <span class="text-[#6B4C3B] font-bold mb-2 inline-block">⭐ امتیاز وظیفه</span>
            <input type="number" name="task_points" class="w-full p-3 border-2 border-[#f2c57c] rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#f2c57c] transition-transform" min="0" placeholder="مثلاً: 5" value="<?php echo esc_attr($_POST['task_points'] ?? '') ?>" required>
        </label>

        <!-- انتخاب اعضا -->
        <label class="block text-[#6B4C3B] font-bold">👥 اعمال برای کدام اعضا:</label>
        <button type="button" id="toggle-members" class="w-max bg-[#f2c57c] text-[#6B4C3B] px-3 py-2 rounded-xl shadow-md hover:bg-[#8B5E3C] hover:text-white transition transform mb-2">
            ✨ انتخاب همه
        </button>

        <!-- لیست اعضا -->
        <div class="flex flex-col gap-2 border-2 border-[#f2c57c] rounded-2xl p-4 max-h-40 overflow-y-auto bg-[#fdfaf6]">
            <?php foreach ($members_id as $member_id) {
                $member_data = get_userdata($member_id);
                if ($member_data) {
            ?>
                    <label class="flex items-center gap-3 cursor-pointer hover:bg-[#f2c57c]/30 rounded-lg p-2">
                        <input type="checkbox" name="selected_members[]" value="<?php echo esc_attr($member_id); ?>" class="accent-[#f2c57c] w-4 h-4">
                        <span class="text-[#6B4C3B]"><?php echo esc_html($member_data->first_name . ' ' . $member_data->last_name); ?></span>
                    </label>
            <?php
                }
            }
            ?>
            <!-- پیام در صورت نبود هیچ عضوی -->
            <?php if (empty($members_id)) : ?>
                <p class="text-[#6B4C3B] text-center">هیچ عضوی برای نمایش وجود ندارد.</p>
            <?php endif; ?>
        </div>

        <!-- دکمه‌های ثبت و بازگشت -->
        <div class="flex gap-4 mt-2">
            <button type="submit" name="add_task" class="flex-1 bg-[#f2c57c] text-[#6B4C3B] text-lg font-extrabold py-3 rounded-2xl shadow-lg hover:bg-[#8B5E3C] hover:text-white transition transform">
                 ثبت وظیفه
            </button>
            <a href="<?php echo home_url('/dashboard'); ?>" class="flex-1 text-center bg-[#fdfaf6] border-2 border-[#f2c57c] text-[#6B4C3B] font-bold py-3 rounded-2xl hover:bg-[#f2c57c] hover:text-white transition">
                 بازگشت به داشبورد
            </a>
        </div>
    </form>

</main>

<script>
// دکمه انتخاب همه اعضا
const Btn = document.getElementById('toggle-members');
Btn.addEventListener('click', function() {
    const checkboxes = document.querySelectorAll('input[name="selected_members[]"]');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    checkboxes.forEach(cb => cb.checked = !allChecked);
});

// پیام موفقیت بعد از 2 ثانیه مخفی شود
setTimeout(function() {
    const msg = document.getElementById('success-msg');
    if (msg) { msg.parentElement.style.display = 'none'; }
}, 2000);
</script>

<style>
    /* انیمیشن‌های ساده کارتونی */
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
    .animate-bounce {
        animation: bounce 3s ease-in-out infinite;
    }

    /* استایل مخصوص موبایل */
    @media (max-width: 640px) {
        main { padding: 18px; }
    }
</style>

<?php
// نمایش فوتر سایت
get_footer();
?>
