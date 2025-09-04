<?php
/* Template Name: Member Dashboard */

if ( ! is_user_logged_in() ) {
    // کاربر وارد نشده -> ریدایرکت به صفحه ورود یا نمایش پیام
    wp_redirect(wp_redirect( home_url('/member-login'))
);
    exit;
}

get_header();

// گرفتن ایدی کاربر جاری
$member_id = get_current_user_id();

// متاهای دلخواه
$first_name    = get_user_meta( $member_id, 'first_name', true );
$last_name     = get_user_meta( $member_id, 'last_name', true );
$gender        = get_user_meta( $member_id, 'gender', true );
$points_raw    = get_user_meta( $member_id, 'points', true );
$points        = ( $points_raw === '' ) ? 0 : intval( $points_raw ); // مقدار پیش‌فرض 0
$profile_image = get_user_meta( $member_id, 'profile_image', true );

?>

<main class="max-w-screen-md mx-auto p-4">
    <div class="bg-white p-6 rounded shadow">
        <div class="flex items-center gap-4">
            <img src="<?php echo esc_url( $profile_image ); ?>" alt="<?php echo esc_attr( $first_name . ' ' . $last_name ); ?>" class="w-24 h-24 rounded-full object-cover">
            <div>
                <h1 class="text-2xl font-bold"><?php echo esc_html( $first_name . ' ' . $last_name ); ?></h1>
                <p class="text-sm text-gray-600">جنسیت: <?php echo esc_html( $gender ); ?></p>
            </div>
        </div>

        <div class="mt-6">
            <p>امتیاز: <strong><?php echo esc_html( $points ); ?></strong></p>
        </div>
    </div>
</main>

<?php
get_footer();
?>
