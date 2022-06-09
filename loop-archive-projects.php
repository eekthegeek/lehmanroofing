<?php



add_filter( 'body_class', 'custom_body_class' );
/**
 * Add `content-archive` class to the body element.
 *
 * @param  array $classes the current body classes
 * @return array $classes modified classes
 */
function custom_body_class( $classes ) {
    $classes[] = 'content-archive';

    return $classes;
}

function project_category_display() {
$curTerm = $wp_query->queried_object;
$cats  = array (
  'exclude' => 1,
  'taxonomy' => 'category',
);
$terms   = get_terms( $cats );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
    echo '<div class="project-toolbar" >';
    echo '<span><b> Filter by: </b></span>';
    echo '<button class="fil-cat" data-rel="projects">All</button>';
    foreach ( $terms as $term ) {
        $classes = array();
        if ( $term->name == $curTerm->name ) {
            $classes[] = 'active';

        }
        $term_name_lower = strtolower($term->name);
        echo '<button class="btn fil-cat" data-rel="category-' . $term_name_lower . '">' . $term->name . '</button>';
    }
    echo '</div>';
}
}
// Force full width content.
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Add opening div.articles tag before the latest post.
add_action( 'genesis_before_entry', function () {
    global $wp_query;
    $wp_query->set( 'posts_per_page', '-1' );
    if ( 0 === $wp_query->current_post && is_main_query() ) {
        echo '<div class="articles" id="portfolio">';
    }
} );



add_action ('genesis_before_loop', 'project_category_display',15 );




// Remove all hooks from genesis_entry_header, genesis_entry_content and genesis_entry_footer actions.
$hooks = array(
    'genesis_entry_header',
    'genesis_entry_content',
    'genesis_entry_footer',
);

foreach( $hooks as $hook ) {
    remove_all_actions( $hook );
}
function genesis_image_background(){

	$bg = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'large' );
  $link = get_the_permalink( $post_id );

  echo '<a href="'.$link.'"><div class="project-header" style="background-image: url('. $bg .')">';

  echo '</div></a>';
}
// Add featured image inside entry header.
add_action( 'genesis_entry_header', 'genesis_entry_header_markup_open' );
// add_action( 'genesis_entry_header', 'genesis_do_post_image' );
add_action( 'genesis_entry_header', 'genesis_image_background',1 );
add_action( 'genesis_entry_header', 'genesis_entry_header_markup_close' );

// Add entry title and entry meta in entry content.
add_action( 'genesis_entry_content', 'genesis_do_post_title' );
add_filter( 'genesis_post_meta', 'custom_post_meta_filter' );
/**
 * Customize entry meta.
 * @param  string $post_meta Existing entry meta
 * @return string            Modified entry meta
 */
function custom_post_meta_filter( $post_meta ) {
    $post_meta = '[post_categories before=""]';

    return $post_meta;
}



// Move .archive-pagination from under main.content to adjacent to it.
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
// add_action( 'genesis_after_content', 'genesis_posts_nav' );

// Add closing div tag (for .articles) after the last post.
add_action( 'genesis_after_endwhile', function () {
    if ( is_main_query() ) {
        echo '</div>';

    }
} );
