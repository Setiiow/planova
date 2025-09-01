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
    echo '</div>';
    echo '</div>';
} else {
    echo '<p class="mt-4 text-gray-600">هنوز عضوی به گروه اضافه نشده است.</p>';
}
?>
<?php
get_footer();
?>