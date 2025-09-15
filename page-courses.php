<?php
/*
Template Name: Page Courses
*/
get_header();
?>

<div class="container mx-auto px-4 py-10">

    <!-- عنوان صفحه -->
    <div class="w-full flex flex-col items-center mb-6">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-[#6B4C3B] relative inline-block mb-4">
            <?php the_title(); ?>
            <span class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-[#f2c57c] rounded-full"></span>
        </h1>
        <p class="text-[#8B5E3C] max-w-2xl text-center">
            دوره‌هایی برای والدین و معلمان، با راهنمایی مشاوران کودک برای تقویت مهارت‌های کودکان.
        </p>
    </div>

    <!-- فیلتر دسته‌بندی‌ها -->
    <div class="flex justify-center mb-8 mt-12 flex-wrap gap-3">
        <button class="filter-btn px-5 py-2 rounded-full font-semibold transition 
                    bg-gradient-to-r from-[#f2c57c]/60 via-[#f2d8c2]/40 to-[#f2c57c]/60 text-[#6B4C3B]"
            data-filter="all">همه محصولات</button>

        <?php
        $terms = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
        ]);
        if (! empty($terms) && ! is_wp_error($terms)):
            foreach ($terms as $term):
        ?>
                <button class="filter-btn px-5 py-2 rounded-full font-semibold transition 
                        bg-[#fff8f0] text-[#6B4C3B] shadow-md hover:bg-gradient-to-r hover:from-[#f2c57c]/60 hover:via-[#f2d8c2]/40 hover:to-[#f2c57c]/60"
                    data-filter="<?php echo esc_attr($term->slug); ?>">
                    <?php echo esc_html($term->name); ?>
                </button>
        <?php endforeach;
        endif; ?>
    </div>

    <?php
    // کوئری برای دریافت تمام محصولات
    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'meta_query' => [
            [
                'key' => '_downloadable',
                'value' => 'yes'
            ]
        ]
    ];
    $loop = new WP_Query($args);

    if ($loop->have_posts()):
        echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-8">';
        while ($loop->have_posts()): $loop->the_post();
            global $product;
            $product_terms = wp_get_post_terms($product->get_id(), 'product_cat', ['fields' => 'slugs']);
            $product_classes = implode(' ', $product_terms);
    ?>
            <div class="course-item <?php echo esc_attr($product_classes); ?> bg-gradient-to-br from-[#fff8f0] to-[#fff3e8] rounded-3xl shadow-lg hover:shadow-2xl transform transition-all duration-500 hover:-translate-y-2 flex flex-col w-full max-w-[300px] mx-auto">

                <!-- تصویر محصول -->
                <div class="overflow-hidden rounded-2xl mb-4 block">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('medium', ['class' => 'w-full h-48 object-cover transition-transform duration-300 hover:scale-105 rounded-2xl']);
                    } else {
                        echo '<img class="w-full h-48 object-cover rounded-2xl" src="https://via.placeholder.com/300x180?text=No+Image" alt="No Image">';
                    }
                    ?>
                </div>

                <div class="p-4 flex flex-col flex-1">

                    <!-- عنوان محصول -->
                    <h3 class="text-lg font-bold mb-2 text-[#6B4C3B] hover:text-[#8B5E3C] transition-colors truncate">
                        <a href="<?php echo esc_url(home_url('/pay-page/?product_id=' . $product->get_id())); ?>"><?php the_title(); ?></a>
                    </h3>

                    <!-- دسته‌بندی‌ها -->
                    <?php
                    if (!empty($product_terms)) {
                        $cat_names = wp_list_pluck(wp_get_post_terms($product->get_id(), 'product_cat'), 'name');
                        echo '<p class="text-[#7a6b5e] text-sm mb-3">دسته‌بندی: ' . implode(', ', $cat_names) . '</p>';
                    }
                    ?>

                    <!-- قیمت‌ها -->
                    <div class="flex justify-between items-center mb-3 text-sm sm:text-base font-bold text-[#6B4C3B]">
                        <?php
                        if ($product->get_sale_price()) {
                            echo '<span class="text-[#f2c57c]">' . toPersianNumerals(number_format($product->get_sale_price())) . ' ریال</span>';
                            echo '<span class="line-through text-gray-400">' . toPersianNumerals(number_format($product->get_regular_price())) . ' ریال</span>';
                        } else {
                            echo '<span class="text-[#f2c57c]">' . toPersianNumerals(number_format($product->get_price())) . ' ریال</span>';
                        }
                        ?>
                    </div>

                    <!-- دکمه پرداخت/دانلود -->
                    <div class="flex gap-2 mt-auto">
                        <a href="#"
                            class="flex-1 bg-gradient-to-r from-[#f2c57c] via-[#e8dfd3] to-[#f2c57c]
                            text-[#6B4C3B] font-bold px-3 py-2 rounded-2xl shadow-md hover:shadow-xl 
                            transition-transform transform hover:scale-105 text-center text-sm sm:text-base whitespace-nowrap"
                            onclick="alert('این ویژگی فعلا فعال نیست :)'); return false;">
                            دانلود
                        </a>
                    </div>


                </div>
            </div>
    <?php
        endwhile;
        echo '</div>';
    else:
        echo '<p class="text-center text-[#8B5E3C] font-semibold">هیچ محصولی یافت نشد.</p>';
    endif;
    wp_reset_postdata();
    ?>

</div>

<!-- JS برای فیلتر دسته‌بندی‌ها -->
<script>
    jQuery(document).ready(function($) {
        $('.filter-btn').click(function() {
            var filter = $(this).data('filter');
            $('.filter-btn').removeClass('bg-gradient-to-r from-[#f2c57c]/60 via-[#f2d8c2]/40 to-[#f2c57c]/60 text-[#6B4C3B]').addClass('bg-[#fff8f0] text-[#6B4C3B] shadow-md');
            $(this).removeClass('bg-[#fff8f0] text-[#6B4C3B] shadow-md').addClass('bg-gradient-to-r from-[#f2c57c]/60 via-[#f2d8c2]/40 to-[#f2c57c]/60 text-[#6B4C3B]');

            if (filter == 'all') {
                $('.course-item').show();
            } else {
                $('.course-item').hide();
                $('.' + filter).show();
            }
        });
    });
</script>

<?php get_footer(); ?>