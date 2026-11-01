<?php
/* Template Name: Craft & Gallery */
get_header();
?>

<!-- Page Header -->
<div class="relative py-16 md:py-24 px-6 text-center border-b border-border-dark bg-linear-to-b from-bg-surface to-bg-base">
    <div class="max-w-3xl mx-auto">

        <!-- Badge above the heading -->
        <span class="text-gold text-xs font-bold tracking-[3px] uppercase inline-block mb-3">
            <?php echo esc_html(get_theme_mod('craft_badge', 'PORTFOLIO & LOOKBOOK')); ?>
        </span>

        <!-- Main page heading (supports line breaks and uppercase) -->
        <h1 class="font-['Cinzel',serif] text-3xl sm:text-4xl md:text-5xl font-bold text-text-main uppercase tracking-tight leading-tight mb-4">
            <?php echo nl2br(esc_html(get_theme_mod('craft_title', "MASTER CRAFTS & CLIENT\nSTYLES"))); ?>
        </h1>

        <!-- Description -->
        <p class="text-text-muted text-sm sm:text-base leading-relaxed max-w-xl mx-auto">
            <?php echo esc_html(get_theme_mod('craft_desc', 'Explore cuts and master grooming crafted inside our London & Manhattan parlours.')); ?>
        </p>

    </div>
</div>

<!-- Master Barbers Section -->
<section class="max-w-300 mx-auto px-6 py-20">

    <!-- Section Title -->
    <div class="text-center mb-14">
        <span class="text-gold text-xs font-bold tracking-[3px] uppercase">THE ARTISAN GUILD</span>
        <h2 class="font-['Cinzel',serif] text-3xl md:text-4xl font-bold text-text-main mt-2">Senior Craftsmen</h2>
        <div class="w-12.5 h-0.5 bg-gold mx-auto mt-4"></div>
    </div>

    <!-- Senior Masters Grid (3 Column) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <?php
        $senior_query = new WP_Query([
            'post_type'      => 'barber',
            'posts_per_page' => -1,
            'meta_key'       => '_barber_level',
            'meta_value'     => 'senior',
            'order'          => 'ASC',
        ]);

        if ($senior_query->have_posts()) :
            while ($senior_query->have_posts()) : $senior_query->the_post();
                $role  = get_post_meta(get_the_ID(), '_barber_role', true);
                $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: get_template_directory_uri() . '/images/barber-1.webp';
        ?>
                <div class="group bg-bg-surface border border-border-dark rounded-xl overflow-hidden hover:border-gold hover:-translate-y-1 transition duration-300 shadow-xl flex flex-col">
                    <div class="relative aspect-square overflow-hidden bg-bg-base">
                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy"
                            class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-6 flex flex-col grow">
                        <h3 class="font-['Cinzel',serif] text-xl font-bold text-text-main mb-1"><?php the_title(); ?></h3>
                        <?php if ($role) : ?>
                            <span class="text-gold text-xs font-semibold tracking-wider uppercase mb-3"><?php echo esc_html($role); ?></span>
                        <?php endif; ?>
                        <div class="text-text-muted text-sm leading-relaxed mt-auto">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            <?php
            endwhile;
            wp_reset_postdata();
        else :
            ?>
            <p class="text-text-muted col-span-full text-center py-6">Senior foremen have not yet been added.</p>
        <?php endif; ?>
    </div>

    <!-- Junior Sub-heading -->
    <div class="text-center mb-10 pt-4">
        <span class="text-gold text-xs font-bold tracking-[3px] uppercase">NEXT GENERATION</span>
        <h3 class="font-['Cinzel',serif] text-2xl font-bold text-text-main mt-1">Apprentice & Junior Artisans</h3>
    </div>

    <!-- Junior Masters Grid (3 Column) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php
        $junior_query = new WP_Query([
            'post_type'      => 'barber',
            'posts_per_page' => -1,
            'meta_key'       => '_barber_level',
            'meta_value'     => 'junior',
            'order'          => 'ASC',
        ]);

        if ($junior_query->have_posts()) :
            while ($junior_query->have_posts()) : $junior_query->the_post();
                $role  = get_post_meta(get_the_ID(), '_barber_role', true);
                $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: get_template_directory_uri() . '/images/barber-4.webp';
        ?>
                <div class="group bg-bg-surface border border-border-dark rounded-xl overflow-hidden hover:border-gold hover:-translate-y-1 transition duration-300 shadow-xl flex flex-col">
                    <div class="relative aspect-square overflow-hidden bg-bg-base">
                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy"
                            class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-6 flex flex-col grow">
                        <h4 class="font-['Cinzel',serif] text-xl font-bold text-text-main mb-1"><?php the_title(); ?></h4>
                        <?php if ($role) : ?>
                            <span class="text-gold text-xs font-semibold tracking-wider uppercase mb-3"><?php echo esc_html($role); ?></span>
                        <?php endif; ?>
                        <div class="text-text-muted text-sm leading-relaxed mt-auto">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            <?php
            endwhile;
            wp_reset_postdata();
        else :
            ?>
            <p class="text-text-muted col-span-full text-center py-6">Junior masters have not yet been added.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Visual Gallery Grid -->
<section class="max-w-300 mx-auto px-6 py-16">

    <?php
    $gallery_query = new WP_Query([
        'post_type'      => 'transformation',
        'posts_per_page' => -1,
        'order'          => 'ASC',
    ]);
    $count = $gallery_query->found_posts ?: 4;
    ?>

    <!-- Gallery Controls Header -->
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 mb-8 pb-4 border-b border-border-dark">
        <h3 class="font-['Cinzel',serif] text-xl sm:text-2xl font-bold text-text-main">
            Recent Transformations (<span id="galleryCount" class="text-gold"><?php echo esc_html($count); ?></span>)
        </h3>
        <span class="text-text-muted text-xs sm:text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-info text-gold"></i> Click on any photo to open in lightbox view
        </span>
    </div>

    <!-- Gallery Grid Container -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="galleryContainer">

        <?php
        if ($gallery_query->have_posts()) :
            while ($gallery_query->have_posts()) : $gallery_query->the_post();
                $barber_credit = get_post_meta(get_the_ID(), '_transformation_barber', true);
                $full_url      = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $thumb_url     = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: $full_url;
        ?>
                <article class="gallery-card group bg-bg-surface border border-border-dark rounded-xl overflow-hidden hover:border-gold hover:-translate-y-1 transition duration-300 shadow-lg cursor-pointer flex flex-col"
                    data-full="<?php echo esc_url($full_url); ?>">
                    <div class="relative aspect-4/5 overflow-hidden bg-bg-base">
                        <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-bg-base/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 backdrop-blur-[2px]">
                            <span class="w-11 h-11 rounded-full bg-gold/90 text-[#0a0b0e] flex items-center justify-center text-lg shadow-lg">
                                <i class="fa-solid fa-magnifying-glass-plus"></i>
                            </span>
                        </div>
                    </div>
                    <div class="p-5 flex flex-col grow">
                        <h4 class="card-style-title font-['Cinzel',serif] text-base font-bold text-text-main group-hover:text-gold transition duration-200 mb-1">
                            <?php the_title(); ?>
                        </h4>
                        <?php if ($barber_credit) : ?>
                            <p class="card-barber-tag text-xs text-text-muted font-medium">
                                <?php echo esc_html($barber_credit); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php
            endwhile;
            wp_reset_postdata();
        else :
            ?>
            <p class="text-text-muted col-span-full text-center py-8">No transformations published yet.</p>
        <?php endif; ?>

    </div>
</section>

<!-- Lightbox Viewer Modal -->
<div class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-6 opacity-0 pointer-events-none transition-opacity duration-300 [&.open]:opacity-100 [&.open]:pointer-events-auto cursor-pointer"
    id="lightbox">
    <button class="absolute top-5 right-6 text-text-muted hover:text-gold text-4xl leading-none transition cursor-pointer z-10"
        id="closeLightbox" aria-label="Close lightbox">&times;</button>
    <div class="max-w-4xl w-full flex flex-col items-center cursor-default">
        <img src="" alt="Enlarged view" id="lightboxImg"
            class="max-h-[75vh] w-auto max-w-full rounded-lg border-2 border-gold object-contain shadow-2xl">
        <div class="font-['Cinzel',serif] text-text-main text-sm sm:text-base tracking-wide text-center mt-4"
            id="lightboxCaption"></div>
    </div>
</div>

<?php get_footer(); ?>