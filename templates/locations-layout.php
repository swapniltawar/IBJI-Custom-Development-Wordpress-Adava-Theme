<?php
/**
 * Blog-layout template.
 *
 * @author     ThemeFusion
 * @copyright  (c) Copyright by ThemeFusion
 * @link       http://theme-fusion.com
 * @package    Avada
 * @subpackage Core
 * @since      1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) { exit( 'Direct script access denied.' ); }

global $wp_query;

// Set the correct post container layout classes.
$blog_layout = 'medium-alternate';
$pagination_type = 'Infinite Scroll';
$post_class  = 'fusion-post-' . $blog_layout;

$container_class = 'fusion-posts-container ';
$wrapper_class = 'fusion-blog-layout-' . $blog_layout . '-wrapper ';

if ( 'grid' === $blog_layout || 'masonry' === $blog_layout ) {
	$container_class .= 'fusion-blog-layout-grid fusion-blog-layout-grid-3 isotope ';

	if ( 'masonry' === $blog_layout ) {
		$container_class .= 'fusion-blog-layout-' . $blog_layout . ' ';
	}
} else if ( 'timeline' !== $blog_layout ) {
	$container_class .= 'fusion-blog-layout-' . $blog_layout . ' ';
}

if ( ! Avada()->settings->get( 'post_meta' ) || ( ! Avada()->settings->get( 'post_meta_author' ) && ! Avada()->settings->get( 'post_meta_date' ) && ! Avada()->settings->get( 'post_meta_cats' ) && ! Avada()->settings->get( 'post_meta_tags' ) && ! Avada()->settings->get( 'post_meta_comments' ) && ! Avada()->settings->get( 'post_meta_read' ) ) ) {
	$container_class .= 'fusion-no-meta-info ';
}

// Set class for scrolling type.
if ( 'Infinite Scroll' === $pagination_type ) {
	$container_class .= 'fusion-posts-container-infinite ';
	$wrapper_class .= 'fusion-blog-infinite ';
} else if ( 'load_more_button' === $pagination_type ) {
	$container_class .= 'fusion-posts-container-infinite fusion-posts-container-load-more ';
} else {
	$container_class .= 'fusion-blog-pagination ';
}

if ( ! Avada()->settings->get( 'featured_images' ) ) {
	$container_class .= 'fusion-blog-no-images ';
}

// Add class if rollover is enabled.
if ( Avada()->settings->get( 'image_rollover' ) && Avada()->settings->get( 'featured_images' ) ) {
	$container_class .= ' fusion-blog-rollover';
}

$number_of_pages = $wp_query->max_num_pages;
if ( is_search() && Avada()->settings->get( 'search_results_per_page' ) ) {
	$number_of_pages = ceil( $wp_query->found_posts / Avada()->settings->get( 'search_results_per_page' ) );
}
?>
<div id="posts-container" class="fusion-blog-archive facetwp-template <?php echo esc_attr( $wrapper_class ); ?>fusion-clearfix">
	<div class="<?php echo esc_attr( $container_class ); ?>" data-pages="<?php echo (int) $number_of_pages; ?>">
        
    <?php // Start the main loop. ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <?php
            // Variables
            //$display_name = get_field('display_name');
            //$fields = get_field_objects();

            $locationFields = get_fields(); // Get all the fields for each doctor
            
            $link = get_permalink();
            $location_image = $locationFields['profile_image'];
            $address1 = $locationFields['address_line_1'];
            $address2 = $locationFields['address_line_2'];
            $city = $locationFields['city'];
            $state = $locationFields['state'];
            $zip = $locationFields['zip_code'];
            $mainPhone = $locationFields['main_phone'];
        ?>
        <?php
        // Set the time stamps for timeline month/year check.
        $alignment_class = '';
        if ( 'timeline' === $blog_layout ) {
            $post_timestamp = get_the_time( 'U' );
            $post_month     = date( 'n', $post_timestamp );
            $post_year      = get_the_date( 'Y' );
            $current_date   = get_the_date( 'Y-n' );

            // Set the correct column class for every post.
            if ( $post_count % 2 ) {
                $alignment_class = 'fusion-left-column';
            } else {
                $alignment_class = 'fusion-right-column';
            }

            // Set the timeline month label.
            if ( $prev_post_month != $post_month || $prev_post_year != $post_year ) {

                if ( $post_count > 1 ) {
                    echo '</div>';
                }
                echo '<h3 class="fusion-timeline-date">' . get_the_date( Avada()->settings->get( 'timeline_date_format' ) ) . '</h3>';
                echo '<div class="fusion-collapse-month">';
            }
        }
        $post_classes = array(
            $post_class,
            $alignment_class,
            $thumb_class,
            $element_orientation_class,
            'post',
            'fusion-clearfix',
        );
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?>>
            <?php if ( 'grid' === $blog_layout || 'masonry' === $blog_layout ) : ?>
                <?php // Add an additional wrapper for grid layout border. ?>
                <div class="fusion-post-wrapper">
            <?php endif; ?>

            <?php if ( ( ( is_search() && Avada()->settings->get( 'search_featured_images' ) ) || ( ! is_search() && Avada()->settings->get( 'featured_images' ) ) ) && 'large-alternate' !== $blog_layout ) : ?>
               	<?php
					if ( 'masonry' === $blog_layout ) {
						echo $image; // WPCS: XSS ok.
					}
                    elseif ( 'grid' === $blog_layout ) {
                        if ($location_image) {
                            echo  '<div class="fusion-image-wrapper"><img src="'. $location_image['url'] .'" alt="'. $location_image['alt'] .'"/></div>';
                        } else {
                            echo  '<div class="fusion-image-wrapper"><img src="'. content_url() .'/plugins/wp-posts-carousel/images/placeholder.png" alt="placeholder"/></div>';
                        }
                    }
                    else {
						// Get featured images for all but large-alternate layout.
						//get_template_part( 'new-slideshow' );
                        if ($location_image) {
                            echo  '<div class="fusion-image-wrapper"><img src="'. $location_image['url'] .'" alt="'. $location_image['alt'] .'"/></div>';
                        } else {
                            echo  '<div class="fusion-image-wrapper"><img src="'. content_url() .'/plugins/wp-posts-carousel/images/placeholder.png" alt="placeholder"/></div>';
                        }
					}
				?>
            <?php endif; ?>

            <?php if ( 'grid' === $blog_layout || 'masonry' === $blog_layout || 'timeline' === $blog_layout ) : ?>
                <?php // The post-content-wrapper is only needed for grid and timeline. ?>
                <div class="fusion-post-content-wrapper">
            <?php endif; ?>

            <div class="fusion-post-content post-content Locations">
                <?php echo avada_render_post_title( $post->ID ); // WPCS: XSS ok. ?>
                <div class="fusion-post-content-container">
                    <?php
                    /**
                     * The avada_blog_post_content hook.
                     *
                     * @hooked avada_render_blog_post_content - 10 (outputs the post content wrapped with a container).
                     */
                    //do_action( 'avada_blog_post_content' );
                    ?>
                    <?php 
                        if ($address1):
                            if ($address2):
                                $fullAddress = $address1 . '<br>' . $address2 . '<br>' . $city . ', ' . $state . '&nbsp;' . $zip;
                            else :
                                $fullAddress = $address1 . '<br>' . $city . ', ' . $state . '&nbsp;' . $zip;
                            endif;
                            echo '<p class="Address">' . $fullAddress .'</p>';
                        endif;
                        if ($mainPhone):
                            echo '<p><strong>Main:&nbsp;</strong><a href="tel:'. $mainPhone .'">'. $mainPhone .'</a></p>';
                        endif;
                    ?>
                </div>
            </div>
            
            <?php if ( 'grid' === $blog_layout || 'masonry' === $blog_layout || 'timeline' === $blog_layout ) : ?>
                </div>
            <?php endif; ?>

            <?php if ( 'grid' === $blog_layout || 'masonry' === $blog_layout ) : ?>
                </div>
            <?php endif; ?>
        </article>
    <?php endwhile; ?>
</div>

	<?php // If infinite scroll with "load more" button is used. ?>
	<?php if ( 'load_more_button' === $pagination_type && 1 < $number_of_pages ) : ?>
		<div class="fusion-load-more-button fusion-blog-button fusion-clearfix">
			<?php echo esc_textarea( apply_filters( 'avada_load_more_posts_name', esc_attr__( 'Load More Posts', 'Avada' ) ) ); ?>
		</div>
	<?php endif; ?>
	<?php if ( 'timeline' === $blog_layout ) : ?>
	</div>
	<?php endif; ?>
<?php // Get the pagination. ?>
<?php fusion_pagination( '', 2 ); ?>
</div>
<script type="text/javascript">
    var $ = jQuery;
    $(window).load(function(){
        //FWP.auto_refresh = false;

        // Reset filters when click on button
        $('button.Reset').click(function() {
            FWP.reset();
        });
        // Apply filters when click on button
        $('button.Apply').click(function() {
            FWP.refresh();
        });        
    });
    
    //Disable Apply button while ajax is happening
    jQuery(document).ajaxStart(function(){
       $('button.Apply').prop( "disabled", true );
    });
    jQuery(document).ajaxComplete(function(){
        $('button.Apply').prop( "disabled", false );
    });
   
    // Add this back in if you change the layout from medium-alternate to grid
//    jQuery(document).ajaxComplete(function(event, request, settings) { 
//        if(settings.url === window.location.href) { 
//            jQuery(window).load();
//        } 
//    });
</script>

<?php

wp_reset_postdata();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */