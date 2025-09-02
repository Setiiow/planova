<?php
/*
Template Name: Add Task
*/
get_header();


if (!is_user_logged_in()) {
    echo '<p class="text-red-500">لطفاً ابتدا وارد شوید.</p>';
    get_footer();
    exit;
}

$leader = wp_get_current_user();
$leader_id = $leader->ID;

if (! array_intersect(['parent', 'teacher'], (array) $leader->roles)) {
    echo '<p class="text-red-500">شما اجازه دسترسی به این بخش را ندارید.</p>';
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

            // گرفتن وظایف قبلی عضو
            $member_tasks = get_user_meta($member_id, '_member_tasks', true);
            if (!is_array($member_tasks)) $member_tasks = [];


            $member_tasks[] = [
                'title' => $task_title,
                'desc' => $task_desc,
                'points' => $task_points,
                'assigned_by' => $leader_id,
                'created_at' => current_time('mysql')
            ];
            update_user_meta($member_id, '_member_tasks', $member_tasks);
        }
        $success_message = '<p id="success-msg" class="text-green-600">وظیفه با موفقیت ثبت شد ✅</p>';
        $_POST = [];
    }
}

?>

<main class="max-w-screen-md mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">افزودن وظیفه جدید</h2>

    <?php
    if (!empty($errors)) {
        echo '<ul class="text-red-500 mb-4">';
        foreach ($errors as $error) {
            echo '<li>' . esc_html($error) . '</li>';
        }
        echo '</ul>';
    }

    if ($success_message) {
        echo $success_message;
    }
    ?>

    <form method="post" class="bg-white p-4 rounded shadow-md flex flex-col gap-4">

        <label>عنوان وظیفه:
            <input type="text" name="task_title" value="<?php echo esc_attr($_POST['task_title'] ?? '') ?>" class="border p-2 w-full" placeholder="مثلاً: انجام تکالیف ریاضی" required>
        </label>

        <label>توضیحات وظیفه:
            <textarea name="task_desc" class="border p-2 w-full" placeholder="اختیاری"><?php echo esc_textarea($_POST['task_desc'] ?? '') ?></textarea>
        </label>

        <label>امتیاز وظیفه:
            <input type="number" name="task_points" class="border p-2 w-full" min="0" placeholder="مثلاً: 5" required>
        </label>

        <!-- انتخاب اعضای گروه -->
        <label>اعمال برای کدام اعضا:</label>
        <button type="button" id="toggle-members" class="bg-yellow-500 text-white px-2 py-1 rounded mb-2 hover:bg-yellow-600">
            انتخاب همه
        </button>
        <div class="flex flex-col gap-2 border p-2 rounded max-h-40 overflow-y-auto">
            <?php foreach ($members_id as $member_id) {
                $member_data = get_userdata($member_id); // اطلاعات کامل کاربر
                if ($member_data) {
            ?>
                    <label>
                        <input type="checkbox" name="selected_members[]" value="<?php echo esc_attr($member_id); ?>">
                        <?php echo esc_html($member_data->first_name . ' ' . $member_data->last_name); ?>
                    </label>
            <?php
                }
            }
            ?>
        </div>
        <div class="flex gap-4">
            <button type="submit" name="add_task" class="bg-blue-500 text-white p-2 rounded">
                ثبت وظیفه
            </button>
            <a href="<?php echo home_url('/dashboard'); ?>" class="bg-gray-500 text-white px-4 py-2 rounded">
                بازگشت به داشبورد
            </a>
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