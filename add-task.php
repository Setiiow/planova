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

$user_id = $user->ID; 
$user = wp_get_current_user();
if (! array_intersect(['parent', 'teacher'], (array) $user->roles)) {
    echo '<p class="text-red-500">شما اجازه دسترسی به این بخش را ندارید.</p>';
    get_footer();
    exit;
}


$members = get_user_meta($user_id, '_group_members', true);
?>
<main class="max-w-screen-md mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">افزودن وظیفه جدید</h2>

    <form method="post" class="bg-white p-4 rounded shadow-md flex flex-col gap-4">

        <label>عنوان وظیفه:
            <input type="text" name="task_title" class="border p-2 w-full" placeholder="مثلاً: انجام تکالیف ریاضی" required>
        </label>

        <label>توضیحات وظیفه:
            <textarea name="task_desc" class="border p-2 w-full" placeholder="توضیحات بیشتر درباره وظیفه (اختیاری)"></textarea>
        </label>

        <label>امتیاز وظیفه:
            <input type="number" name="task_points" class="border p-2 w-full" min="0" placeholder="مثلاً: 5" required>
        </label>

        <!-- انتخاب اعضای گروه -->
        <label>اعمال برای کدام اعضا:</label>
        <div class="flex flex-col gap-2 border p-2 rounded max-h-40 overflow-y-auto">
            <?php
            $members = get_user_meta($user_id, '_group_members', true);
            if (is_array($members)) {
                foreach ($members as $index => $member) {
                    $member_name = esc_html($member['name'] ?? '');
                    $member_lastname = esc_html($member['lastname'] ?? '');
                    echo '<label><input type="checkbox" name="selected_members[]" value="' . $index . '"> ' 
                         . $member_name . ' ' . $member_lastname . '</label>';
                }
            } else {
                echo '<p>هنوز عضوی اضافه نشده است.</p>';
            }
            ?>
        </div>

        <button type="submit" name="add_task" class="bg-blue-500 text-white p-2 rounded">
            ثبت وظیفه
        </button>
    </form>
</main>

<?php
get_footer();
?>