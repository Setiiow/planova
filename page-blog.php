<?php

/**
 * Template Name: Blog Page
 */

get_header();

// تعیین صفحه فعلی بلاگ برای صفحه‌ بندی
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
// بررسی دسته‌ بندی انتخابی کاربر
$cat   = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
// ساخت آرایه آرگومان ها برای گرفتن پست‌ ها
$args = [
  'post_type'      => 'post',
  'posts_per_page' => 9,
  'paged'          => $paged,
];

if ($cat) {
  $args['cat'] = $cat;
}
// اجرای کوئری وردپرس برای دریافت پست‌ها
$the_query = new WP_Query($args);

// گرفتن دسته‌ بندی‌ ها برای نمایش فیلتر دسته‌ بندی‌ ها
$categories = get_categories(['hide_empty' => true]);
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

  <!-- عنوان -->
  <header class="mb-12 text-center">
    <h1 class="text-5xl font-extrabold text-[#6B4C3B] relative inline-block">
      وبلاگ ها
      <span class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-[#f2c57c] rounded-full"></span>
    </h1>
    <p class="mt-4 text-[#8B5E3C] max-w-2xl mx-auto">
      نکات کلیدی، راهکارهای جذاب و کاربردی را در مقالات عملی و آموزشی ما بیاموزید.
    </p>
  </header>

  <!-- فیلتر دسته‌بندی‌ ها -->
  <div class="flex justify-center mb-10">
    <form method="get" class="flex flex-wrap gap-3 justify-center">
      <input type="hidden" name="s" value="">
      <?php foreach ($categories as $c) : ?>
        <button type="submit" name="cat" value="<?php echo esc_attr($c->term_id); ?>"
          class="px-5 py-2 rounded-full font-semibold transition 
                    hover:bg-gradient-to-r hover:from-[#f2c57c]/60 hover:via-[#f2d8c2]/40 hover:to-[#f2c57c]/60
                    <?php echo ($c->term_id == $cat) ? 'bg-gradient-to-r from-[#f2c57c]/60 via-[#f2d8c2]/40 to-[#f2c57c]/60 text-[#6B4C3B]' : 'bg-[#fff8f0] text-[#6B4C3B] shadow-md'; ?>">
          <?php echo esc_html($c->name); ?>
        </button>
      <?php endforeach; ?>
      <button type="submit" name="cat" value="0"
        class="px-5 py-2 rounded-full font-semibold transition
                <?php echo ($cat == 0) ? 'bg-gradient-to-r from-[#f2c57c]/60 via-[#f2d8c2]/40 to-[#f2c57c]/60 text-[#6B4C3B]' : 'bg-[#fff8f0] text-[#6B4C3B] shadow-md'; ?>">
        همه
      </button>
    </form>
  </div>

  <!--  شرط وجود محتوا (اگر محتوایی وجود داشت چاپ می کند)-->
  <?php if ($the_query->have_posts()) : ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-3xl shadow-lg overflow-hidden transition transform hover:-translate-y-1 hover:shadow-2xl'); ?>>
          <!-- نمایش تصویر شاخص -->
          <?php if (has_post_thumbnail()) : ?>
            <a href="<?php the_permalink(); ?>" class="block relative overflow-hidden rounded-t-3xl">
              <?php the_post_thumbnail('large', ['class' => 'w-full h-52 object-cover transition-transform duration-300 hover:scale-110']); ?>
            </a>
          <?php else: ?>
            <div class="w-full h-52 bg-[#fff3e8] flex items-center justify-center text-[#8B5E3C] rounded-t-3xl">
              بدون تصویر
            </div>
          <?php endif; ?>
          <!-- نمایش دسته بندی محصول و بخشی از محتواش -->
          <div class="p-6 flex flex-col h-full">
            <div>
              <h3 class="text-xl font-bold text-[#6B4C3B] mb-3 hover:text-[#8B5E3C] transition-colors">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h3>
              <p class="text-[#6B4C3B]/80 text-sm leading-relaxed">
                <?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 25, '...'); ?>
              </p>
            </div>
          </div>
        </article>
      <?php endwhile;
      wp_reset_postdata(); ?>
    </div>

    <!-- تنظیمات صفحه بندی -->
    <div class="mt-12 flex justify-center">
      <?php
      $big = 999999999;
      echo paginate_links([
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => max(1, $paged),
        'total'     => $the_query->max_num_pages,
        'prev_text' => '‹ قبلی',
        'next_text' => 'بعدی ›',
        'type'      => 'list',
        'before_page_number' => '<span class="px-2">',
      ]);
      ?>
    </div>

  <?php else : ?>
    <div class="py-20 text-center text-[#6B4C3B]">
      <p class="text-lg font-semibold">هیچ مقاله‌ای پیدا نشد.</p>
      <p class="mt-3 text-sm">دسته‌بندی دیگری انتخاب کنید.</p>
    </div>
  <?php endif; ?>

</main>

<?php get_footer(); ?>