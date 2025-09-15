<?php
/*
Template Name: Group Setting
*/
get_header();

if (! is_user_logged_in()) {
    echo '<p>لطفاً ابتدا وارد شوید.</p>';
    get_footer();
    exit;
}

$user = wp_get_current_user();
$user_id = $user->ID;

if (! array_intersect(['parent', 'teacher'], (array) $user->roles)) {
    echo '<p>شما اجازه دسترسی به این بخش را ندارید.</p>';
    get_footer();
    exit;
}

$group_data = get_user_meta($user_id, '_group_info', true);
if (! is_array($group_data)) {
    $group_data = [
        'name'     => '',
        'password' => '',
        'image'    => '',
    ];
}

$leader_name = $user->display_name;
$default_img = get_template_directory_uri() . '/assets/images/default-group.jpeg';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_group_image'])) {
        $group_data['image'] = $default_img;
        update_user_meta($user_id, '_group_info', $group_data);
        echo '<p class="text-green-600">عکس حذف شد و به حالت پیشفرض برگشت ✅</p>';
    }

    if (isset($_POST['update_group'])) {
        $group_data['name']     = sanitize_text_field($_POST['group_name']);
        $group_data['password'] = sanitize_text_field($_POST['group_password']);

        if (!empty($_FILES['group_image']['name'])) {
            $uploaded = wp_handle_upload($_FILES['group_image'], ['test_form' => false]);
            if (!isset($uploaded['error'])) {
                $group_data['image'] = $uploaded['url'];
            }
        }

        update_user_meta($user_id, '_group_info', $group_data);

        if (isset($_POST['leader_name']) && !empty($_POST['leader_name'])) {
            wp_update_user([
                'ID'           => $user_id,
                'display_name' => sanitize_text_field($_POST['leader_name']),
            ]);
        }

        echo '<p class="text-green-800 bg-green-100 font-semibold rounded-lg px-4 py-2 shadow-md text-center mx-auto mb-4 w-max">
      تنظیمات با موفقیت ذخیره شد ✅
      </p>';

        $leader_name = get_the_author_meta('display_name', $user_id);
    }
}
?>

<main class="relative w-full min-h-screen overflow-x-hidden flex items-center justify-center 
             animate-gradient bg-[length:400%_400%]">
    <div class="max-w-4xl w-full mx-auto px-4 pt-12 md:py-8">
        <div class="bg-white/70 backdrop-blur-xl border border-white/30 rounded-2xl p-6 shadow-xl 
                    hover:shadow-[0_20px_40px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-transform duration-300">

            <header class="mb-4 text-center">
                <h1 class="text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-[#8B5E3C] to-[#f2c57c] bg-clip-text text-transparent 
                           inline-flex items-center justify-center gap-2 tracking-tight">
                    <span class="text-3xl">🌈</span>
                    تنظیمات گروه
                    <span class="text-xl">✨</span>
                </h1>
            </header>

            <!-- فرم جمع و جور بدون اسکرول -->
            <form method="post" enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 p-2"
                novalidate>

                <!-- نام گروه -->
                <label class="form-label block">
                    <span class="inline-flex items-center gap-2 text-sm md:text-base">
                        <span class="text-lg">🏷️</span>
                        <span>نام گروه</span>
                    </span>
                    <input type="text" name="group_name" required
                        value="<?php echo esc_attr($group_data['name']); ?>"
                        class="mt-1 block w-full rounded-lg p-2 border border-[#f2c57c]/50 bg-white/90 
                                  text-[#6B4C3B] text-sm md:text-base 
                                  focus:outline-none focus:ring-2 focus:ring-[#f2c57c]/40 focus:border-[#8B5E3C] 
                                  transition duration-200 shadow-sm" />
                </label>

                <!-- رمز گروه -->
                <label class="form-label block">
                    <span class="inline-flex items-center gap-2 text-sm md:text-base">
                        <span class="text-lg">🔑</span>
                        <span>رمز گروه</span>
                    </span>
                    <input type="text" name="group_password" required
                        value="<?php echo esc_attr($group_data['password']); ?>"
                        class="mt-1 block w-full rounded-lg p-2 border border-[#f2c57c]/50 bg-white/90 
                                  text-[#6B4C3B] text-sm md:text-base
                                  focus:outline-none focus:ring-2 focus:ring-[#f2c57c]/40 focus:border-[#8B5E3C] 
                                  transition duration-200 shadow-sm" />
                </label>

                <!-- نام سرگروه -->
                <label class="form-label block col-span-1 md:col-span-2">
                    <span class="inline-flex items-center gap-2 text-sm md:text-base">
                        <span class="text-lg">👩‍🏫</span>
                        <span>نام سرگروه</span>
                    </span>
                    <input type="text" name="leader_name" required
                        value="<?php echo esc_attr($leader_name); ?>"
                        class="mt-1 block w-full rounded-lg p-2 border border-[#f2c57c]/50 bg-white/90 
                                  text-[#6B4C3B] text-sm md:text-base
                                  focus:outline-none focus:ring-2 focus:ring-[#f2c57c]/40 focus:border-[#8B5E3C] 
                                  transition duration-200 shadow-sm" />
                </label>

                <!-- تصویر گروه -->
                <div class="flex flex-col gap-2 col-span-1 md:col-span-2">
                    <span class="form-label inline-flex items-center gap-2 text-sm md:text-base">
                        <span class="text-lg">🖼️</span>
                        <span>تصویر گروه</span>
                    </span>

                    <?php if (!empty($group_data['image'])): ?>
                        <div class="flex items-center gap-2">
                            <img src="<?php echo esc_url($group_data['image']); ?>" alt="Group Image"
                                class="w-20 h-20 rounded-full object-cover border-2 border-[#f2c57c]/70 shadow-sm" />
                            <div class="flex-1 text-xs md:text-sm">
                                <p class="text-[#6B4C3B] font-medium">تصویر فعلی</p>
                                <p class="text-[#6B4C3B]/70">اگر می‌خواهی آن را تغییر دهی، فایل جدید انتخاب کن.</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <input type="file" name="group_image"
                        class="mt-1 block w-full rounded-lg p-2 border border-dashed border-[#f2c57c]/70 
                                  bg-[#fff8f0] text-[#6B4C3B] text-sm cursor-pointer hover:bg-[#fdf3e6] transition" />
                </div>

                <!-- دکمه حذف عکس -->
                <div class="flex flex-col sm:flex-row gap-2 col-span-1 md:col-span-2">
                    <button type="submit" name="remove_group_image"
                        class="inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg 
                                   bg-red-500 text-white w-full sm:w-auto hover:bg-red-600 transition">
                        حذف عکس
                    </button>
                </div>

                <!-- دکمه‌های پایانی -->
                <div class="flex gap-2 flex-col sm:flex-row col-span-1 md:col-span-2">
                    <button type="submit" name="update_group"
                        class="relative overflow-hidden px-4 py-2 rounded-lg font-bold text-[#6B4C3B] bg-[#f2c57c] 
                                   transition duration-200 flex-1 hover:text-white hover:scale-105">
                        💾 ذخیره تغییرات
                    </button>

                    <a href="<?php echo home_url('/dashboard'); ?>"
                        class="relative overflow-hidden px-4 py-2 rounded-lg font-bold text-[#6B4C3B] bg-[#f2c57c] 
                              transition duration-200 flex-1 text-center hover:text-white hover:scale-105">
                        بازگشت به داشبورد
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php get_footer(); ?>