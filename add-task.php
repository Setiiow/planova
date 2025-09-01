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

$user = wp_get_current_user();
<<<<<<< HEAD
$user_id = $user->ID;

=======
>>>>>>> c25aafcf9ef71c2a3a29f978d32cfabc81b5b358
if (! array_intersect(['parent', 'teacher'], (array) $user->roles)) {
    echo '<p class="text-red-500">شما اجازه دسترسی به این بخش را ندارید.</p>';
    get_footer();
    exit;
}

<<<<<<< HEAD
// گرفتن اعضای گروه
$members = get_user_meta($user_id, '_group_members', true);
if (!is_array($members)) $members = [];

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
        foreach ($selected_members as $member_index) {
            // گرفتن user ID عضو از آرایه members
            $member_id = $members[$member_index]['id'] ?? null;
            if ($member_id) {
                $member_tasks = get_user_meta($member_id, '_member_tasks', true);
                if (!is_array($member_tasks)) $member_tasks = [];

                $member_tasks[] = [
                    'title' => $task_title,
                    'desc' => $task_desc,
                    'points' => $task_points,
                    'assigned_by' => $user_id,
                    'created_at' => current_time('mysql')
                ];

                update_user_meta($member_id, '_member_tasks', $member_tasks);
                $success_message = '<p class="text-green-600">وظیفه با موفقیت ثبت شد ✅</p>';
                $_POST = [];
            }
        }
    }
}

=======
$user_id = $user->ID; 

// حالا می‌تونی $user_id رو برای گرفتن اعضا استفاده کنی
$members = get_user_meta($user_id, '_group_members', true);
>>>>>>> c25aafcf9ef71c2a3a29f978d32cfabc81b5b358
?>
<main class="max-w-screen-md mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">افزودن وظیفه جدید</h2>

    <form method="post" class="bg-white p-4 rounded shadow-md flex flex-col gap-4">

<<<<<<< HEAD
        <label>عنوان وظیفه:
            <input type="text" name="task_title" value="<?php echo esc_attr($_POST['task_title'] ?? '') ?>" class="border p-2 w-full" placeholder="مثلاً: انجام تکالیف ریاضی" required>
        </label>

        <label>توضیحات وظیفه:
            <textarea name="task_desc" class="border p-2 w-full" placeholder="اختیاری"><?php echo esc_textarea($_POST['task_desc'] ?? '') ?></textarea>
        </label>

=======
        <!-- عنوان وظیفه -->
        <label>عنوان وظیفه:
            <input type="text" name="task_title" class="border p-2 w-full" placeholder="مثلاً: انجام تکالیف ریاضی" required>
        </label>

        <!-- توضیحات وظیفه -->
        <label>توضیحات وظیفه:
            <textarea name="task_desc" class="border p-2 w-full" placeholder="توضیحات بیشتر درباره وظیفه (اختیاری)"></textarea>
        </label>

        <!-- امتیاز وظیفه -->
>>>>>>> c25aafcf9ef71c2a3a29f978d32cfabc81b5b358
        <label>امتیاز وظیفه:
            <input type="number" name="task_points" class="border p-2 w-full" min="0" placeholder="مثلاً: 5" required>
        </label>

        <!-- انتخاب اعضای گروه -->
        <label>اعمال برای کدام اعضا:</label>
        <div class="flex flex-col gap-2 border p-2 rounded max-h-40 overflow-y-auto">
            <?php
<<<<<<< HEAD
=======
            $members = get_user_meta($user_id, '_group_members', true);
>>>>>>> c25aafcf9ef71c2a3a29f978d32cfabc81b5b358
            if (is_array($members)) {
                foreach ($members as $index => $member) {
                    $member_name = esc_html($member['name'] ?? '');
                    $member_lastname = esc_html($member['lastname'] ?? '');
<<<<<<< HEAD
                    echo '<label><input type="checkbox" name="selected_members[]" value="' . $index . '"> '
                        . $member_name . ' ' . $member_lastname . '</label>';
=======
                    echo '<label><input type="checkbox" name="selected_members[]" value="' . $index . '"> ' 
                         . $member_name . ' ' . $member_lastname . '</label>';
>>>>>>> c25aafcf9ef71c2a3a29f978d32cfabc81b5b358
                }
            } else {
                echo '<p>هنوز عضوی اضافه نشده است.</p>';
            }
            ?>
        </div>
<<<<<<< HEAD

=======
        
>>>>>>> c25aafcf9ef71c2a3a29f978d32cfabc81b5b358
        <button type="submit" name="add_task" class="bg-blue-500 text-white p-2 rounded">
            ثبت وظیفه
        </button>
    </form>
</main>

<?php
get_footer();
?>