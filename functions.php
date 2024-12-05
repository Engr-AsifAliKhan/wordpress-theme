<?php
// Theme setup function
function my_custom_theme_setup() {
    add_theme_support('title-tag');
    register_nav_menus(array('primary' => __('Primary Menu', 'my-custom-theme')));
}

add_action('after_setup_theme', 'my_custom_theme_setup');

// Enqueue styles
function my_custom_theme_scripts() {
    wp_enqueue_style('main-style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'my_custom_theme_scripts');

// Register Custom Post Type for Projects
function my_custom_post_type_projects() {
    $args = array(
        'labels' => array(
            'name' => __('Projects', 'my-custom-theme'),
            'singular_name' => __('Project', 'my-custom-theme')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'projects'),
    );
    register_post_type('project', $args);
}

add_action('init', 'my_custom_post_type_projects');

// Add custom meta boxes for project details
function add_project_meta_boxes() {
    add_meta_box(
        'project_details',
        __('Project Details', 'my-custom-theme'),
        'project_details_callback',
        'project',
        'normal',
        'high'
    );
}

// Callback function to display project details fields in the admin
function project_details_callback($post) {
    wp_nonce_field(basename(__FILE__), 'project_fields_nonce');
    ?>
    <p>
        <label for="project_start_date"><?php _e('Project Start Date', 'my-custom-theme'); ?></label>
        <input type="date" name="project_start_date" id="project_start_date" value="<?php echo esc_attr(get_post_meta($post->ID, 'project_start_date', true)); ?>" />
    </p>
    <p>
        <label for="project_end_date"><?php _e('Project End Date', 'my-custom-theme'); ?></label>
        <input type="date" name="project_end_date" id="project_end_date" value="<?php echo esc_attr(get_post_meta($post->ID, 'project_end_date', true)); ?>" />
    </p>
    <p>
        <label for="project_url"><?php _e('Project URL', 'my-custom-theme'); ?></label>
        <input type="url" name="project_url" id="project_url" value="<?php echo esc_attr(get_post_meta($post->ID, 'project_url', true)); ?>" />
    </p>
    <?php
}

// Save project details when saving the post
function save_project_details($post_id) {
    // Verify nonce for security
    if (!isset($_POST['project_fields_nonce']) || !wp_verify_nonce($_POST['project_fields_nonce'], basename(__FILE__))) {
        return;
    }

    // Avoid autosave and prevent overwriting on bulk updates
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Sanitize and save custom fields
    if (isset($_POST['project_start_date'])) {
        update_post_meta($post_id, 'project_start_date', sanitize_text_field($_POST['project_start_date']));
    }
    if (isset($_POST['project_end_date'])) {
        update_post_meta($post_id, 'project_end_date', sanitize_text_field($_POST['project_end_date']));
    }
    if (isset($_POST['project_url'])) {
        update_post_meta($post_id, 'project_url', esc_url_raw($_POST['project_url']));
    }
}

add_action('add_meta_boxes', 'add_project_meta_boxes');
add_action('save_post', 'save_project_details');

// Enqueue jQuery and custom scripts
function my_theme_enqueue_scripts() {
    // Enqueue jQuery (WordPress comes with jQuery by default)
    wp_enqueue_script('jquery');
    
    // Enqueue custom.js (your custom JavaScript file)
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

// Add custom classes to navigation menu items
function add_custom_classes_to_nav_menu($classes, $item, $args, $depth) {
    // Check if the menu item has children (for dropdowns)
    if (in_array('menu-item-has-children', $classes)) {
        $classes[] = 'has-children'; // Add 'has-children' class for dropdown items
    }
    return $classes;
}

add_filter('nav_menu_css_class', 'add_custom_classes_to_nav_menu', 10, 4);

// Register custom API endpoint for projects
function register_project_api_endpoint() {
    register_rest_route('myapi/v1', '/projects', array(
        'methods' => 'GET',
        'callback' => 'get_projects_data',
        'permission_callback' => '__return_true', // No permission check, change if needed
    ));
}

add_action('rest_api_init', 'register_project_api_endpoint');

// Callback function to fetch project data for the custom API
function get_projects_data() {
    // Query to get all projects
    $args = array(
        'post_type' => 'project', // Custom post type 'project'
        'posts_per_page' => -1,  // Fetch all projects
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        $projects = array(); // Initialize array to store project data
        
        while ($query->have_posts()) {
            $query->the_post();  // Set up post data
            
            // Fetch custom fields (start date, end date, and project URL)
            $start_date = get_post_meta(get_the_ID(), 'project_start_date', true);
            $end_date = get_post_meta(get_the_ID(), 'project_end_date', true);
            $url = get_post_meta(get_the_ID(), 'project_url', true);
            
            // Add project data to array
            $projects[] = array(
                'title' => get_the_title(),
                'url' => $url,
                'start_date' => $start_date,
                'end_date' => $end_date,
            );
        }
        
        wp_reset_postdata();  // Reset post data after query
        
        // Return project data as JSON response
        return new WP_REST_Response($projects, 200);
    } else {
        return new WP_REST_Response('No projects found', 404);  // No projects found
    }
}
