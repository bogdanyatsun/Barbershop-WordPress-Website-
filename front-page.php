<?php get_header(); ?>

<!-- Hero Banner -->
<section class="relative min-h-[82vh] flex items-center justify-center text-center px-6 py-16 overflow-hidden">
  <img src="<?php echo get_template_directory_uri(); ?>/images/barbershop-1.webp" alt="The Gentleman's Reserve Lounge" fetchpriority="high" decoding="async"
    class="absolute inset-0 w-full h-full object-cover object-center pointer-events-none">

  <!-- Dark Gradient Overlay -->
  <div class="absolute inset-0 bg-linear-to-b from-bg-base/80 to-bg-base/95"></div>

  <!-- Content Wrapper (ВЫВОДИМ ПОВЕРХ ОВЕРЛЕЯ ЧЕРЕЗ relative z-10) -->
  <div class="relative z-10 max-w-4xl mx-auto flex flex-col items-center">
    <span class="text-gold text-[10px] sm:text-xs font-bold tracking-[2px] sm:tracking-[3px] uppercase block">
      <?php echo esc_html(get_theme_mod('hero_badge', 'ESTABLISHED IN 2018 • LONDON & NEW YORK')); ?>
    </span>

    <h1 class="font-['Cinzel',serif] text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-text-main mt-4 leading-tight uppercase tracking-tight break-words max-w-full">
      <?php echo nl2br(esc_html(get_theme_mod('hero_title', "TIMELESS CRAFTSMANSHIP.\nUNCOMPROMISING LUXURY."))); ?>
    </h1>

    <p class="text-text-muted text-sm sm:text-base mt-4 max-w-xl mx-auto leading-relaxed">
      <?php echo esc_html(get_theme_mod('hero_desc', 'Experience traditional wet razor shaves, signature scissor cuts, and master-grade beard sculpting in an exclusive private lounge.')); ?>
    </p>

    <!-- CTA Button Group -->
    <div class="flex flex-wrap justify-center gap-4 mt-8">
      <a href="#booking"
        class="inline-flex items-center justify-center px-7 py-3.5 rounded text-sm md:text-base font-semibold bg-gold text-[#0a0b0e] hover:bg-gold-hover hover:-translate-y-0.5 transition duration-200">
        Book Your Chair
      </a>
      <a href="<?php echo esc_url(home_url('/craft')); ?>"
        class="inline-flex items-center justify-center px-7 py-3.5 rounded text-sm md:text-base font-semibold border border-border-dark text-text-main hover:border-gold hover:text-gold transition duration-200">
        Explore Gallery
      </a>
    </div>
  </div><!-- /Content Wrapper -->
</section>

<!-- Services & Pricing Menu -->
<section class="max-w-300 mx-auto px-6 py-20" id="services">
  <div class="text-center mb-14">
    <span class="text-gold text-xs font-bold tracking-[3px] uppercase">THE SERVICE MATRIX</span>
    <h2 class="font-['Cinzel',serif] text-3xl md:text-4xl font-bold text-text-main mt-2">Signature Offerings</h2>
    <div class="w-12.5 h-0.5 bg-gold mx-auto mt-4"></div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php
    $services_query = new WP_Query([
      'post_type'      => 'service',
      'posts_per_page' => -1, // выводим все услуги
      'order'          => 'ASC',
    ]);

    if ($services_query->have_posts()) :
      while ($services_query->have_posts()) : $services_query->the_post();
        $price    = get_post_meta(get_the_ID(), '_service_price', true);
        $duration = get_post_meta(get_the_ID(), '_service_duration', true);
    ?>
        <article class="bg-bg-surface border border-border-dark rounded-lg p-7 flex flex-col justify-between hover:border-gold hover:-translate-y-1 transition duration-300">
          <div>
            <h3 class="font-['Cinzel',serif] text-lg font-bold text-text-main leading-snug mb-2">
              <?php the_title(); ?>
            </h3>
            <?php if ($price) : ?>
              <div class="text-gold font-semibold text-sm mb-4">
                <?php echo esc_html($price); ?>
              </div>
            <?php endif; ?>
            <div class="text-text-muted text-sm leading-relaxed mb-6">
              <?php the_content(); ?>
            </div>
          </div>
          <?php if ($duration) : ?>
            <span class="text-text-muted text-xs flex items-center gap-2">
              <i class="fa-regular fa-clock text-gold"></i> <?php echo esc_html($duration); ?>
            </span>
          <?php endif; ?>
        </article>
      <?php
      endwhile;
      wp_reset_postdata();
    else :
      ?>
      <p class="text-text-muted col-span-full text-center py-8">
        Услуг пока нет. Добавьте их в админке через раздел Services.
      </p>
    <?php endif; ?>
  </div>
</section>

<!-- OPT-IN FORM / APPOINTMENT BOOKING -->
<section id="booking" class="scroll-mt-24 max-w-300 mx-auto px-6 py-20">
  <div class="bg-bg-surface border border-border-dark rounded-xl p-6 sm:p-10 md:p-14 shadow-2xl">
    <div class="text-center mb-10">
      <span class="text-gold text-xs font-bold tracking-[3px] uppercase">SECURE YOUR RESERVATION</span>
      <h2 class="font-['Cinzel',serif] text-3xl md:text-4xl font-bold text-text-main mt-2">Book an Appointment</h2>
      <p class="text-text-muted text-sm md:text-base mt-2">Fill out the opt-in form below to receive calendar sync &
        SMS booking confirmations.</p>
    </div>

    <form id="appointmentForm" class="booking-form" novalidate>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
        <div class="form-group flex flex-col">
          <label for="clientName" class="text-xs font-semibold tracking-wider uppercase text-text-muted mb-2">Full
            Name *</label>
          <div class="relative flex items-center">
            <i class="fa-regular fa-user absolute left-4 text-text-muted pointer-events-none text-sm"></i>
            <input type="text" id="clientName" placeholder="Julian Vance" required
              class="w-full bg-bg-base border border-border-dark rounded-md pl-11 pr-4 py-3 text-text-main text-sm md:text-base font-['Plus_Jakarta_Sans',sans-serif] focus:outline-none focus:border-gold transition">
          </div>
          <small class="error-msg text-red-400 text-xs mt-1.5 hidden" id="nameError">Please enter your legal or
            preferred name.</small>
        </div>

        <div class="form-group flex flex-col">
          <label for="clientEmail" class="text-xs font-semibold tracking-wider uppercase text-text-muted mb-2">Email
            Address *</label>
          <div class="relative flex items-center">
            <i class="fa-regular fa-envelope absolute left-4 text-text-muted pointer-events-none text-sm"></i>
            <input type="email" id="clientEmail" placeholder="julian@reservecraft.com" required
              class="w-full bg-bg-base border border-border-dark rounded-md pl-11 pr-4 py-3 text-text-main text-sm md:text-base font-['Plus_Jakarta_Sans',sans-serif] focus:outline-none focus:border-gold transition">
          </div>
          <small class="error-msg text-red-400 text-xs mt-1.5 hidden" id="emailError">Please enter a valid email
            address.</small>
        </div>

        <div class="form-group flex flex-col">
          <label for="clientPhone" class="text-xs font-semibold tracking-wider uppercase text-text-muted mb-2">Phone
            Number *</label>
          <div class="relative flex items-center">
            <i class="fa-solid fa-phone absolute left-4 text-text-muted pointer-events-none text-sm"></i>
            <input type="tel" id="clientPhone" placeholder="+1 (555) 482-9901" required
              class="w-full bg-bg-base border border-border-dark rounded-md pl-11 pr-4 py-3 text-text-main text-sm md:text-base font-['Plus_Jakarta_Sans',sans-serif] focus:outline-none focus:border-gold transition">
          </div>
          <small class="error-msg text-red-400 text-xs mt-1.5 hidden" id="phoneError">Enter a contact number for SMS
            updates.</small>
        </div>

        <div class="form-group flex flex-col">
          <label for="masterSelection"
            class="text-xs font-semibold tracking-wider uppercase text-text-muted mb-2">Master Barber</label>
          <div class="relative flex items-center">
            <i class="fa-solid fa-scissors absolute left-4 text-text-muted pointer-events-none text-sm"></i>
            <select id="masterSelection"
              class="w-full bg-bg-base border border-border-dark rounded-md pl-11 pr-4 py-3 text-text-main text-sm md:text-base font-['Plus_Jakarta_Sans',sans-serif] focus:outline-none focus:border-gold transition cursor-pointer">
              <option value="Eleanor Vance (Master Stylist)">Eleanor Vance (Master Stylist)</option>
              <option value="Marcus Sterling (Beard Specialist)">Marcus Sterling (Beard Specialist)</option>
              <option value="Leon Davies (Fade Expert)">Leon Davies (Fade Expert)</option>
              <option value="Any Available Craftsman">First Available Craftsman</option>
              <option value="Julian Mercer">Julian Mercer</option>
              <option value="Tobias Croft">Tobias Croft</option>
              <option value="Oliver Sterling">Oliver Sterling</option>
            </select>
          </div>
        </div>

        <div class="form-group flex flex-col">
          <label for="serviceSelection"
            class="text-xs font-semibold tracking-wider uppercase text-text-muted mb-2">Service Package</label>
          <div class="relative flex items-center">
            <i class="fa-solid fa-tag absolute left-4 text-text-muted pointer-events-none text-sm"></i>
            <select id="serviceSelection"
              class="w-full bg-bg-base border border-border-dark rounded-md pl-11 pr-4 py-3 text-text-main text-sm md:text-base font-['Plus_Jakarta_Sans',sans-serif] focus:outline-none focus:border-gold transition cursor-pointer">
              <option value="Executive Scissor Cut ($65)">Executive Scissor Cut ($65)</option>
              <option value="Traditional Hot Towel Shave ($75)">Traditional Hot Towel Shave ($75)</option>
              <option value="Beard Architecture & Steam ($50)">Beard Architecture & Steam ($50)</option>
              <option value="The Full Reserve Treatment ($130)">The Full Reserve Treatment ($130)</option>
              <option value="Royal Scalp & Head Spa ($55)">Royal Scalp & Head Spa ($55)</option>
              <option value="Precision Skin Fade ($70)">Precision Skin Fade ($70)</option>
              <option value="Grey Camo & Beard Tint ($45)">Grey Camo & Beard Tint ($45)</option>
              <option value="The Mayfair Express ($40)">The Mayfair Express ($40)</option>
            </select>
          </div>
        </div>

        <div class="form-group flex flex-col">
          <label for="appointmentDate"
            class="text-xs font-semibold tracking-wider uppercase text-text-muted mb-2">Preferred Date & Time
            *</label>
          <div class="relative flex items-center">
            <i class="fa-regular fa-calendar-days absolute left-4 text-text-muted pointer-events-none text-sm"></i>
            <input type="datetime-local" id="appointmentDate" required
              class="w-full bg-bg-base border border-border-dark rounded-md pl-11 pr-4 py-3 text-text-main text-sm md:text-base font-['Plus_Jakarta_Sans',sans-serif] focus:outline-none focus:border-gold transition scheme-dark">
          </div>
          <small class="error-msg text-red-400 text-xs mt-1.5 hidden" id="dateError">Select an appointment time
            slot.</small>
        </div>
      </div>

      <!-- Opt-in Checkbox -->
      <div class="mt-7 pt-5 border-t border-border-dark">
        <label class="flex items-start gap-3 cursor-pointer select-none">
          <input type="checkbox" id="marketingConsent" required class="peer sr-only">
          <span
            class="w-5 h-5 shrink-0 mt-0.5 rounded border border-border-dark bg-bg-base flex items-center justify-center text-transparent peer-checked:bg-gold peer-checked:border-gold peer-checked:text-black transition">
            <i class="fa-solid fa-check text-xs"></i>
          </span>
          <span class="text-text-muted text-xs sm:text-sm leading-relaxed">
            I agree to the <a href="#" class="text-gold underline hover:text-gold-hover transition">Terms of
              Service</a> & consent to receiving automated booking confirmations, VIP invitations, and grooming
            product discounts.
          </span>
        </label>
        <small class="error-msg text-red-400 text-xs mt-2 hidden" id="consentError">You must accept the terms to
          complete your booking.</small>
      </div>

      <div class="mt-8">
        <button type="submit"
          class="w-full py-4 rounded-md bg-gold text-[#0a0b0e] font-semibold text-base flex items-center justify-center gap-3 shadow-lg hover:bg-gold-hover hover:-translate-y-0.5 active:translate-y-0 transition duration-200 cursor-pointer">
          <span>Confirm Reservation</span>
          <i class="fa-solid fa-arrow-right text-sm"></i>
        </button>
      </div>
    </form>
  </div>
</section>

<!-- Appointment Confirmation Modal -->
<div
  class="fixed inset-0 z-50 bg-black/85 backdrop-blur-sm flex items-center justify-center p-6 opacity-0 pointer-events-none transition-opacity duration-300 [&.open]:opacity-100 [&.open]:pointer-events-auto"
  id="bookingSuccessModal">
  <div
    class="bg-bg-surface border border-border-dark rounded-xl w-full max-w-lg p-8 sm:p-10 relative shadow-2xl text-center">

    <!-- Close Button -->
    <button
      class="absolute top-4 right-5 text-text-muted hover:text-text-main text-3xl leading-none transition cursor-pointer"
      id="closeBookingSuccess" aria-label="Close modal">&times;</button>

    <!-- Success Icon -->
    <div class="text-emerald-400 text-5xl mb-4">
      <i class="fa-solid fa-calendar-check"></i>
    </div>

    <h3 class="font-['Cinzel',serif] text-2xl font-bold text-text-main mb-2">Reservation Confirmed</h3>
    <p class="text-sm md:text-base text-text-muted mb-6">
      Thank you, <strong id="confirmedClientName" class="text-text-main font-semibold">Julian</strong>. We have saved
      your chair reservation.
    </p>

    <!-- Summary Receipt Card -->
    <div class="bg-bg-base border border-border-dark rounded-lg p-5 mb-5 text-left text-sm divide-y divide-white/5">
      <div class="flex justify-between py-2">
        <span class="text-text-muted">Service:</span>
        <strong id="confirmedService" class="text-text-main font-medium">-</strong>
      </div>
      <div class="flex justify-between py-2">
        <span class="text-text-muted">Master:</span>
        <strong id="confirmedMaster" class="text-text-main font-medium">-</strong>
      </div>
      <div class="flex justify-between py-2">
        <span class="text-text-muted">Date & Time:</span>
        <strong id="confirmedDate" class="text-text-main font-medium">-</strong>
      </div>
      <div class="flex justify-between py-2">
        <span class="text-text-muted">Confirmation Email:</span>
        <strong id="confirmedEmail" class="text-text-main font-medium truncate max-w-[60%]">-</strong>
      </div>
    </div>

    <p class="text-xs text-text-muted mb-6 leading-relaxed">
      An SMS reminder with VIP gate instructions has been dispatched to your phone.
    </p>

    <!-- Dismiss Button -->
    <button
      class="w-full py-3.5 rounded-md bg-gold text-[#0a0b0e] font-semibold text-base shadow-lg hover:bg-gold-hover hover:-translate-y-0.5 active:translate-y-0 transition duration-200 cursor-pointer"
      id="bookingDismissBtn">
      Done
    </button>

  </div>
</div>

<?php get_footer(); ?>