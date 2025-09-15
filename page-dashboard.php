<?php
/* Template Name: Dashboard */
get_header();

//  بررسی ورود کاربر 
if (! is_user_logged_in()) {
    echo '<p class="text-red-500 text-center mt-24">لطفاً ابتدا وارد شوید.</p>';
    get_footer();
    exit;
}

//  بررسی نقش کاربر 
$user = wp_get_current_user();
if (! array_intersect(['parent', 'teacher'], (array) $user->roles)) {
    echo '<p class="text-red-500 text-center mt-24">شما اجازه دسترسی به این بخش را ندارید.</p>';
    get_footer();
    exit;
}

// گرفتن شناسه کاربر و اطلاعات گروه و اعضا
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

//  بخش نمایش اطلاعات گروه 
// اگر گروه ساخته شده باشد، کارت اطلاعات گروه نمایش داده می شود
if ($group_name) : ?>
    <section class="mt-18 flex justify-center px-4 sm:px-6">
        <div class="max-w-4xl w-full bg-gradient-to-br from-[#fff8f0] to-[#fff3e8] rounded-3xl shadow-2xl backdrop-blur-sm p-6 sm:p-8 flex flex-col md:flex-row items-center gap-6 transform transition-all duration-500 hover:scale-[1.03] hover:shadow-3xl">

            <!-- تصویر گروه -->
            <div class="flex-shrink-0 w-full md:w-auto flex justify-center md:justify-start relative">
                <img src="<?php echo esc_url($group_img); ?>" alt="Group Image" class="w-44 h-44 sm:w-48 sm:h-48 md:w-52 md:h-52 rounded-2xl object-cover shadow-2xl transition-transform duration-300 hover:scale-105">
                <div class="absolute inset-0 rounded-2xl animate-pulse-slow bg-[#f2c57c]/10 -z-10 hidden md:block"></div>
            </div>

            <!-- اطلاعات گروه -->
            <div class="flex-1 text-right mt-4 md:mt-0">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 text-[#6B4C3B] hover:text-[#8B5E3C] transition-colors">
                    <?php echo esc_html($group_name); ?>
                </h1>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div class="bg-[#f2c57c]/25 rounded-xl p-4 backdrop-blur-sm shadow-lg hover:shadow-2xl transition">
                        <strong class="block text-sm sm:text-base">سرگروه</strong>
                        <p class="text-base sm:text-lg font-semibold"><?php echo esc_html($leader_name); ?></p>
                    </div>
                    <div class="bg-[#f2c57c]/25 rounded-xl p-4 backdrop-blur-sm shadow-lg hover:shadow-2xl transition">
                        <strong class="block text-sm sm:text-base">رمز گروه</strong>
                        <p class="text-base sm:text-lg font-semibold"><?php echo esc_html($group_password); ?></p>
                    </div>
                </div>
                <!-- دکمه‌های تنظیمات و افزودن جایزه -->
                <div class="flex gap-3 md:gap-6">
                    <a href="<?php echo esc_url(home_url('/group-settings')); ?>" class="whitespace-nowrap bg-gradient-to-r from-[#f2c57c]/60 via-[#f2d8c2]/40 to-[#f2c57c]/60 text-[#6B4C3B] px-6 py-2 rounded-xl shadow-lg hover:shadow-2xl hover:text-[#8B5E3C] transition font-bold text-lg">
                        تنظیمات
                    </a>
                    <a href="<?php echo esc_url(home_url('/add-reward')); ?>" class="whitespace-nowrap bg-gradient-to-r from-[#f2c57c]/60 via-[#f2d8c2]/40 to-[#f2c57c]/60 text-[#6B4C3B] px-6 py-2 rounded-xl shadow-lg hover:shadow-2xl hover:text-[#8B5E3C] transition font-bold text-lg">
                        افزودن جایزه
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php else : ?>
    <!-- پیام وقتی گروهی ایجاد نشده باشد -->
    <p class="text-center text-[#6B4C3B] mt-24 text-lg">شما هنوز گروهی ایجاد نکرده‌اید.</p>
<?php endif; ?>
<!-- بخش اعضای گروه  -->
<!-- اگر اعضایی وجود داشته باشند، نمایش افقی اعضا -->
<?php if (is_array($members) && !empty($members)) : ?>
    <div class="my-12 flex flex-col gap-6">

        <div class="flex items-center px-4 sm:px-6 gap-4">
            <h2 class="text-[#6B4C3B] text-2xl sm:text-3xl font-extrabold bg-gradient-to-r from-[#f2c57c]/60 via-[#f2d8c2]/50 to-[#f2c57c]/60 rounded-3xl px-6 py-3 shadow-lg flex items-center gap-3">
                اعضای گروه
            </h2>
            <!-- دکمه افزودن عضو -->
            <a href="<?php echo esc_url(home_url('/add-member')); ?>"
                class="bottom-6 right-6 from-[#f2c57c]/60 via-[#f2d8c2]/50 to-[#f2c57c]/60 text-[#6B4C3B] shadow-[0_4px_10px_rgba(107,76,59,0.3)] hover:shadow-[0_15px_30px_rgba(107,76,59,0.5)]
                     mr-3 mt-2 w-14 h-14 flex items-center justify-center rounded-full text-3xl">
                +
            </a>

        </div>

        <!-- لیست اعضا -->
        <div id="members-container" class="overflow-x-auto scroll-smooth flex gap-4 px-4 sm:px-6 py-3">
            <?php
            $colors = ['bg-[#fff0e0]', 'bg-[#ffe8d0]'];
            foreach ($members as $index => $member_id) :
                $member_data = get_userdata($member_id); // گرفتن اطلاعات کاربر بر اساس ID
                if (!$member_data) continue; // اگر کاربر وجود نداشت، ادامه نده
                $member_name     = esc_html($member_data->first_name);
                $member_lastname = esc_html($member_data->last_name);
                $member_img      = esc_html(get_user_meta($member_id, 'profile_image', true));
                $member_points   = esc_html(get_user_meta($member_id, 'points', true));
                $bg_color = $colors[$index % count($colors)]; // انتخاب رنگ بر اساس ترتیب عضو
            ?>
                <a href="<?php echo home_url('/edit-member?member_id=' . $member_id); ?>"
                    class="<?php echo $bg_color; ?> min-w-[90px] sm:min-w-[100px] md:min-w-[110px] p-2 rounded-2xl 
                    shadow-md hover:shadow-xl transition transform hover:-translate-y-1 
                    flex flex-col items-center text-center">

                    <div class="relative w-16 h-16 sm:w-18 sm:h-18 md:w-20 md:h-20 rounded-full overflow-hidden">
                        <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-[#f2c57c]/40 to-[#f2c57c]/10 animate-pulse-slow -z-10"></div>
                        <img src="<?php echo $member_img; ?>" alt="<?php echo $member_name; ?>"
                            class="w-full h-full object-cover rounded-full transition-transform duration-300 hover:scale-105">
                    </div>

                    <h3 class="text-xs sm:text-sm md:text-base font-semibold mt-2 leading-snug break-words">
                        <?php echo $member_name . ' ' . $member_lastname; ?>
                    </h3>

                    <p class="text-xs text-[#8B5E3C] mt-1 font-medium">⭐<?php echo $member_points; ?></p>

                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php else : ?>
    <!-- پیام وقتی هیچ عضوی وجود ندارد -->
    <div class="my-16 mx-auto max-w-sm text-center bg-gradient-to-r from-[#fff8f0] via-[#fff3e8] to-[#fff8f0] 
            text-[#6B4C3B] font-semibold text-lg rounded-2xl shadow-lg p-6 flex flex-col items-center gap-4
            transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">

        <p>هنوز عضوی به گروه اضافه نشده است.</p>

        <a href="<?php echo esc_url(home_url('/add-member')); ?>"
            class="bg-[#f2c57c]/80 text-[#6B4C3B] px-6 py-2 rounded-xl shadow hover:bg-[#f2c57c] hover:shadow-2xl transition font-bold text-lg">
            ➕ افزودن عضو
        </a>
    </div>

<?php endif; ?>

<!-- دکمه‌ افزودن تسک -->
<a href="<?php echo esc_url(home_url('/add-task')); ?>" class="fixed bottom-6 left-6 bg-[#6B4C3B] text-white w-16 h-16 flex items-center justify-center rounded-full shadow-xl text-3xl hover:bg-[#f3eae6] hover:text-[#6B4C3B] transition">
    📝
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