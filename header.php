<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%230f1115'/><text x='50%' y='55%' dominant-baseline='middle' text-anchor='middle' font-family='serif' font-weight='bold' font-size='65' fill='%23c5a059'>R</text></svg>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-bg-base text-text-main font-[\'Plus_Jakarta_Sans\',sans-serif] antialiased selection:bg-gold selection:text-black overflow-x-hidden'); ?>>

    <!-- Navigation Bar -->
    <header class="sticky top-0 z-50 bg-bg-base/95 backdrop-blur-md border-b border-border-dark py-4">
        <div class="max-w-300 mx-auto px-6 flex justify-between items-center">

            <!-- 1. Brand Logo: крупный Cinzel с золотым акцентом -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="block select-none">
                <span class="font-['Cinzel',serif] text-xl font-bold tracking-[2px] uppercase block">
                    <span class="text-gold">THE</span> <span class="text-text-main">GENTLEMAN’S RESERVE</span>
                </span>
                <span class="text-[10px] tracking-[3px] text-text-muted uppercase block mt-0.5">
                    <?php echo esc_html(get_bloginfo('description') ?: 'MAYFAIR • SOHO'); ?>
                </span>
            </a>

            <!-- 2. Desktop Nav (по центру) -->
            <nav class="nav-links hidden md:flex items-center gap-3">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '<ul class="flex flex-col md:flex-row items-center gap-3 list-none m-0 p-0">%3$s</ul>',
                    'fallback_cb'    => false,
                ]);
                ?>
            </nav>

            <!-- 3. Social Icons: видимый ряд иконок -->
            <div class="flex items-center gap-4 text-text-muted">
                <a href="<?php echo esc_url(get_theme_mod('social_instagram', '#')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="hover:text-gold transition">
                    <i class="fa-brands fa-instagram text-base"></i>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('social_tiktok', '#')); ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok" class="hover:text-gold transition">
                    <i class="fa-brands fa-tiktok text-base"></i>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('social_youtube', '#')); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube" class="hover:text-gold transition">
                    <i class="fa-brands fa-youtube text-base"></i>
                </a>

                <!-- Бургер (показывается только на узких экранах через md:hidden) -->
                <button class="md:hidden text-text-main text-2xl cursor-pointer p-1 ml-2" id="hamburgerBtn"
                    aria-label="Toggle navigation menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

        </div>
    </header>