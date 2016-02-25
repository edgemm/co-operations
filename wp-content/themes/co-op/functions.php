<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Edge User Role
include( 'inc/edge/user-roles.php' );

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (function_exists('add_theme_support')) {
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 1024, '', true); // Large Thumbnail
    add_image_size('medium', 300, '', true); // Medium Thumbnail
    add_image_size('small', 150, '', true); // Small Thumbnail

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav() {
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul class="menu">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function add_scripts() {
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        wp_register_script('coopScripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('coopScripts'); // Enqueue it!
    }
}

// Load HTML5 Blank styles
function add_styles() {

    wp_register_style('edgemm-styles', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('edgemm-styles'); // Enqueue it!
}

// Register HTML5 Blank Navigation
function register_menu() {
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '') {
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var) {
    return is_array($var) ? array() : '';
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes) {
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '') {
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more) {
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag) {
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults) {
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'add_scripts'); // Add Custom Scripts to wp_head
add_action('wp_enqueue_scripts', 'add_styles'); // Add Theme Stylesheet
add_action('init', 'register_menu'); // Add HTML5 Blank Menu
add_action('init', 'create_post_types'); // Add Custom Post Types

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether


/*------------------------------------*\
	Widget Areas
\*------------------------------------*/

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar')) {

    // Define Pre-footer Widget Area
    register_sidebar(array(
        'name' => __('Pre-Footer', 'html5blank'),
        'description' => __('', 'html5blank'),
        'id' => 'widget-pre-footer',
        'before_widget' => '<div id="%1$s" class="%2$s text-center">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgit-header">',
        'after_title' => '</h3>'
    ));

}


/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

function create_post_types() {

	// services
	register_post_type( 'services',
		array(
		'labels' => array(
			'name'			=> _x( 'Services', 'services' ),
			'singular_name'		=> _x( 'Service', 'services' ),
			'add_new'		=> _x( 'Add New Service', 'services' ),
			'add_new_item'		=> _x( 'Add New Service', 'services' ),
			'edit_item'		=> _x( 'Edit Service', 'services' ),
			'new_item'		=> _x( 'New Service', 'services' ),
			'view_item'		=> _x( 'View Service', 'services' ),
			'search_items'		=> _x( 'Search Services', 'services' ),
			'not_found'		=> _x( 'No services found', 'services' ),
			'not_found_in_trash'	=> _x( 'No services found in Trash', 'services' ),
			'parent_item_colon'	=> _x( 'Parent Service:', 'services' ),
			'menu_name'		=> _x( 'Services', 'services' ),
		),
		'hierarchical'		=> true,
		'supports'		=> array(
			'title',
			'editor',
			'thumbnail',
			'page-attributes'
		),
		'public'		=> true,
		'show_ui'		=> true,
		'menu_position'		=> 20,
		'menu_icon'		=> 'dashicons-cart',
		'show_in_nav_menus'	=> false,
		'publicly_queryable'	=> true,
		'exclude_from_search'	=> true,
		'has_archive'		=> false,
		'query_var'		=> true,
		'can_export'		=> true,
		'rewrite'		=> true,
		'capability_type'	=> 'post'
	));

	// technologies
	register_post_type( 'technologies',
		array(
		'label'			=> 'technologies',
		'description'		=> 'Technology Description',
		'labels'		=> array(
			'name'			=> _x( 'Technologies', 'technologies' ),
			'singular_name'		=> _x( 'Technology', 'technologies' ),
			'menu_name'		=> _x( 'Technologies', 'technologies' ),
			'name_admin_bar'	=> _x( 'Technology', 'technologies' ),
			'parent_item_colon'	=> _x( 'Parent Technology:', 'technologies' ),
			'all_items'		=> _x( 'All Technologies', 'technologies' ),
			'add_new_item'		=> _x( 'Add Technology', 'technologies' ),
			'add_new'		=> _x( 'Add Technology', 'technologies' ),
			'new_item'		=> _x( 'New Technology', 'technologies' ),
			'edit_item'		=> _x( 'Edit Technology', 'technologies' ),
			'update_item'		=> _x( 'Update Technology', 'technologies' ),
			'view_item'		=> _x( 'View Technology', 'technologies' ),
			'search_items'		=> _x( 'Search Technologies', 'technologies' ),
			'not_found'		=> _x( 'Technology not found', 'technologies' ),
			'not_found_in_trash'	=> _x( 'Not found in Trash', 'technologies' )
		),
		'supports'		=> array(
			'title',
			'editor',
			'thumbnail'
		),
		'public'		=> true,
		'show_ui'		=> true,
		'show_in_menu'		=> true,
		'menu_position'		=> 20,
		'menu_icon'		=> 'dashicons-admin-generic',
		'show_in_admin_bar'	=> true,
		'show_in_nav_menus'	=> false,
		'can_export'		=> true,
		'has_archive'		=> false,
		'exclude_from_search'	=> true,
		'publicly_queryable'	=> true,
		'capability_type'	=> 'page'
	));

	// technologies
	register_post_type( 'team',
		array(
		'label'			=> 'team',
		'description'		=> 'Team Member Description',
		'labels'		=> array(
			'name'			=> _x( 'Team Member', 'team' ),
			'singular_name'		=> _x( 'Team Member', 'team' ),
			'menu_name'		=> _x( 'Team Members', 'team' ),
			'name_admin_bar'	=> _x( 'Team Member', 'team' ),
			'parent_item_colon'	=> _x( 'Parent Team Member:', 'team' ),
			'all_items'		=> _x( 'All Team Members', 'team' ),
			'add_new_item'		=> _x( 'Add Team Member', 'team' ),
			'add_new'		=> _x( 'Add Team Member', 'team' ),
			'new_item'		=> _x( 'New Team Member', 'team' ),
			'edit_item'		=> _x( 'Edit Team Member', 'team' ),
			'update_item'		=> _x( 'Update Team Member', 'team' ),
			'view_item'		=> _x( 'View Team Member', 'team' ),
			'search_items'		=> _x( 'Search Team Members', 'team' ),
			'not_found'		=> _x( 'Team Member not found', 'team' ),
			'not_found_in_trash'	=> _x( 'Not found in Trash', 'team' )
		),
		'supports'		=> array(
			'title',
			'editor',
			'thumbnail'
		),
		'public'		=> true,
		'show_ui'		=> true,
		'show_in_menu'		=> true,
		'menu_position'		=> 20,
		'menu_icon'		=> 'dashicons-groups',
		'show_in_admin_bar'	=> true,
		'show_in_nav_menus'	=> false,
		'can_export'		=> true,
		'has_archive'		=> false,
		'exclude_from_search'	=> true,
		'publicly_queryable'	=> true,
		'capability_type'	=> 'post',
	));

}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

?>
