<?php
if (!defined('ABSPATH')) {
    exit;
}

function gentlemans_reserve_scripts()
{
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        '6.5.1'
    );

    wp_enqueue_style(
        'gentlemans-reserve-main',
        get_template_directory_uri() . '/CSS/output.css',
        [],
        filemtime(get_template_directory() . '/CSS/output.css')
    );

    wp_enqueue_script(
        'gentlemans-reserve-app',
        get_template_directory_uri() . '/app.js',
        [],
        filemtime(get_template_directory() . '/app.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'gentlemans_reserve_scripts');

function gentlemans_reserve_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus([
        'primary' => 'Main Menu (Header)',
    ]);
}
add_action('after_setup_theme', 'gentlemans_reserve_setup');

// 1. Remove list bullets and indentation from <li> elements
function gentlemans_nav_item_classes($classes, $item, $args)
{
    if ($args->theme_location === 'primary') {
        $classes[] = 'list-none m-0 p-0 inline-flex';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'gentlemans_nav_item_classes', 10, 3);

// 2. Apply button styles to the <a> links themselves
function gentlemans_nav_link_classes($atts, $item, $args)
{
    if ($args->theme_location === 'primary') {
        $is_active = in_array('current-menu-item', $item->classes) || in_array('current-page-ancestor', $item->classes);

        $base_classes = 'inline-block w-full md:w-auto text-center text-sm font-medium px-5 py-3 md:py-2 rounded border transition duration-200 ';
        $state_classes = $is_active
            ? 'border-gold text-gold bg-gold/15'
            : 'border-border-dark text-text-muted hover:text-text-main hover:border-gold';

        $atts['class'] = $base_classes . $state_classes;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'gentlemans_nav_link_classes', 10, 3);

// 1. Register the "Services" post type
function gentlemans_register_services_cpt()
{
    register_post_type('service', [
        'labels' => [
            'name'               => 'Services',
            'singular_name'      => 'Service',
            'add_new'            => 'Add New Service',
            'add_new_item'       => 'Add New Service',
            'edit_item'          => 'Edit Service',
            'all_items'          => 'All Services',
            'menu_name'          => 'Services',
        ],
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-scissors',
        'supports'     => ['title', 'editor'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'gentlemans_register_services_cpt');

// 2. Add fields: Price and Duration
function gentlemans_add_service_metaboxes()
{
    add_meta_box(
        'service_details_box',
        'Service Details',
        'gentlemans_render_service_metabox',
        'service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'gentlemans_add_service_metaboxes');

function gentlemans_render_service_metabox($post)
{
    $price = get_post_meta($post->ID, '_service_price', true);
    $duration = get_post_meta($post->ID, '_service_duration', true);
    wp_nonce_field('save_service_meta', 'service_meta_nonce');
?>
    <p>
        <label for="service_price"><strong>Price (e.g. $65 / £55):</strong></label><br>
        <input type="text" name="service_price" id="service_price" value="<?php echo esc_attr($price); ?>" style="width: 100%; max-width: 300px; margin-top: 5px;">
    </p>
    <p>
        <label for="service_duration"><strong>Duration (e.g. 45 Mins):</strong></label><br>
        <input type="text" name="service_duration" id="service_duration" value="<?php echo esc_attr($duration); ?>" style="width: 100%; max-width: 300px; margin-top: 5px;">
    </p>
<?php
}

// 3. Retain the price and duration when clicking "Publish"
function gentlemans_save_service_meta($post_id)
{
    if (!isset($_POST['service_meta_nonce']) || !wp_verify_nonce($_POST['service_meta_nonce'], 'save_service_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['service_price'])) {
        update_post_meta($post_id, '_service_price', sanitize_text_field($_POST['service_price']));
    }
    if (isset($_POST['service_duration'])) {
        update_post_meta($post_id, '_service_duration', sanitize_text_field($_POST['service_duration']));
    }
}
add_action('save_post', 'gentlemans_save_service_meta');

// Registering theme settings (Title, Hero section text, Social media, Footer)
function barber_customize_register($wp_customize)
{

    // Section 1: Hero Section
    $wp_customize->add_section('hero_section', array(
        'title'    => 'Hero Section (Main screen)',
        'priority' => 30,
    ));

    $wp_customize->add_setting('hero_badge', array(
        'default'           => 'ESTABLISHED IN 2018 • LONDON & NEW YORK',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_badge', array(
        'label'    => 'Top slogan',
        'section'  => 'hero_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('hero_title', array(
        'default'           => 'TIMELESS CRAFTSMANSHIP. UNCOMPROMISING LUXURY.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hero_title', array(
        'label'    => 'Main Heading',
        'section'  => 'hero_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('hero_desc', array(
        'default'           => 'Experience traditional wet razor shaves, signature scissor cuts, and master-grade beard sculpting in an exclusive private lounge.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hero_desc', array(
        'label'    => 'Text under the heading',
        'section'  => 'hero_section',
        'type'     => 'textarea',
    ));


    // Section 2: Social Media
    $wp_customize->add_section('social_section', array(
        'title'    => 'Social media links',
        'priority' => 35,
    ));

    // Instagram
    $wp_customize->add_setting('social_instagram', array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('social_instagram', array('label' => 'Instagram URL', 'section' => 'social_section', 'type' => 'url'));

    // Facebook
    $wp_customize->add_setting('social_facebook', array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('social_facebook', array('label' => 'Facebook URL', 'section' => 'social_section', 'type' => 'url'));

    // YouTube
    $wp_customize->add_setting('social_youtube', array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('social_youtube', array('label' => 'YouTube URL', 'section' => 'social_section', 'type' => 'url'));

    // X (Twitter)
    $wp_customize->add_setting('social_x', array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('social_x', array('label' => 'X (Twitter) URL', 'section' => 'social_section', 'type' => 'url'));

    // TikTok
    $wp_customize->add_setting('social_tiktok', array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('social_tiktok', array('label' => 'TikTok URL', 'section' => 'social_section', 'type' => 'url'));


    // Section 3: Footer Settings
    $wp_customize->add_section('footer_section', array(
        'title'    => 'Basement (Contact Information and Opening Hours)',
        'priority' => 40,
    ));

    // Text under the logo
    $wp_customize->add_setting('footer_about', array(
        'default'           => 'Where gentlemanly traditions meet contemporary mastery. Operating flagship suites in London Mayfair and New York Soho.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('footer_about', array(
        'label'    => 'Text under the logo',
        'section'  => 'footer_section',
        'type'     => 'textarea',
    ));

    // London address
    $wp_customize->add_setting('footer_addr_london', array(
        'default'           => '42 Old Bond Street, Mayfair, W1S 4LZ',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_addr_london', array(
        'label'    => 'Address (London Suite)',
        'section'  => 'footer_section',
        'type'     => 'text',
    ));

    // New York Address
    $wp_customize->add_setting('footer_addr_ny', array(
        'default'           => '118 Mercer Street, SoHo, NY 10012',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_addr_ny', array(
        'label'    => 'Address (New York Suite)',
        'section'  => 'footer_section',
        'type'     => 'text',
    ));

    // Email
    $wp_customize->add_setting('footer_email', array(
        'default'           => 'concierge@reservecraft.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('footer_email', array(
        'label'    => 'Concierge email',
        'section'  => 'footer_section',
        'type'     => 'text',
    ));

    // Hours: Mon Fri
    $wp_customize->add_setting('footer_hours_mf', array(
        'default'           => '08:30 AM – 08:00 PM',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_hours_mf', array(
        'label'    => 'Hours: Mon – Fri',
        'section'  => 'footer_section',
        'type'     => 'text',
    ));

    // Hours: Saturday
    $wp_customize->add_setting('footer_hours_sat', array(
        'default'           => '09:00 AM – 07:00 PM',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_hours_sat', array(
        'label'    => 'Hours: Saturday',
        'section'  => 'footer_section',
        'type'     => 'text',
    ));

    // Hours: Sunday
    $wp_customize->add_setting('footer_hours_sun', array(
        'default'           => '10:00 AM – 05:00 PM',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_hours_sun', array(
        'label'    => 'Hours: Sunday',
        'section'  => 'footer_section',
        'type'     => 'text',
    ));

    // Section 4: Craft & Gallery Page Header
    $wp_customize->add_section('craft_header_section', array(
        'title'    => 'Page Craft (Cap)',
        'priority' => 45,
    ));

    // Top badge
    $wp_customize->add_setting('craft_badge', array(
        'default'           => 'PORTFOLIO & LOOKBOOK',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('craft_badge', array(
        'label'    => 'Top slogan (badge)',
        'section'  => 'craft_header_section',
        'type'     => 'text',
    ));

    // Page title
    $wp_customize->add_setting('craft_title', array(
        'default'           => "MASTER CRAFTS & CLIENT\nSTYLES",
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('craft_title', array(
        'label'    => 'Main Heading',
        'section'  => 'craft_header_section',
        'type'     => 'textarea',
    ));

    // Description under the heading
    $wp_customize->add_setting('craft_desc', array(
        'default'           => 'Explore cuts and master grooming crafted inside our London & Manhattan parlours.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('craft_desc', array(
        'label'    => 'Description text',
        'section'  => 'craft_header_section',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'barber_customize_register');

function gentlemans_register_barbers_cpt()
{
    register_post_type('barber', [
        'labels' => [
            'name'               => 'Barbers',
            'singular_name'      => 'Barber',
            'add_new'            => 'Add New Barber',
            'add_new_item'       => 'Add New Barber',
            'edit_item'          => 'Edit Barber',
            'all_items'          => 'All Barbers',
            'menu_name'          => 'Barbers',
        ],
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-businessperson',
        'supports'     => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'gentlemans_register_barbers_cpt');

function gentlemans_add_barber_metaboxes()
{
    add_meta_box(
        'barber_details_box',
        'Barber Information',
        'gentlemans_render_barber_metabox',
        'barber',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'gentlemans_add_barber_metaboxes');

function gentlemans_render_barber_metabox($post)
{
    $role = get_post_meta($post->ID, '_barber_role', true);
    $level = get_post_meta($post->ID, '_barber_level', true) ?: 'senior';
    wp_nonce_field('save_barber_meta', 'barber_meta_nonce');
?>
    <p>
        <label for="barber_role"><strong>Job title and location (e.g., Head of Styling London):</strong></label><br>
        <input type="text" name="barber_role" id="barber_role" value="<?php echo esc_attr($role); ?>" style="width: 100%; max-width: 450px; margin-top: 5px;">
    </p>
    <p>
        <label for="barber_level"><strong>Master Rank:</strong></label><br>
        <select name="barber_level" id="barber_level" style="margin-top: 5px; min-width: 250px;">
            <option value="senior" <?php selected($level, 'senior'); ?>>Senior Craftsman</option>
            <option value="junior" <?php selected($level, 'junior'); ?>>Junior / Apprentice</option>
        </select>
    </p>
<?php
}

function gentlemans_save_barber_meta($post_id)
{
    if (!isset($_POST['barber_meta_nonce']) || !wp_verify_nonce($_POST['barber_meta_nonce'], 'save_barber_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['barber_role'])) {
        update_post_meta($post_id, '_barber_role', sanitize_text_field($_POST['barber_role']));
    }
    if (isset($_POST['barber_level'])) {
        update_post_meta($post_id, '_barber_level', sanitize_text_field($_POST['barber_level']));
    }
}
add_action('save_post', 'gentlemans_save_barber_meta');

// 1. CPT registration for the transformations gallery (Lookbook)
function gentlemans_register_transformations_cpt()
{
    register_post_type('transformation', [
        'labels' => [
            'name'          => 'Transformations',
            'singular_name' => 'Transformation',
            'add_new'       => 'Add New Transformation',
            'add_new_item'  => 'Add New Transformation',
            'edit_item'     => 'Edit Transformation',
            'all_items'     => 'All Transformations',
            'menu_name'     => 'Lookbook / Gallery',
        ],
        'public'              => true,
        'publicly_queryable'  => false, 
        'exclude_from_search' => true,  
        'has_archive'         => false,
        'menu_icon'           => 'dashicons-camera-alt',
        'supports'            => ['title', 'thumbnail'],
        'show_in_rest'        => true,
    ]);
}
add_action('init', 'gentlemans_register_transformations_cpt');

// 2. Metabox for the master’s signature and location (e.g., Master Barber Arthur • London)
function gentlemans_add_transformation_metaboxes()
{
    add_meta_box(
        'transformation_details_box',
        'Craft Details',
        'gentlemans_render_transformation_metabox',
        'transformation',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'gentlemans_add_transformation_metaboxes');

function gentlemans_render_transformation_metabox($post)
{
    $barber_info = get_post_meta($post->ID, '_transformation_barber', true);
    wp_nonce_field('save_transformation_meta', 'transformation_meta_nonce');
?>
    <p>
        <label for="transformation_barber"><strong>Stylist and salon (e.g., Master Barber Arthur • London):</strong></label><br>
        <input type="text" name="transformation_barber" id="transformation_barber"
            value="<?php echo esc_attr($barber_info); ?>"
            style="width: 100%; max-width: 450px; margin-top: 5px;">
    </p>
<?php
}

function gentlemans_save_transformation_meta($post_id)
{
    if (!isset($_POST['transformation_meta_nonce']) || !wp_verify_nonce($_POST['transformation_meta_nonce'], 'save_transformation_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['transformation_barber'])) {
        update_post_meta($post_id, '_transformation_barber', sanitize_text_field($_POST['transformation_barber']));
    }
}
add_action('save_post', 'gentlemans_save_transformation_meta');
