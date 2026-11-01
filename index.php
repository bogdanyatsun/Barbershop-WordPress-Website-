<?php
get_header();
?>

<main class="max-w-300 mx-auto px-6 py-24 text-center">
  <h1 class="font-['Cinzel',serif] text-3xl font-bold text-text-main mb-4">
    <?php the_title(); ?>
  </h1>
  <div class="text-text-muted max-w-xl mx-auto leading-relaxed">
    <?php
    if (have_posts()) :
      while (have_posts()) : the_post();
        the_content();
      endwhile;
    endif;
    ?>
  </div>
</main>

<?php
get_footer();