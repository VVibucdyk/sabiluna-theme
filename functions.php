<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);

}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );

function theme_setup() {
    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'your-theme-textdomain' ),
    ] );
}
add_action( 'after_setup_theme', 'theme_setup' );

function child_theme_setup() {
    add_theme_support( 'custom-logo', [
        'flex-height' => true,
        'flex-width'  => true,
    ] );
}
add_action( 'after_setup_theme', 'child_theme_setup' );

function sabiluna_theme_styles() {
	wp_enqueue_style(
		'sabiluna-theme-style',
		get_stylesheet_uri(),
		[],
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_style( 'fonts', get_stylesheet_directory_uri() . '/assets/css/font.css');
	
}
add_action( 'wp_enqueue_scripts', 'sabiluna_theme_styles' );

// Register a new category.

function my_elementor_register_category() {
    \Elementor\Plugin::instance()->categories_manager->add_category(
        'sabiluna-block',
        [
            'title' => __( 'Custom Sabiluna Block', 'my-textdomain' ),
            'icon' => 'eicon-folder',
        ]
    );
}
add_action( 'elementor/categories/register', 'my_elementor_register_category' );

// Register the widget
function unidex_new_elements( $widgets_manager ) {
	require_once get_stylesheet_directory() . '/custom-widget/blog-loop/blog-loop-control.php';
	require_once get_stylesheet_directory() . '/custom-widget/PopularWidget/PopularWidgetControl.php';
    $widgets_manager->register( new \unidex_blog_loop() );
	$widgets_manager->register( new \PopularWidget() );
}
add_action('elementor/widgets/register','unidex_new_elements');

// ================ CUSTOM FUNCTION ===================

function unidex_order_by() {
    $aratum_orderby = array(
        'none'          => 'none',
        'ID'            => 'ID',
        'author'        => 'Author',
        'title'         => 'Title',
        'name'          => 'Name',
        'type'          => 'Type',
        'date'          => 'Date',
        'modified'      => 'Modifiede Time',
        'parent'        => 'Parent',
        'rand'          => 'Random',
        'comment_count' => 'Total Comment',
        'post_views_count'    => 'Popular'
    );

    return $aratum_orderby;
}

function get_custom_and_default_post_types() {
    // Get all public post types excluding built-in ones
    $args = array(
        'public'   => true,
        '_builtin' => false,
    );

    // Get the custom post types
    $custom_post_types = get_post_types( $args, 'objects' );

    // Add the default 'post' type manually
    $default_post_type = get_post_type_object( 'post' );
    if ( $default_post_type ) {
        $custom_post_types['post'] = $default_post_type;
    }

    // Exclude specific post types (e.g., those registered by Elementor)
    $exclude_post_types = array(
        'elementor_library', // Elementor templates
        'e-landing-page',    // Elementor landing pages
        // Add other post types to exclude here
    );

    // Filter out the excluded post types
    foreach ( $exclude_post_types as $exclude_post_type ) {
        if ( isset( $custom_post_types[ $exclude_post_type ] ) ) {
            unset( $custom_post_types[ $exclude_post_type ] );
        }
    }

    $arr = [];
    foreach($custom_post_types as $key => $val) {
        $arr[$key] = $val->name;
    }

    return $arr;
}

function unidex_get_category()
{
	$output_categories = array('All');
	$categories = get_categories();
	foreach ($categories as $category) {
		$output_categories[$category->cat_ID] = $category->name;
	}
	return $output_categories;
}

function getDifferentTime($givenDate = ""){
	// Create DateTime object for the given date
	$date1 = new DateTime($givenDate);

	// Create DateTime object for the current date/time
	$date2 = new DateTime();

	// Calculate the difference
	$interval = $date1->diff($date2);
	
	// Determine the appropriate format based on the difference
	if($interval->days < 1 && $interval->h < 1) {
		// Less than 1 hour, show minutes
		echo $interval->format('%i menit lalu');
	}elseif ($interval->days < 1) {
		// Less than 1 day, show hours and minutes
		echo $interval->format('%h jam lalu');
	} elseif ($interval->days < 30) {
		// Less than 1 month, show days, hours, and minutes
		echo $interval->format('%d hari lalu');
	} elseif ($interval->m < 12) {
		// Less than 1 year, show months and days
		echo $interval->format('%m bulan lalu');
	} else {
		// 1 year or more, show years, months, and days
		echo $interval->format('%y tahun lalu');
	}
}

// Function to track post views
function set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// Function to get post views
function get_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return '0 View';
    }
    return $count . ' Views';
}

// Track views on single post pages
function track_post_views($post_id) {
    if (!is_single()) return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    set_post_views($post_id);
}
add_action('wp_head', 'track_post_views');

// Prevents WordPress from prefetching to add post views
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// ================= END CUSTOM FUNCTION =================================