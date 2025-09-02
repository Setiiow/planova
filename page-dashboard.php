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

$group = get_user_meta($user_id, '_group_info', true);
if (! is_array($group) || empty($group)) {
    $group = get_user_meta($user_id, '_group_info', true);
    if (! is_array($group)) $group = [];
}

$group_name     = $group['name']     ?? '';
$group_password = $group['password'] ?? '';
$group_img = $group['image'] ?? '';

$leader_name    = get_the_author_meta('display_name', $user_id);

if ($group_name) {
    echo '<div class="bg-white shadow-md rounded p-4 mb-4">';
    echo '<h2 class="text-xl font-bold mb-4">گروه شما</h2>';
    echo '<div class="flex flex-wrap gap-6 items-center">';
    echo '<p><strong>نام گروه:</strong> <span class="text-blue-600">' . esc_html($group_name) . '</span></p>';
    echo '<p><strong>نام سرگروه:</strong> <span class="text-green-600">' . esc_html($leader_name) . '</span></p>';
    echo '<p><strong>عکس گروه: </strong><img src="' . esc_url($group_img) . '" alt="Group Image" class="w-32 h-32 object-cover rounded"></p>';
    // echo '<p><strong>رمز گروه:</strong> <span class="text-red-600">' . esc_html($group_password) . '</span></p>';
    echo '</div>';
    echo '<a href="' . esc_url(home_url('/group-settings')) . '" 
        class="inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
        ⚙️ تنظیمات گروه
      </a>';
    echo '<a href="' . esc_url(home_url('/add-member')) . '" 
        class="fixed bottom-6 right-6 bg-blue-600 text-white w-14 h-14 flex items-center justify-center rounded-full shadow-lg text-3xl hover:bg-blue-700">
        +
      </a>';

    echo '</div>';
} else {
    echo '<p>شما هنوز گروهی ایجاد نکرده‌اید.</p>';
}

$members = get_user_meta($user_id, '_group_members', true);
if (is_array($members) && !empty($members)) {
    echo '<div class="bg-white shadow-md rounded p-4 mt-6">';
    echo '<h2 class="text-xl font-bold mb-4">اعضای گروه</h2>';
    echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">';
    foreach ($members as $member_id) {
        $member_data = get_userdata($member_id);
        if ($member_data) {
            $member_name     = esc_html($member_data->first_name);
            $member_lastname = esc_html($member_data->last_name);
            $member_gender   = esc_html(get_user_meta($member_id, 'gender', true));
            $member_img      = esc_html(get_user_meta($member_id, 'profile_image', true));
            $member_points   = esc_html(get_user_meta($member_id, 'points', true));
        }


        echo '<div class="bg-gray-50 rounded-lg shadow p-4 text-center">';
        echo '<img src="' . $member_img . '" alt="' . $member_name . '" class="w-24 h-24 mx-auto rounded-full object-cover mb-3">';
        echo '<h3 class="text-lg font-semibold">' . $member_name . ' ' . $member_lastname . '</h3>';
        echo '<p class="text-sm text-gray-600">جنسیت: ' . ($member_gender === 'girl' ? 'دختر' : 'پسر') . '</p>';
        echo '<p class="text-sm text-gray-600">امتیاز: ' . $member_points . '</p>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
} else {
    echo '<p class="mt-4 text-gray-600">هنوز عضوی به گروه اضافه نشده است.</p>';
}
echo '<a href="' . esc_url(home_url('/add-task')) . '" 
    class="fixed bottom-6 left-6 bg-green-600 text-white w-14 h-14 flex items-center justify-center rounded-full shadow-lg text-2xl hover:bg-green-700">
    📝
  </a>';
?>
<!-- دکمه ثبت جایزه  -->
<a href="<?php echo esc_url(home_url('/add-reward')); ?>"
    class="fixed top-24 right-6 z-50 bg-pink-500 text-white w-14 h-14 flex items-center justify-center rounded-full shadow-lg text-2xl hover:bg-pink-600 hover:scale-110 transition-transform duration-300">
    🎁
</a>
<?php
get_footer();
?>