<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {

	load_child_theme_textdomain( genesis_get_theme_handle(), get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}


// Registers the responsive menus.
if ( function_exists( 'genesis_register_responsive_menus' ) ) {
	genesis_register_responsive_menus( genesis_get_config( 'responsive-menus' ) );
}

add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles() {

	$appearance = genesis_get_config( 'appearance' );

	wp_enqueue_style(
		genesis_get_theme_handle() . '-fonts',
		$appearance['fonts-url'],
		[],
		genesis_get_theme_version()
	);

	wp_enqueue_style( 'dashicons' );

	if ( genesis_is_amp() ) {
		wp_enqueue_style(
			genesis_get_theme_handle() . '-amp',
			get_stylesheet_directory_uri() . '/lib/amp/amp.css',
			[ genesis_get_theme_handle() ],
			genesis_get_theme_version()
		);
	}

}

add_action( 'after_setup_theme', 'genesis_sample_theme_support', 9 );
/**
 * Add desired theme supports.
 *
 * See config file at `config/theme-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_theme_support() {

	$theme_supports = genesis_get_config( 'theme-supports' );

	foreach ( $theme_supports as $feature => $args ) {
		add_theme_support( $feature, $args );
	}

}

add_action( 'after_setup_theme', 'genesis_sample_post_type_support', 9 );
/**
 * Add desired post type supports.
 *
 * See config file at `config/post-type-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_post_type_support() {

	$post_type_supports = genesis_get_config( 'post-type-supports' );

	foreach ( $post_type_supports as $post_type => $args ) {
		add_post_type_support( $post_type, $args );
	}

}

// Adds image sizes.
add_image_size( 'sidebar-featured', 75, 75, true );
add_image_size( 'genesis-singular-images', 702, 526, true );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}
function enqueue_scripts_styles() {
	 wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.8.2/css/all.css' );

}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts_styles' );





add_action( 'genesis_after_header', 'full_featured_title',1 );
function full_featured_title() {
	// if ( is_singular() && has_post_thumbnail() ){

		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

		// echo '<div id="full-image" style="background:url('.$bg .');">';

		if ( is_singular()){
			echo '<div class="full-width-title d-flex" style=""><div class="wrap">';
						echo '<div class="cell">';
							genesis_do_post_title();
						echo '</div>';
						echo '<div class="cell">';
							genesis_do_breadcrumbs();
						echo '</div>';
			echo '</div></div>';
		}
	}

//* Remove 'You are here' texts in Genesis Framework breadcrumb
	add_filter( 'genesis_breadcrumb_args', 'afn_breadcrumb_args' );
	function afn_breadcrumb_args( $args ) {
		$args['labels']['prefix'] = '';
	return $args;
	}
	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Customize the credits
	add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
	function sp_footer_creds_text() {
		echo '<div class="creds"><p>';
		echo 'Copyright &copy; ';
		echo date('Y');
		echo ' &middot; Lehman Roofing, Inc &middot; Developed by <a href="https://www.kemperwebteam.com" title="Kemper Technology Consulting">Kemper Technology Consulting</a>';
		echo '</p></div>';
	}
	genesis_register_sidebar(array(
		     'name' => 'Utility Bar',
		     'description' => 'Utility Bar for mobile layouts',
		     'id' => 'utility-bar'
		 ));
	add_action( 'genesis_header', 'utility_bar', 4 );

//* Add Utility Bar above header
	function utility_bar() {
		echo '<div class="utility-bar">';
	 	genesis_widget_area( 'utility-bar', array(
	 		'before' => '<div class="wrap">',
	 		'after' => '</div>',
	 		) );
	 	echo '</div>';
	 }

//* Registers front-page widget areas.
	 for ( $i = 1; $i <= 5; $i++ ) {
	     genesis_register_widget_area(
	         array(
	             'id'          => "front-page-{$i}",
	             'name'        => __( "Front Page {$i}", 'genesis-sample' ),
	             'description' => __( "This is the front page {$i} section.", 'genesis-sample' ),
	         )
	     );
	 }


	 /** Add the featured image section */



// remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
// remove_action( 'genesis_entry_header', 'single_post_featured_image', 8 );

add_action('genesis_before_content_sidebar_wrap', 'page_featured_image',1 );
function page_featured_image() {
	$bg = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'full' );
	echo '<section class="full-image" style="background-image: url('. $bg .')">';
	echo '</section>';

}

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));



}
