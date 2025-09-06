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

// مقدار پیش‌ فرض تصویر پروفایل اعضا بر اساس جنسیت
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
if (!is_array($members)) $members = [];
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
$tasks         = is_array($tasks) ? $tasks : [];
$rewards       = get_user_meta($member_id, '_member_rewards', true);
$rewards       = is_array($rewards) ? $rewards : [];

// پردازش فرم
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ذخیره تغییرات جوایز
    if (isset($_POST['save_reward']) && !empty($rewards)) {
        $reward_id = $_POST['save_reward'];

        foreach ($rewards as $index => $reward) {
            if ($reward['id'] === $reward_id) {

                // بروزرسانی عنوان و امتیاز
                $rewards[$index]['title'] = sanitize_text_field($_POST['rewards'][$reward_id]['title']);
                $rewards[$index]['points'] = intval($_POST['rewards'][$reward_id]['points']);

                // آپلود تصویر جدید
                if (!empty($_FILES['rewards']['name'][$reward_id]['image'])) {
                    $file_array = [
                        'name'     => $_FILES['rewards']['name'][$reward_id]['image'],
                        'type'     => $_FILES['rewards']['type'][$reward_id]['image'],
                        'tmp_name' => $_FILES['rewards']['tmp_name'][$reward_id]['image'],
                        'error'    => $_FILES['rewards']['error'][$reward_id]['image'],
                        'size'     => $_FILES['rewards']['size'][$reward_id]['image'],
                    ];

                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    require_once(ABSPATH . 'wp-admin/includes/media.php');
                    require_once(ABSPATH . 'wp-admin/includes/image.php');

                    $upload = wp_handle_upload($file_array, ['test_form' => false]);

                    if (!empty($upload['url'])) {
                        $rewards[$index]['image'] = esc_url($upload['url']);
                    } else {
                        $errors[] = 'مشکلی در آپلود تصویر جایزه پیش آمد.';
                    }
                }

                break;
            }
        }

        // ذخیره جوایز به user_meta
        update_user_meta($member_id, '_member_rewards', $rewards);
        if (empty($errors)) {
            $success_message = 'تغییرات جایزه با موفقیت ذخیره شد.';
        }
    }


    // ذخیره تغییرات وظایف
    if (isset($_POST['save_task'])) {
        $task_id = $_POST['save_task'];

        foreach ($tasks as $index => $task) {
            if ($task['id'] === $task_id) {
                // دریافت اطلاعات از فرم
                $new_title  = sanitize_text_field($_POST['tasks'][$task_id]['title']);
                $new_points = intval($_POST['tasks'][$task_id]['points']);
                $new_done   = intval($_POST['tasks'][$task_id]['done']);

                $was_done = intval($task['done']);
                if ($was_done !== $new_done) {
                    $user_points = intval(get_user_meta($member_id, 'points', true));
                    $user_points += ($new_done === 1 ? $new_points : -$new_points);
                    update_user_meta($member_id, 'points', $user_points);
                }

                $tasks[$index]['title']  = $new_title;
                $tasks[$index]['points'] = $new_points;
                $tasks[$index]['done']   = $new_done;
                break;
            }
        }
        update_user_meta($member_id, '_member_tasks', $tasks);
        $points = get_user_meta($member_id, 'points', true);
        $success_message = 'تغییرات وظیفه با موفقیت ذخیره شد.';
    }

    // حذف وظیفه
    if (isset($_POST['delete_task'])) {
        $task_id = $_POST['delete_task'];
        foreach ($tasks as $index => $task) {
            if ($task['id'] == $task_id) {
                array_splice($tasks, $index, 1);
                update_user_meta($member_id, '_member_tasks', $tasks);
                $success_message = 'وظیفه با موفقیت حذف شد.';
                break;
            }
        }
    }

    // حذف عکس
    if (isset($_POST['del_photo'])) {
        update_user_meta($member_id, 'profile_image', '');
        $profile_image = '';
        $success_message = 'عکس حذف شد.';
    }

    // ذخیره تغییرات اطلاعات عضو
    if (isset($_POST['save_member'])) {
        $first_name = sanitize_text_field($_POST['first_name'] ?? '');
        $last_name = sanitize_text_field($_POST['last_name'] ?? '');
        $gender = sanitize_text_field($_POST['gender'] ?? '');
        $points = intval($_POST['points'] ?? 0);

        if (empty($first_name)) $errors[] = 'لطفاً نام عضو را وارد کنید.';
        if (empty($last_name)) $errors[] = 'لطفاً نام خانوادگی عضو را وارد کنید.';
        if (!in_array($gender, ['girl', 'boy'])) $errors[] = 'لطفاً جنسیت عضو را انتخاب کنید.';
        // گرفتن اطلاعات اعضای گروه و بررسی وجود نام و نام خانوادگی انتخاب شده در اعضای گروه
        if (is_array($members) && !empty($members)) {
            foreach ($members as $m_id) {
                // کاربر جاری
                $member_data = get_userdata($m_id);
                if ($member_data && $m_id != $member_id) {
                    if (
                        strcasecmp($member_data->first_name, $first_name) === 0 &&
                        strcasecmp($member_data->last_name, $last_name) === 0
                    ) {
                        $errors[] = 'این عضو قبلاً در گروه شما ثبت شده است.';
                        break;
                    }
                }
            }
        }

        // بررسی آپلود تصویر جدید
        if (!empty($_FILES['profile_image']['name'])) {
            $file = $_FILES['profile_image'];

            if ($file['size'] > 2 * 1024 * 1024) $errors[] = 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.';
            $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array(mime_content_type($file['tmp_name']), $allowed_types)) $errors[] = 'فرمت تصویر معتبر نیست.';

            if (empty($errors)) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                require_once(ABSPATH . 'wp-admin/includes/image.php');

                $upload = media_handle_upload('profile_image', 0);
                if (!is_wp_error($upload)) {
                    $profile_image = wp_get_attachment_url($upload);
                    update_user_meta($member_id, 'profile_image', $profile_image);
                } else {
                    $errors[] = 'مشکلی در آپلود تصویر پیش آمد.';
                }
            }
        }

        if (empty($errors)) {
            wp_update_user([
                'ID'         => $member_id,
                'first_name' => $first_name,
                'last_name'  => $last_name
            ]);
            update_user_meta($member_id, 'gender', $gender);
            update_user_meta($member_id, 'points', $points);
            $success_message = 'تغییرات با موفقیت ذخیره شد.';
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
}

// نمایش پیام‌ها
if (!empty($errors)) {
    // دوباره از دیتابیس مقدار اصلی رو بخون
    $member_data   = get_userdata($member_id);
    $first_name    = $member_data->first_name;
    $last_name     = $member_data->last_name;
    $gender        = get_user_meta($member_id, 'gender', true);
    $points        = get_user_meta($member_id, 'points', true);
    $profile_image = get_user_meta($member_id, 'profile_image', true);
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
    <?php if (!empty($rewards) && is_array($rewards)): ?>
        <div class="reward-view mb-5">
            <h2 class="text-lg font-bold mb-4 text-center mt-4">جوایز عضو</h2>
            <ul class="space-y-2">
                <?php foreach ($rewards as $index => $reward): ?>
                    <form method="post" enctype="multipart/form-data" class="flex flex-col items-center">
                        <li class="flex justify-between items-center border-b pb-2" data-reward-index="<?php echo $index; ?>">
                            <div class="reward-view flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <img src="<?php echo esc_url($reward['image']); ?>"
                                        alt="<?php echo esc_attr($reward['title']); ?>"
                                        class="w-24 h-24 mx-auto rounded-full object-cover mb-3 member-img">
                                    <span><?php echo esc_html($reward['title']); ?></span>
                                    <span class="mr-2 text-green-700">(امتیاز: <?php echo esc_html($reward['points']); ?>)</span>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" class="bg-blue-500 text-white px-2 py-1 rounded edit-reward-btn">ویرایش</button>
                                    <button type="submit" name="delete_reward" value="<?php echo esc_attr($reward['id']); ?>" class="bg-red-500 text-white px-2 py-1 rounded del-task-btn">حذف</button>
                                </div>
                            </div>
                            <!-- فرم ویرایش جایزه -->
                            <div class="reward-edit hidden flex flex-col gap-1 mt-2">
                                <input type="text" name="rewards[<?php echo esc_attr($reward['id']); ?>][title]" value="<?php echo esc_attr($reward['title']); ?>" class="border p-1 w-full">
                                <input type="number" name="rewards[<?php echo esc_attr($reward['id']); ?>][points]" value="<?php echo esc_attr($reward['points']); ?>" class="border p-1 w-full">
                                <input type="file" name="rewards[<?php echo esc_attr($reward['id']); ?>][image]" class="border p-1 w-full">
                                <button type="submit" name="save_reward" value="<?php echo esc_attr($reward['id']); ?>" class="bg-green-500 text-white px-2 py-1 rounded">ثبت تغییرات</button>
                                <button type="button" class="bg-gray-500 text-white px-2 py-1 rounded cancel-reward-btn">لغو</button>
                            </div>
                        </li>
                    </form>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <p class="mt-4 text-gray-600">هنوز جایزه ای برای این عضو ثبت نشده است.</p>
    <?php endif; ?>
    <div class="bg-gray-50 rounded-lg shadow p-4 text-center member-card max-w-xl mx-auto" data-member-id="<?php echo $member_id; ?>">
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
            <?php foreach ($tasks as $index => $task): ?>
                <form method="post" enctype="multipart/form-data" class="flex flex-col items-center">
                    <li class="flex justify-between items-center border-b pb-2" data-task-index="<?php echo $index; ?>">
                        <div class="task-view flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span><?php echo esc_html($task['title']); ?></span>
                                <span class="mr-2 text-green-700">(امتیاز: <?php echo esc_html($task['points']); ?>)</span>
                                <?php if (!empty($task['done']) && $task['done'] == 1): ?>
                                    <span class="text-green-600 font-semibold">انجام شده ✅</span>
                                <?php else: ?>
                                    <span class="text-red-600 font-semibold">انجام نشده ❌</span>
                                <?php endif; ?>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" class="bg-blue-500 text-white px-2 py-1 rounded edit-task-btn">ویرایش</button>
                                <button type="submit" name="delete_task" value="<?php echo esc_attr($task['id']); ?>" class="bg-red-500 text-white px-2 py-1 rounded del-task-btn">حذف</button>
                            </div>
                        </div>

                        <!-- فرم ویرایش وظیفه -->
                        <div class="task-edit hidden flex flex-col gap-1 mt-2">
                            <input type="text" name="tasks[<?php echo esc_attr($task['id']); ?>][title]" value="<?php echo esc_attr($task['title']); ?>" class="border p-1 w-full">
                            <input type="number" name="tasks[<?php echo esc_attr($task['id']); ?>][points]" value="<?php echo esc_attr($task['points']); ?>" class="border p-1 w-full">
                            <select name="tasks[<?php echo esc_attr($task['id']); ?>][done]" class="border p-1 w-full">
                                <option value="1" <?php selected($task['done'], 1); ?>>انجام شده</option>
                                <option value="0" <?php selected($task['done'], 0); ?>>انجام نشده</option>
                            </select>
                            <button type="submit" name="save_task" value="<?php echo esc_attr($task['id']); ?>" class="bg-green-500 text-white px-2 py-1 rounded">ثبت تغییرات</button>
                            <button type="button" class="bg-gray-500 text-white px-2 py-1 rounded cancel-task-btn">لغو</button>
                        </div>
                    </li>
                </form>
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
        // ویرایش وظایف
        document.querySelectorAll('.edit-task-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                // همه‌ی تسک‌ها رو برگردون به حالت نمایش
                document.querySelectorAll('.task-edit').forEach(function(editBox) {
                    editBox.classList.add('hidden');
                });
                document.querySelectorAll('.task-view').forEach(function(viewBox) {
                    viewBox.classList.remove('hidden');
                });

                const task = btn.closest('li[data-task-index]');
                task.querySelector('.task-view').classList.add('hidden');
                task.querySelector('.task-edit').classList.remove('hidden');
            });
        });
        document.querySelectorAll('.cancel-task-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const task = btn.closest('li[data-task-index]');
                task.querySelector('.task-edit').classList.add('hidden');
                task.querySelector('.task-view').classList.remove('hidden');
            });
        });

        // ویرایش جوایز
        document.querySelectorAll('.edit-reward-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                // همه‌ی جوایز رو برگردون به حالت نمایش
                document.querySelectorAll('.reward-edit').forEach(function(editBox) {
                    editBox.classList.add('hidden');
                });
                document.querySelectorAll('.reward-view').forEach(function(viewBox) {
                    viewBox.classList.remove('hidden');
                });

                const reward = btn.closest('li[data-reward-index]');
                reward.querySelector('.reward-view').classList.add('hidden');
                reward.querySelector('.reward-edit').classList.remove('hidden');
            });
        });
        document.querySelectorAll('.cancel-reward-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const reward = btn.closest('li[data-reward-index]');
                reward.querySelector('.reward-edit').classList.add('hidden');
                reward.querySelector('.reward-view').classList.remove('hidden');
            });
        });

        document.querySelectorAll('.del-reward-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                if (!confirm("آیا مطمئن هستید که می‌خواهید این جایزه حذف شود؟")) e.preventDefault();
            });
        });

        document.querySelectorAll('.del-task-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                if (!confirm("آیا مطمئن هستید که می‌خواهید این وظیفه حذف شود؟")) e.preventDefault();
            });
        });
        document.querySelectorAll('.del-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                const memberName = btn.getAttribute('data-name');
                if (!confirm("آیا مطمئن هستید که می‌خواهید «" + memberName + "» حذف شود؟")) e.preventDefault();
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