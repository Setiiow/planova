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

// گرفتن اعضا 
$members = get_user_meta($user_id, '_group_members', true);
if (!is_array($members)) $members = [];

$group = get_user_meta($user_id, '_group_info', true);
if (! is_array($group) || empty($group)) {
    $group = get_user_meta($user_id, '_group_info', true);
    if (! is_array($group)) $group = [];
}

$group_name     = $group['name']     ?? '';
$group_password = $group['password'] ?? '';
$group_img = $group['image'] ?? '';
$leader_name    = get_the_author_meta('display_name', $user_id);

if ($group_name) : ?>
    <div class="relative ">
        <div class="flex flex-wrap pb-2 gap-6 items-center justify-between relative flex-col sm:flex-row">

            <div class="flower relative w-65 h-60 mt-5 sm:w-72 sm:h-72 md:mr-15 lg:w-100 lg:h-90 flex-shrink-0 mx-auto my-auto lg:ml-auto lg:mr-25">

                <!-- دایره‌ها پشت عکس -->
                <div class="absolute w-35 h-35 sm:w-36 sm:h-36 lg:w-48 lg:h-48 
                bg-[#edbabc] rounded-full top-0 left-1/3 opacity-60"></div>

                <div class="absolute w-35 h-35 sm:w-36 sm:h-36 lg:w-48 lg:h-48 
                bg-[#f2c57c] rounded-full bottom-0 left-0 opacity-60"></div>

                <div class="absolute w-35 h-35 sm:w-36 sm:h-36 lg:w-48 lg:h-48 
                bg-[#b48c64] rounded-full bottom-0 right-0 opacity-60"></div>

                <!-- تصویر وسط -->
                <div class="absolute rounded-xl top-1/2 left-1/2 transform 
                -translate-x-1/2 -translate-y-1/2 
                w-28 h-28 sm:w-36 sm:h-36 lg:w-45 lg:h-45 
                overflow-hidden border-4 border-[#6B4C3B] shadow-lg bg-[#6B4C3B]">
                    <img src="<?php echo esc_url($group_img); ?>" alt="Group Image" class="w-full h-full object-cover">
                </div>

                <!-- دایره -->
                <div class="absolute top-[5%] left-[10%] w-6 h-6 bg-blue-500 rounded-full animate-bounce"></div>

                <!-- مربع -->
                <div class="absolute top-[20%] right-[10%] w-6 h-6 bg-green-500 animate-ping"></div>

                <!-- مثلث -->
                <div class="absolute bottom-[15%] left-[20%] w-0 h-0 border-l-[12px] border-r-[12px] border-b-[20px] border-l-transparent border-r-transparent border-b-yellow-500 animate-pulse"></div>

                <!-- ستاره -->
                <div class="absolute bottom-[10%] right-[20%] text-yellow-400 animate-spin">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M12 2l2.9 6.9L22 9.7l-5 4.8L18 22l-6-3.2L6 22l1-7.5-5-4.8 7.1-1L12 2z" />
                    </svg>
                </div>

            </div>
            <!-- متن‌ها  -->
            <div class="flex-1 flex flex-col gap-6 sm:gap-8">
                <p class="relative bg-[#6B4C3B] text-[#f7d59c] lg:mt-5 sm:mt-5 text-2xl sm:ml-5 md:mt-15 md:ml-5 lg:mx-10 md:text-3xl sm:text-xl lg:text-4xl font-bold rounded-full py-3 px-4 sm:px-8 text-center break-words opacity-70"><?php echo esc_html($group_name); ?>
                 <!-- ستاره -->
                <svg class="absolute top-0 left-0 w-12 h-12 text-gray-600 animate-pulse" fill="#eae78eff" viewBox="0 0 24 24">
                <path d="M12 0L14.5 7.5L22.5 8.5L16.5 13L18 21L12 17.5L6 21L7.5 13L1.5 8.5L9.5 7.5L12 0Z" />
                </svg>
            </p>

                <div class="flex flex-col lg:mt-2 gap-4 sm:gap-6 md:ml-15 sm:ml-8">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 lg:mr-20 lg:mr-10">
                        <strong class="bg-[#edbabc] px-4 sm:px-6 py-2 rounded-md text-center whitespace-normal break-words">سرگروه</strong>
                        <p class="font-semibold text-right break-words text-center sm:text-left"><?php echo esc_html($leader_name); ?></p>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 lg:mr-20 lg:mx-30">
                        <strong class="bg-[#edbabc] px-4 sm:px-6 py-2 rounded-md text-center whitespace-normal break-words">رمز گروه</strong>
                        <p class="font-semibold break-words text-center sm:text-left"><?php echo esc_html($group_password); ?></p>
                    </div>
                </div>

                <!-- دکمه تنظیمات گروه -->
                <div class="flex justify-center lg:-mt-1 md:-mt-4">
                    <a href="<?php echo esc_url(home_url('/group-settings')); ?>"
                        class="font-semibold bg-[#f2c57c] text-[#6B4C3B] px-6 py-3 sm:px-8 sm:py-4 rounded-lg shadow-md hover:bg-[#f2c57c] hover:text-[#8B5E3C] hover:shadow-lg transition">
                        ⚙️ تنظیمات گروه
                    </a>
                </div>
            </div>
        </div>

    <?php else : ?>
        <p>شما هنوز گروهی ایجاد نکرده‌اید.</p>
        <?php endif;




    echo '</div>';


    if (is_array($members) && !empty($members)) {
        echo '<div class="bg-[#f2d8c2] shadow-md rounded p-4 mt-15 -mr-4">';
        echo '<div class="flex items-center">';
        echo '<h2 class="bg-[#6B4C3B] text-[#f7d59c] rounded-tl-full -mt-8 rounded-bl-full flex justify-center w-60 p-2 flex py-1 text-xl font-bold mb-4">اعضای گروه</h2>';
        echo '<a href="' . esc_url(home_url('/add-member')) . '" 
        class="bottom-6 right-6 bg-[#f3ead6] text-[#6B4C3B] shadow-[0_4px_10px_rgba(107,76,59,0.3)] hover:shadow-[0_15px_30px_rgba(107,76,59,0.5)] mr-3 -mt-10 w-14 h-14 flex items-center justify-center rounded-full text-3xl hover:bg-[#edbabc]">
        +
        </a>';
        echo '</div>';
        echo '<div class="flex flex-wrap gap-2 sm:gap-3 px-4 sm:px-6">';

        // آرایه رنگ‌ها برای اعضا
        $colors = ['bg-[#ddbea9]', 'bg-[#f3ead6]'];

        foreach ($members as $index => $member_id) {
            $member_data = get_userdata($member_id);
            if ($member_data) {
                $member_name     = esc_html($member_data->first_name);
                $member_lastname     = esc_html($member_data->last_name);
                $member_img      = esc_html(get_user_meta($member_id, 'profile_image', true));
                $member_points   = esc_html(get_user_meta($member_id, 'points', true));
            }

            // انتخاب رنگ از آرایه به صورت چرخشی
            $bg_color = $colors[$index % count($colors)];
        ?>
            <a href="<?php echo home_url('/edit-member?member_id=' . $member_id); ?>"
                class="<?php echo $bg_color; ?> p-2 shadow-[0_4px_10px_rgba(107,76,59,0.3)] rounded-4xl hover:shadow-[0_15px_30px_rgba(107,76,59,0.5)] transition
                    flex flex-col items-center text-center
                    w-20 sm:w-24 md:w-28 lg:w-32 
                    mx-1 sm:mx-3 md:mx-4 
                    my-2">

                <img src="<?php echo $member_img; ?>" alt="<?php echo $member_name; ?>"
                    class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 lg:w-20 lg:h-20 rounded-full object-cover mb-1">

                <h3 class="text-xs sm:text-sm md:text-base lg:text-base font-semibold break-words w-full">
                    <?php echo $member_name . '<br>' . $member_lastname; ?>
                </h3>

                <p class="text-xs sm:text-sm text-gray-600 mt-1">⭐<?php echo $member_points; ?></p>

            </a>
    <?php }
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p class="mt-4 text-gray-600">هنوز عضوی به گروه اضافه نشده است.</p>';
    }
    echo '<a href="' . esc_url(home_url('/add-task')) . '" 
    class="fixed bottom-6 left-6 bg-[#6B4C3B] text-white w-14 h-14 flex items-center justify-center rounded-full shadow-lg text-2xl hover:bg-[#f3eae6]">
    📝
  </a>';
    ?>
    <!-- دکمه ثبت جایزه  -->
    <a href="<?php echo esc_url(home_url('/add-reward')); ?>"
        class="fixed top-24 right-6 z-50 bg-pink-500 text-white w-14 h-14 flex items-center justify-center rounded-full shadow-lg text-2xl hover:bg-pink-600 hover:scale-110 transition-transform duration-300">
        🎁
    </a>

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