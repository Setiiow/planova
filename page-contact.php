<?php
/*
Template Name: Contact Page
*/
get_header();
?>

<main class="container mx-auto py-10">
  <h1 class="text-2xl font-bold mb-6"><?php the_title(); ?></h1>
  <div class="prose">
    <?php the_content(); ?>
  </div>
</main>

<?php get_footer(); ?>
