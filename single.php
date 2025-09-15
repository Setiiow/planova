<?php get_header(); ?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- محتوای اصلی مقاله -->
    <div class="lg:col-span-2">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
            <!-- عنوان مقاله -->
            <header class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-[#6B4C3B] mb-4 leading-snug">
                    <?php the_title(); ?>
                </h1>
                <p class="text-sm text-gray-500">
                    منتشر شده در <?php echo get_the_date(); ?> | نویسنده: <?php the_author(); ?>
                </p>
            </header>

            <!-- تصویر شاخص -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="mb-8">
                    <?php the_post_thumbnail('large', ['class' => 'w-full rounded-2xl shadow-lg']); ?>
                </div>
            <?php endif; ?>

            <!-- محتوای مقاله -->
            <article class="prose prose-lg max-w-none
                prose-headings:text-[#6B4C3B]
                prose-p:text-[#4a3a2c] prose-p:leading-relaxed
                prose-a:text-blue-600 hover:prose-a:text-blue-800 prose-a:underline
                prose-ul:list-disc prose-ul:pr-6 prose-ol:list-decimal prose-ol:pr-6
                prose-img:rounded-xl prose-img:shadow-md prose-img:mx-auto
                prose-blockquote:border-r-4 prose-blockquote:border-[#f2c57c] prose-blockquote:bg-[#fff8f0] prose-blockquote:pr-4 prose-blockquote:rounded-lg prose-blockquote:text-[#6B4C3B]
                prose-table:border prose-table:border-gray-300 prose-table:rounded-lg prose-th:bg-gray-100 prose-td:p-2
                rtl
            ">
                <?php the_content(); ?>
            </article>

            <!-- ناوبری بین مقالات -->
            <div class="mt-12 flex justify-between text-sm font-medium">
                <div>
                    <?php previous_post_link('%link', '← مقاله قبلی'); ?>
                </div>
                <div>
                    <?php next_post_link('%link', 'مقاله بعدی →'); ?>
                </div>
            </div>

        <?php endwhile; endif; ?>
    </div>

    <!-- سایدبار -->
    <aside class="lg:col-span-1">
        <div class="bg-white shadow-md rounded-2xl p-6 sticky top-20">
            <h2 class="text-xl font-bold text-[#6B4C3B] mb-4">مقالات تازه</h2>
            <ul class="space-y-4">
                <?php
                $recent_posts = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 5,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));
                if ($recent_posts->have_posts()) :
                    while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                        <li class="flex items-center space-x-3 border-b border-gray-200 pb-2">
                            <!-- تصویر شاخص کوچک -->
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>" class="flex-shrink-0">
                                    <?php the_post_thumbnail('thumbnail', ['class' => 'w-16 h-16 rounded-md object-cover']); ?>
                                </a>
                            <?php endif; ?>
                            <div>
                                <a href="<?php the_permalink(); ?>" class="block font-medium hover:text-[#f2c57c] transition">
                                    <?php the_title(); ?>
                                </a>
                                <p class="text-xs text-gray-500 mt-1"><?php echo get_the_date(); ?></p>
                            </div>
                        </li>
                    <?php endwhile; wp_reset_postdata();
                else :
                    echo '<li>هیچ مقاله‌ای یافت نشد.</li>';
                endif;
                ?>
            </ul>
        </div>
    </aside>

</main>

<?php get_footer(); ?>
