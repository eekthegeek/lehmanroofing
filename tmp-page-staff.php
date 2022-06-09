<?php
/**
 * Genesis Sample.
 *
 * This file adds the landing page template to the Genesis Sample Theme.
 *
 * Template Name: Staff Page
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */


 add_action ('genesis_after_entry_content', 'staff_grid', 5);
 function staff_grid() {
     $args = array(
         'post_type' => 'staff',
         'post_status' => 'publish',
         'order' => 'ASC',

         );
     $staff_member = '';
     $query = new WP_Query($args);
		if ( $query->have_posts() ) {
             echo '<h3>Staff Members</h3>';
             echo '<div class="flex-grid">';
			 while ( $query->have_posts()) : $query->the_post();
                 $bg = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'full' );
                     $first_name = get_field('first_name');
                     $last_name = get_field('last_name');
                 echo '<div class="col staff">';
                     echo '<div class="staff-image">';
                     echo the_post_thumbnail('full');
                     echo '</div>';
                 echo  '<h5 class="staff-title">';
                 echo  $first_name;
                 echo  ' ';
                 echo $last_name;
                 echo '</h5>';
                 echo "</div>";
             endwhile;
             echo '</div>';

        }
        else {

        }



 }
// This file handles pages, but only exists for the sake of child theme forward compatibility.
genesis();
