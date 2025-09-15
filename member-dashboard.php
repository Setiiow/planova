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


    echo '<div id="success-msg" 
            class="w-full max-w-lg mx-auto text-center 
                   bg-gradient-to-r from-[#d4edda] via-[#c3e6cb] to-[#d4edda] 
                   text-[#155724] font-semibold 
                   px-6 py-4 rounded-2xl mt-6
                   shadow-lg border border-[#b2dfbc] 
                   flex items-center justify-center gap-2
                   animate-fade-in-down">
        <span>وضعیت وظایف و امتیازها به‌روزرسانی شد</span> ✅
      </div>';
}
?>
<div class="w-full text-center my-8 px-3 sm:px-4 md:px-4">
    <h1 class="inline-block 
             bg-gradient-to-r from-[#fff8f0] via-[#f5f0e6] to-[#fff8f0] 
             text-[#6B4C3B] text-2xl sm:text-3xl md:text-4xl font-extrabold 
             px-8 py-4 rounded-2xl shadow-lg tracking-wide 
             transition-all duration-500 
             hover:scale-105 hover:shadow-xl hover:text-[#8B5E3C]">
        ✨ ماجراجویی امروزت اینجاست
    </h1>
    <p class="mt-4 text-[#6B4C3B] text-base sm:text-lg font-semibold 
            transition-all duration-500 hover:text-[#8B5E3C]">
        آماده‌ای؟ وظایف و جایزه‌هات منتظرتن! 🚀
    </p>
</div>

<!-- کارت عضو بالای داشبورد با دو بخش و نوارهای سمت راست -->
<section class="mt-8 mb-45 flex justify-center px-4 sm:px-6 relative">
    <div class="w-full max-w-4xl bg-gradient-to-br from-[#fff8f0] to-[#fff3e8] 
            rounded-3xl shadow-2xl backdrop-blur-sm 
            p-6 sm:p-8 flex flex-col md:flex-row 
            items-center md:items-stretch gap-6
            transform transition-all duration-500 hover:scale-[1.02] hover:shadow-3xl relative
            mx-4 sm:mx-6 md:mx-0">

        <!-- سمت چپ: عکس عضو -->
        <div class="w-full md:w-1/2 flex items-center justify-center mb-6 md:mb-0">
            <div class="w-36 h-36 sm:w-44 sm:h-44 md:w-48 md:h-48 
                bg-[#fff0e0] rounded-2xl shadow-md flex items-center justify-center 
                overflow-hidden transition-transform duration-300 hover:scale-105">
                <img src="<?php echo esc_url($profile_image ? $profile_image : 'https://via.placeholder.com/150'); ?>"
                    alt="<?php echo esc_attr($first_name . ' ' . $last_name); ?>"
                    class="w-full h-full object-cover rounded-2xl">
            </div>
        </div>

        <!-- سمت راست: نوارها -->
        <div class="w-full md:w-1/2 flex flex-col items-center md:items-start justify-center gap-4 mt-4 md:mt-0
                    mx-auto md:mx-0">
            <!-- نوار نام -->
            <div class="w-full max-w-xs sm:max-w-sm md:max-w-md text-center md:text-right">
                <div class="bg-[#f2c57c]/50 shadow-md rounded-xl px-4 sm:px-6 py-3 w-full hover:shadow-lg transition">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#6B4C3B] hover:text-[#8B5E3C] transition-colors">
                        <?php echo esc_html($first_name . ' ' . $last_name); ?>
                    </h2>
                </div>
            </div>

            <!-- نوار جنسیت -->
            <div class="w-full max-w-xs sm:max-w-sm mb-8 lg:mb-4 md:mb-8 sm:mb-10 md:max-w-md text-center md:text-right">
                <div class="bg-[#f2c57c]/50 shadow-md rounded-xl px-4 sm:px-6 py-3 w-full hover:shadow-lg transition">
                    <p class="text-base sm:text-lg font-medium text-[#6B4C3B]">
                        <strong class="block text-sm sm:text-base text-[#8B5E3C]">جنسیت</strong>
                        <?php echo ($gender === 'girl') ? 'دختر' : 'پسر'; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>



    <!-- تصویر آویزون از پایین کارت -->
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/rocket.png"
        alt="rocket"
        class="absolute bottom-[-70px] rotate-25 left-1/2 -translate-x-1/2 w-32 h-23 w-35 sm:h-25 md:w-40 md:h-32 object-contain">

    <!-- ستاره زیر تصویر آویزون (سمت چپ) -->
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/star.png"
        alt="star"
        class="absolute bottom-[-110px] left-[80%] lg:left-[35%] md:left-[30%] sm:left-[70%] -translate-x-1/2 w-15 h-15 z-30 animate-bounce">

    <!-- ستاره زیر تصویر آویزون (سمت راست) -->
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/star.png"
        alt="star"
        class="absolute bottom-[-110px] left-[20%] lg:left-[68%] md:left-[70%] sm:left-[30%] -translate-x-1/2 w-15 h-15 z-30 animate-bounce">

    <!-- تصویر وسط پایین‌تر از ستاره‌ها با امتیاز (ستاره‌ها بالای این المان خواهند بود) -->
    <div class="absolute bottom-[-180px] left-1/2 -translate-x-1/2 w-30 h-30 flex items-center justify-center z-10 pointer-events-none">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/point.png"
            alt="point"
            class="w-[180px] h-[180px] object-contain">
        <div class="absolute inset-0 flex flex-col -mb-5 items-center justify-center text-white font-bold text-sm sm:text-base drop-shadow-lg pointer-events-none">
            <span>امتیاز</span>
            <span class="text-lg sm:text-2xl"><?php echo esc_html($points); ?></span>
        </div>
    </div>

</section>


<div class="w-full max-w-4xl mx-auto my-12 px-4 sm:px-6">
    <div class="flex flex-col lg:flex-row gap-6 items-start">

        <!-- کارت وظایف -->
        <div class="relative w-full lg:flex-1 bg-gradient-to-br from-[#fff8f0] to-[#fff3e8] rounded-3xl shadow-2xl p-6 sm:p-8 transform transition-all duration-500 hover:scale-[1.02] hover:shadow-3xl">

            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#6B4C3B] mb-4 text-center relative">
                وظایف من
                <span class="block w-16 h-1 bg-[#f2c57c] mx-auto mt-2 rounded-full"></span>
            </h2>

            <?php if (empty($tasks)) : ?>
                <p class="text-center bg-[#f2c57c]/25 text-[#8B5E3C] font-semibold text-base sm:text-lg px-4 py-3 rounded-xl shadow-md">
                    فعلاً وظیفه‌ای نداری، آماده باش برای ماجراجویی بعدی!
                </p>
            <?php else: ?>
                <div class="flex flex-col gap-4">
                    <?php foreach ($tasks as $index => $task): ?>
                        <div class="flex items-center gap-4 bg-[#fff3e8] rounded-3xl shadow-md p-3 sm:p-4 hover:shadow-xl transition transform hover:-translate-y-1">
                            <!-- چک‌ باکس -->
                            <input type="checkbox" name="done_tasks[]" value="<?php echo $index; ?>" <?php checked($task['done'], 1); ?> class="w-5 h-5 accent-[#f2c57c] mt-1">

                            <!-- عنوان + توضیح + امتیاز -->
                            <div class="flex-1 flex flex-col min-w-0">
                                <!-- خط عنوان + امتیاز -->
                                <div class="flex justify-between items-center">
                                    <h3 class="font-bold text-[#6B4C3B] text-sm sm:text-base truncate">
                                        <?php echo esc_html($task['title']); ?>
                                    </h3>
                                    <span class="text-sm sm:text-base font-bold text-[#6B4C3B] flex-shrink-0">
                                        <?php echo esc_html($task['points']); ?> ⭐
                                    </span>
                                </div>

                                <!-- توضیح -->
                                <?php if (!empty($task['desc'])): ?>
                                    <p class="text-xs text-[#8B5E3C] truncate mt-1">
                                        <?php echo esc_html($task['desc']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" name="update_tasks" class="bg-[#f2c57c] text-[#6B4C3B] font-bold px-6 py-3 rounded-2xl shadow-md hover:shadow-xl transition mt-4 w-full">
                    بروزرسانی وضعیت
                </button>
            <?php endif; ?>
        </div>

        <!-- نمایش جوایز -->
        <div class="relative w-full lg:w-1/2 flex-shrink-0 bg-gradient-to-br from-[#fff8f0] to-[#fff3e8] rounded-3xl shadow-2xl p-6 sm:p-8 mt-5 sm:mt-5 md:mt-5 lg:mt-0 transform transition-all duration-500 hover:scale-[1.02] hover:shadow-3xl">

            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#6B4C3B] mb-4 text-center relative">
                جوایز من
                <span class="block w-16 h-1 bg-[#f2c57c] mx-auto mt-2 rounded-full"></span>
            </h2>
                                    
            <?php if (!empty($rewards) && is_array($rewards)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php foreach ($rewards as $reward): ?>
                        <div class="flex flex-col items-center text-center p-4 bg-[#fff8f0] rounded-3xl shadow-lg transition transform hover:-translate-y-2 hover:shadow-2xl">
                            <div class="w-20 h-20 rounded-full overflow-hidden mb-2">
                                <img src="<?php echo esc_url($reward['image']); ?>" alt="<?php echo esc_attr($reward['title']); ?>" class="w-full h-full object-cover rounded-full">
                            </div>
                            <h3 class="text-sm font-bold text-[#6B4C3B] truncate w-full"><?php echo esc_html($reward['title']); ?></h3>
                            <p class="text-xs text-[#8B5E3C] mt-1 font-medium truncate w-full"><?php echo intval($reward['points']); ?>⭐</p>
                            <div class="mt-2 text-xs rounded-full <?php echo ($points >= intval($reward['points'])) ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'; ?> font-semibold px-2 py-1 shadow-md w-full text-center">
                                <?php echo ($points >= intval($reward['points'])) ? 'باز شد' : 'قفل'; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center bg-[#f2c57c]/25 text-[#8B4C3B] font-semibold text-base sm:text-lg px-4 py-3 rounded-xl shadow-md">
                    فعلا جایزه‌ای برات ثبت نشده، اما ادامه بده! جایزه‌های هیجان‌انگیزی در راهه!
                </p>
            <?php endif; ?>
        </div>

    </div>
</div>





<script>
    // بعد از 3 ثانیه پیام مخفی شود
    setTimeout(function() {
        const msg = document.getElementById('success-msg');
        if (msg) {
            msg.style.display = 'none';
        }
    }, 3000);
</script>

<?php
get_footer();
?>