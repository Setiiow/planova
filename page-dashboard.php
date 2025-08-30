<?php
/* Template Name: Dashboard */
get_header();

if ( ! is_user_logged_in() ) {
    echo '<p>لطفاً ابتدا وارد شوید.</p>';
    get_footer();
    exit;
}

$user = wp_get_current_user();
if ( ! array_intersect(['parent','teacher'], (array) $user->roles) ) {
    echo '<p>شما اجازه دسترسی به این بخش را ندارید.</p>';
    get_footer();
    exit;
}

$user_id = $user->ID;

$group = get_user_meta($user_id, '_user_group', true);
if ( ! is_array($group) || empty($group) ) {
    $group = get_user_meta($user_id, 'user_group', true);
    if ( ! is_array($group) ) $group = [];
}

$group_name     = $group['name']     ?? '';
$group_password = $group['password'] ?? '';
$leader_name    = get_the_author_meta('display_name', $user_id);

if ( $group_name ) {
    echo '<h2 class="text-xl font-bold mb-4">گروه شما</h2>';
    echo '<p><strong>نام گروه:</strong> ' . esc_html($group_name) . '</p>';
    echo '<p><strong>نام سرگروه:</strong> ' . esc_html($leader_name) . '</p>';
} else {
    echo '<p>شما هنوز گروهی ایجاد نکرده‌اید.</p>';
}

get_footer();
