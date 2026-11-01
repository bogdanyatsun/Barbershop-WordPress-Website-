<!-- Footer -->
<footer class="bg-[#090a0d] border-t border-border-dark px-6 pt-16 pb-12 mt-16">
    <div class="max-w-300 mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[2fr_1.5fr_1.2fr_1.5fr] gap-10">

        <!-- Колонка 1: О бренде и копирайт -->
        <div class="flex flex-col">
            <h4 class="font-['Cinzel',serif] text-xl font-bold tracking-[2px] text-gold mb-4">THE GENTLEMAN’S RESERVE</h4>
            <p class="text-text-muted text-sm leading-relaxed mb-6">
                <?php echo esc_html(get_theme_mod('footer_about', 'Where gentlemanly traditions meet contemporary mastery. Operating flagship suites in London Mayfair and New York Soho.')); ?>
            </p>
            <p class="text-xs text-[#646d7e] mt-auto">© <?php echo date('Y'); ?> The Gentleman's Reserve Ltd. All rights reserved.</p>
        </div>

        <!-- Колонка 2: Локации и контакты -->
        <div>
            <h5 class="text-xs font-bold tracking-[1.5px] uppercase text-text-main mb-5">Flagship Locations</h5>
            <address class="not-italic text-sm text-text-muted space-y-2">
                <p>
                    <strong class="text-text-main font-semibold">London Suite:</strong>
                    <?php echo esc_html(get_theme_mod('footer_addr_london', '42 Old Bond Street, Mayfair, W1S 4LZ')); ?>
                </p>
                <p>
                    <strong class="text-text-main font-semibold">New York Suite:</strong>
                    <?php echo esc_html(get_theme_mod('footer_addr_ny', '118 Mercer Street, SoHo, NY 10012')); ?>
                </p>
                <p class="pt-2">
                    <strong class="text-text-main font-semibold">Concierge:</strong>
                    <?php
                    $email = get_theme_mod('footer_email', 'concierge@reservecraft.com');
                    ?>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="hover:text-gold transition">
                        <?php echo esc_html($email); ?>
                    </a>
                </p>
            </address>
        </div>

        <!-- Колонка 3: Часы работы -->
        <div>
            <h5 class="text-xs font-bold tracking-[1.5px] uppercase text-text-main mb-5">Opening Hours</h5>
            <ul class="text-sm text-text-muted space-y-2.5">
                <li class="flex justify-between border-b border-white/5 pb-1.5">
                    <span class="text-text-main font-medium">Mon – Fri:</span>
                    <span><?php echo esc_html(get_theme_mod('footer_hours_mf', '08:30 AM – 08:00 PM')); ?></span>
                </li>
                <li class="flex justify-between border-b border-white/5 pb-1.5">
                    <span class="text-text-main font-medium">Saturday:</span>
                    <span><?php echo esc_html(get_theme_mod('footer_hours_sat', '09:00 AM – 07:00 PM')); ?></span>
                </li>
                <li class="flex justify-between border-b border-white/5 pb-1.5">
                    <span class="text-text-main font-medium">Sunday:</span>
                    <span><?php echo esc_html(get_theme_mod('footer_hours_sun', '10:00 AM – 05:00 PM')); ?></span>
                </li>
            </ul>
        </div>

        <!-- Колонка 4: Социальные сети -->
        <div>
            <h5 class="text-xs font-bold tracking-[1.5px] uppercase text-text-main mb-5">Connect With Us</h5>
            <p class="text-sm text-text-muted leading-relaxed mb-4">
                Follow our weekly lookbook releases and behind-the-scenes grooming tutorials:
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="<?php echo esc_url(get_theme_mod('social_instagram', '#')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"
                    class="w-10 h-10 rounded-full bg-bg-surface border border-border-dark flex items-center justify-center text-text-main text-sm hover:bg-gold hover:text-black hover:border-gold hover:-translate-y-1 transition duration-200">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('social_facebook', '#')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"
                    class="w-10 h-10 rounded-full bg-bg-surface border border-border-dark flex items-center justify-center text-text-main text-sm hover:bg-gold hover:text-black hover:border-gold hover:-translate-y-1 transition duration-200">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('social_youtube', '#')); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube"
                    class="w-10 h-10 rounded-full bg-bg-surface border border-border-dark flex items-center justify-center text-text-main text-sm hover:bg-gold hover:text-black hover:border-gold hover:-translate-y-1 transition duration-200">
                    <i class="fa-brands fa-youtube"></i>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('social_x', '#')); ?>" target="_blank" rel="noopener noreferrer" aria-label="X"
                    class="w-10 h-10 rounded-full bg-bg-surface border border-border-dark flex items-center justify-center text-text-main text-sm hover:bg-gold hover:text-black hover:border-gold hover:-translate-y-1 transition duration-200">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('social_tiktok', '#')); ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok"
                    class="w-10 h-10 rounded-full bg-bg-surface border border-border-dark flex items-center justify-center text-text-main text-sm hover:bg-gold hover:text-black hover:border-gold hover:-translate-y-1 transition duration-200">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
            </div>
        </div>

    </div>
</footer>

<script>
    (function() {
        const burger = document.getElementById('hamburgerBtn');
        const menu = document.querySelector('.nav-links');
        if (!burger || !menu) return;

        const mobileClasses = [
            'flex', 'flex-col', 'absolute', 'top-full', 'left-0', 'w-full',
            'bg-[#0f1115]', 'border-b', 'border-[#2e3646]', 'p-6', 'gap-4', 'shadow-2xl'
        ];

        function toggleMenu(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            const isOpen = menu.classList.toggle('open');
            if (isOpen) {
                menu.classList.remove('hidden');
                menu.classList.add(...mobileClasses);
            } else {
                menu.classList.remove(...mobileClasses);
                menu.classList.add('hidden');
            }
        }

        function closeIfOutside(e) {
            if (!menu.contains(e.target) && !burger.contains(e.target)) {
                menu.classList.remove('open');
                menu.classList.remove(...mobileClasses);
                menu.classList.add('hidden');
            }
        }

        burger.addEventListener('click', toggleMenu);
        document.addEventListener('click', closeIfOutside);
        document.addEventListener('touchend', closeIfOutside);
    })();
</script>

<?php wp_footer(); ?>
</body>

</html>