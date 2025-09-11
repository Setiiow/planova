<?php
/*
Template Name: Member Login
*/

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['member_login'])) {
    $first_name     = sanitize_text_field($_POST['first_name'] ?? '');
    $last_name      = sanitize_text_field($_POST['last_name'] ?? '');
    $group_password = sanitize_text_field($_POST['group_password'] ?? '');

    if ($first_name === '' || $last_name === '' || $group_password === '') {
        $login_error = 'همه فیلدها الزامی هستند.';
    } else {
        $args = [
            'role' => 'member',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key'     => 'group_password',
                    'value'   => $group_password,
                    'compare' => '='
                ],
                [
                    'key'     => 'first_name',
                    'value'   => $first_name,
                    'compare' => '='
                ],
                [
                    'key'     => 'last_name',
                    'value'   => $last_name,
                    'compare' => '='
                ],
            ],
            'number' => 1
        ];

        $users = get_users($args);

        if (empty($users)) {
            $login_error = 'عضوی با این اطلاعات یافت نشد.';
        } else {
            $member = $users[0];
            wp_set_current_user($member->ID);
            wp_set_auth_cookie($member->ID);
            do_action('wp_login', $member->user_login, $member);

            wp_redirect(home_url('/member-dashboard'));
            exit;
        }
    }
}
get_header();
?>

<style>
  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .animate-fadeInUp { animation: fadeInUp .35s ease-out forwards; }

  .avatar-btn { transition: transform .18s ease, box-shadow .18s ease; }
</style>

<main class="min-h-screen bg-amber-50 py-10" dir="rtl">
  <div class="max-w-4xl mx-auto p-4">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden grid grid-cols-1 md:grid-cols-2">
      
      <!-- بخش تصویر کارتونی -->
        <div class="hidden md:flex items-center justify-center bg-amber-100">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/cartoon.png" 
             alt="تصویر کارتونی" class="max-h-80 object-contain">
      </div>

      <!-- فرم -->
      <div class="p-6 md:p-8 flex flex-col justify-center">
        <!-- متن تبریک -->
        <h2 class="text-center text-base font-light text-amber-700 mb-4">
  🎉 تبریک! تو اولین قدم نظم رو برداشتی
        </h2>


        <h1 class="text-center text-2xl font-bold mb-4">افزودن / ورود اعضا</h1>

        <!-- نمایش خطا -->
        <?php if (!empty($login_error)) : ?>
          <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            <?php echo esc_html($login_error); ?>
          </div>
        <?php endif; ?>

        <form id="memberForm" method="post" class="space-y-4" novalidate>
          <!-- ردیف نام -->
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-pink-400 text-white font-semibold">1</div>
            <input type="text" name="first_name" placeholder="نام" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-4 focus:ring-yellow-200 transition" required>
          </div>

          <!-- ردیف نام خانوادگی -->
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-teal-400 text-white font-semibold">2</div>
            <input type="text" name="last_name" placeholder="نام خانوادگی" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-4 focus:ring-yellow-200 transition" required>
          </div>

          <!-- ردیف رمز گروه -->
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-400 text-white font-semibold">3</div>
            <input type="text" name="group_password" placeholder="رمز گروه" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-4 focus:ring-yellow-200 transition" inputmode="numeric" pattern="[0-9]*" required>
          </div>
          <!-- دکمه ثبت -->
          <div>
            <button type="submit" name="member_login" id="submitBtn" class="w-full bg-orange-500 text-white rounded-full py-3 font-medium hover:scale-105 transform transition duration-200">
              ورود / ثبت
            </button>
          </div>
        </form>

        <!-- پیام موفقیت -->
        <div id="success" class="hidden mt-4 p-4 bg-green-100 text-green-800 rounded-lg animate-fadeInUp">
          🎉 فرم با موفقیت ارسال شد — لطفاً منتظر بمانید...
        </div>
      </div>
    </div>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('#avatars .avatar-btn').forEach(btn => {
    btn.addEventListener('click', function(){
      document.querySelectorAll('#avatars .avatar-btn').forEach(b => {
        b.classList.remove('ring-4','ring-yellow-300','scale-105');
      });
      this.classList.add('ring-4','ring-yellow-300','scale-105');
      var avatar = this.dataset.avatar || this.textContent.trim();
      document.getElementById('selectedAvatar').value = avatar;
    });
  });

  document.getElementById('memberForm').addEventListener('submit', function(e){
    var fn = document.querySelector('[name="first_name"]').value.trim();
    var ln = document.querySelector('[name="last_name"]').value.trim();
    var pw = document.querySelector('[name="group_password"]').value.trim();
    if(!fn || !ln || !pw){
      e.preventDefault();
      alert('لطفاً همه فیلدها را کامل کنید 🙂');
      return;
    }
    document.getElementById('success').classList.remove('hidden');
  });
});
</script>

<?php
get_footer();
?>
