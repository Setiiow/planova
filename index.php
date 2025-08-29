<?php get_header(); ?>
<main id="main" class="site-main max-w-screen-lg mx-auto p-4">
<?php
if(have_posts()):
    while(have_posts()): the_post();
        the_title('<h2 class="text-xl font-bold my-2">', '</h2>');
        the_content();
    endwhile;
else:
    echo '<p class="text-gray-500">محتوایی یافت نشد.</p>';
endif;
?>
</main>
<?php get_footer(); ?>
