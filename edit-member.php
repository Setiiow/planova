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

$user_id = $user->ID;
$errors = [];

// گرفتن member_id از URL
$member_id = isset($_GET['member_id']) ? intval($_GET['member_id']) : 0;
if (!$member_id) {
    echo '<p>عضو نامعتبر است.</p>';
    get_footer();
    exit;
}

// بررسی اینکه عضو انتخاب شده از گروه همین سرگروه باشد
$members = get_user_meta($user->ID, '_group_members', true);
if (!is_array($members) || !in_array($member_id, $members)) {
    echo '<p>این عضو جزو گروه شما نیست.</p>';
    get_footer();
    exit;
}


// گرفتن اطلاعات عضو
$member_data = get_userdata($member_id);
$gender      = get_user_meta($member_id, 'gender', true);
$points      = get_user_meta($member_id, 'points', true);
$profile_img = get_user_meta($member_id, 'profile_image', true);
$tasks       = get_user_meta($member_id, '_member_tasks', true);

?>

<?php
get_footer();
?>