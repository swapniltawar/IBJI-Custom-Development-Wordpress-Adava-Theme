<?php
/**
 * Template used for single posts and other post-types
 * that don't have a specific template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); ?>

<section id="content" <?php Avada()->layout->add_style( 'content_style' ); ?>>
	<?php $post_pagination = get_post_meta( $post->ID, 'pyre_post_pagination', true ); ?>
	

	<?php while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class( 'staff' ); ?>>
			
            <?php
                // Variables
                $staffFields = get_fields();
            
                /* Above Tabs */
                $profile_image = $staffFields['profile_image'];
                $staffFirstName = $staffFields['first_name'];
                $staffMiddleName = $staffFields['middle_name'];
                $staffLastName = $staffFields['last_name'];
                $staffSuffix = $staffFields['suffix'];
                $staffFullName = "";
                $professionalTitles = $staffFields['professional_titles'];
                $jobTitle = $staffFields['job_title'];    
            
                /* Contact Tab */
                $appointmentPhone = $staffFields['appointment_phone'];
                $emailAddress = $staffFields['email_address'];
                $emailDisclaimer = $staffFields['email_disclaimer'];
                $practiceLocations = $staffFields['practice_locations'];
                
                /* Profile Tab */
                // Biography is simply the_post
                $biography = get_the_content();    
                // Education is a repeater field so these are inline down in the code block
                $certifications = $staffFields['certifications'];
                $printableProfile = $staffFields['printable_profile'];
            ?>	
            
            <?php if ( 'above' == Avada()->settings->get( 'blog_post_title' ) ) : ?>
				<?php if ( 'below_title' === Avada()->settings->get( 'blog_post_meta_position' ) ) : ?>
					<div class="fusion-post-title-meta-wrap">
				<?php endif; ?>
				<?php echo avada_render_post_title( $post->ID, false, '', '2' ); // WPCS: XSS ok. ?>
				<?php if ( 'below_title' === Avada()->settings->get( 'blog_post_meta_position' ) ) : ?>
					<?php echo avada_render_post_metadata( 'single' ); // WPCS: XSS ok. ?>
					</div>
				<?php endif; ?>
			<?php elseif ( 'disabled' == Avada()->settings->get( 'blog_post_title' ) && Avada()->settings->get( 'disable_date_rich_snippet_pages' ) && Avada()->settings->get( 'disable_rich_snippet_title' ) ) : ?>
				<span class="entry-title" style="display: none;"><?php the_title(); ?></span>
			<?php endif; ?>
            
            <div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth" style='background-color: rgba(255,255,255,0);background-position: center center;background-repeat: no-repeat;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;'>
                <div class="fusion-builder-row fusion-row ">
                    <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_4  fusion-one-fourth fusion-column-first 1_4" style='margin-top:0px;margin-bottom:20px;width:25%;width:calc(25% - ( ( 4% ) * 0.25 ) );margin-right: 4%;'>
                        <div class="fusion-column-wrapper" style="padding: 0px 0px 0px 0px;background-position:right bottom;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                            <div class="imageframe-align-center">
                                <span style="border:1px solid #ffffff;" class="fusion-imageframe imageframe-bottomshadow imageframe-1 element-bottomshadow hover-type-none">
                                     <?php
                                        if ($profile_image) {
                                            echo '<img src="'. $profile_image['url'] .'" alt="'. $profile_image['alt'] .'" class="img-responsive" />';
                                        } else { 
                                            // default placeholder image
                                            echo '<img src="/wp-content/plugins/wp-posts-carousel/images/placeholder.png" alt="placeholder" class="img-responsive" />';
                                        }
                                    ?>
                                </span></div>
                            <div class="fusion-clearfix"></div>
                        </div>
                    </div>
                    <div class="fusion-layout-column fusion_builder_column fusion_builder_column_3_4  fusion-three-fourth fusion-column-last 3_4" style='margin-top:0px;margin-bottom:20px;width:75%;width:calc(75% - ( ( 4% ) * 0.75 ) );'>
                        <div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                            <div class="fusion-title title fusion-title-size-one" style="margin-top:0px;margin-bottom:31px;">
                                <h1 class="title-heading-left" data-fontsize="42" data-lineheight="58">
                                    <?php 
                                        if ($staffMiddleName) {
                                            $staffFullName =  $staffFirstName ."&nbsp;". $staffMiddleName ."&nbsp;". $staffLastName;
                                        } else {
                                            $staffFullName = $staffFirstName ."&nbsp;". $staffLastName;
                                        }
                                        if ($staffSuffix) {
                                            $staffFullName = $staffFullName .", ". $staffSuffix;
                                        }    
                                        if ($professionalTitles) {
                                            echo $staffFullName .", ";
                                            $i = 1;
                                            $numOfTitles = count ($professionalTitles);
                                            foreach ( $professionalTitles as $professionalTitle ) {
                                                if ($numOfTitles >= 2):
                                                    if ($i < $numOfTitles): 
                                                        echo $professionalTitle->name.', '; 
                                                    else:
                                                        echo $professionalTitle->name;
                                                    endif;
                                                else:
                                                    echo $professionalTitle->name;
                                                endif;
                                                $i++;
                                            }
                                        } else {
                                            echo $staffFullName;
                                        }
                                    ?>
                                </h1>
                                
                                <div class="title-sep-container">
                                    <div class="title-sep sep-single sep-solid" style="border-color:#e0dede;"></div>
                                </div>
                            </div>
                            <div class="fusion-builder-row fusion-builder-row-inner fusion-row ">
                                <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-first fusion-one-half fusion-column-first 1_2" style='margin-top: 0px;margin-bottom: 20px;width:50%;width:calc(50% - ( ( 4% ) * 0.5 ) );margin-right:4%;'>
                                    <div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                                         <?php 
                                            if ($jobTitle) {
//                                                $i = 1;
//                                                $numOfTitles = count($professionalTitles);
//                                                if ($numOfTitles >= 2) {
//                                                    echo '<h5 class="SpecialtiesHeader">Titles</h5>';
//                                                } else {
//                                                    echo '<h5 class="SpecialtiesHeader">Title</h5>';
//                                                }
                                                echo '<ul class="Titles">';
                                                foreach ($jobTitle as $thisTitle) {
                                                    // List Speialties in List Format
                                                    echo '<li>'. $thisTitle->name .'</li>';
                                                }
                                                echo '</ul>';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-last BorderLeft fusion-one-half fusion-column-last BorderLeft 1_2" style='margin-top: 0px;margin-bottom: 0px;width:50%;width:calc(50% - ( ( 4% ) * 0.5 ) );'>
                                    <div class="fusion-column-wrapper" style="background-color:#f6f6f6;padding: 10px 20px 10px 20px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                                        <h4 data-fontsize="26" data-lineheight="33"><strong>To Make an Appointment</strong></h4>
                                        <?php
                                            if ($appointmentPhone) :
                                                echo '<p><strong>Call <a href="tel:'. $appointmentPhone .'">'. $appointmentPhone .'</a></strong> or complete our <a href="/patient-resources/request-an-appointment/">online form</a> to request an appointment</p>';
                                            else :
                                                echo '<p>Complete our <a href="/patient-resources/request-an-appointment/">online form</a> to request an appointment</p>';
                                            endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="fusion-clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth" style='background-color: rgba(255,255,255,0);background-position: center center;background-repeat: no-repeat;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;margin-bottom: 30px;margin-top: 50px;'>
                <div class="fusion-builder-row fusion-row ">
                    <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1  fusion-one-full fusion-column-first fusion-column-last 1_1" style='margin-top:0px;margin-bottom:20px;'>
                        <div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                            <div class="fusion-tabs fusion-tabs-1 classic horizontal-tabs">
                                <div class="nav">
                                    <ul class="nav-tabs nav-justified">
                                        <li class="active">
                                            <a class="tab-link" data-toggle="tab" id="fusion-tab-contact" href="#tab-2fdbee5d75cf64788ea">
                                                <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-phone"></i>Contact</h4>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="tab-link" data-toggle="tab" id="fusion-tab-profile" href="#tab-820e17172deaceab05d">
                                                <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-book"></i>Profile</h4>
                                            </a>
                                        </li>
                                     </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="nav fusion-mobile-tab-nav">
                                        <ul class="nav-tabs nav-justified">
                                            <li class="active">
                                                <a class="tab-link" data-toggle="tab" id="mobile-fusion-tab-contact" href="#tab-2fdbee5d75cf64788ea">
                                                    <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-phone"></i>Contact</h4>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade in active" id="tab-2fdbee5d75cf64788ea">
                                        <!-- GOOGLE MAP -->
                                        <?php 
                                            // declare array to store each location's latitude and longatude
                                            $locationList = [];

                                            if ($practiceLocations) :
                                                foreach ($practiceLocations as $location):
                                                    $locationInfo = []; // Reset array

                                                    $locationFields = get_fields($location->ID);
                                        
                                                    $locationName = get_the_title($location->ID);
                                                    $locationAddress1 = $locationFields['address_line_1'];
                                                    $locationAddress2 = $locationFields['address_line_2'];            
                                                    $locationCity = $locationFields['city'];
                                                    $locationState = $locationFields['state'];
                                                    $locationZip = $locationFields['zip_code'];
                                                    $locationMainPhone = $locationFields['main_phone'];
                                                    $locationLatLng = get_geocode_latlng($location->ID);
                                                    $locationLat = get_geocode_lat($location->ID);
                                                    $locationLng = get_geocode_lng($location->ID);
                                                    
                                                    // Push this location's info to the locationInfo array
                                                    array_push($locationInfo, $locationName, $locationLat, $locationLng, $locationAddress1, $locationAddress2, $locationCity, $locationState, $locationZip, $locationMainPhone, $locationLatLng);
                                                    // Push locationInfo array to LocationList array
                                                    array_push($locationList, $locationInfo);
                                                    unset($locationInfo); // Remove Array
                                                endforeach;
                                            endif;
                                           
                                            if (!empty($locationList)): ?>
                                                <div id="map"></div>
                                                <script type="text/javascript">
                                                     var $ = jQuery;
                                                    // The following creates complex markers to indicate each location this doctor practices at

                                                    // Convert our php array into a jquery array
                                                    // Data for the markers consisting of the location Name, Lat, Lng, Address 1, Address 2, City, State, Zip, Main Phone, LatLng, 
                                                    var locations = <?php echo json_encode($locationList); ?>;

                                                    function initializeMap(locations) {
                                                        // Map will center on all locations, but you need to populate this with a location first
                                                        console.table(firstlocation);
                                                        var firstlocation = locations[0];
                                                        var firstlatlng = firstlocation[9]; 

                                                        var map = new google.maps.Map(document.getElementById('map'), {
                                                          zoom: 8,
                                                          center: {
                                                            lat: parseFloat(firstlocation[1]),
                                                            lng: parseFloat(firstlocation[2]),
                                                          }
                                                        });

                                                        setMarkers(locations, map);
                                                    }

                                                   function setMarkers(locations, map) {
                                                        // create new google map info window
                                                        var infowindow = new google.maps.InfoWindow(), marker, i;

                                                        // bounds will maks sure that all the markers on the map fit within the viewport
                                                        var bounds = new google.maps.LatLngBounds();

                                                        // Adds markers to the map
                                                        for (var i = 0; i < locations.length; i++) {
                                                            var location = locations[i];

                                                            // get lat and lng and add to the bounds variable
                                                            var point = new google.maps.LatLng(location[1], location[2]);
                                                            bounds.extend(point);

                                                            // Build out the marker
                                                            var marker = new google.maps.Marker({
                                                                position: {
                                                                    lat: parseFloat(location[1]),
                                                                    lng: parseFloat(location[2]),
                                                                },
                                                                map: map,
                                                                title: location[0]
                                                            });

                                                            // build out the content in the info window
                                                            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                                                var contentString = '<div id="content">'+
                                                                    '<div id="siteNotice">'+
                                                                    '</div>'+
                                                                    '<h3 id="firstHeading" class="firstHeading">'+ location[0] +'</h3>'+
                                                                    '<div id="bodyContent">'+
                                                                    '<p class="Address">'+ location[3] +'</p>'+
                                                                    '<p class="Address">'+ location[4] +'</p>'+
                                                                    '<p class="Address">'+ location[5] +',&nbsp;'+ location[6] +'&nbsp;'+ location[7] +'</p>'+
                                                                    '<p class="phone">'+location[8] +'</p>'+
                                                                    '</div>'+
                                                                    '</div>';  

                                                                return function() {
                                                                    infowindow.setContent(contentString);
                                                                    infowindow.open(map, marker);
                                                                }
                                                            })(marker, i));
                                                        }
                                                       // Center map to include all markers 
                                                       if (locations.length > 1) {
                                                            // zoom to the bounds
                                                            map.fitBounds(bounds);	
                                                        }
                                                    }

                                                    $(window).load(function(){
                                                        $(initializeMap(locations)); 
                                                    });  

                                                </script>
                                        <?php endif; ?>
                                        <!-- LIST LOCATIONS -->
                                        <div class="Locations">
                                            <?php 
                                                if ($practiceLocations) :
                                                    echo '<h4>Practice Locations</h4>';
                                                    foreach ($practiceLocations as $location):
                                                        
                                                        $locationFields = get_fields($location->ID);
                                            
                                                        $locationAddress1 = $locationFields['address_line_1'];
                                                        $locationAddress2 = $locationFields['address_line_2'];            
                                                        $locationCity = $locationFields['city'];
                                                        $locationState = $locationFields['state'];
                                                        $locationZip = $locationFields['zip_code'];
                                                        $locationMainPhone = $locationFields['main_phone'];
                                                        $locationFax = $locationFields['fax_number'];
                                                        
                                                        echo '<div class="Location">';
                                                            if ($locationAddress1) {
                                                                if ($locationAddress2):
                                                                    echo '<p class="LocationAddress"><strong><a href="'. get_permalink( $location->ID ) .'">'. get_the_title( $location->ID ) .'</a></strong><br/>';
                                                                    echo $locationAddress1 .'<br />' . $locationAddress2 . '<br />';
                                                                    echo $locationCity.', '. $locationState .' '. $locationZip .'</p>';
                                                                
                                                                else :
                                                                    echo '<p class="LocationAddress"><strong><a href="'. get_permalink( $location->ID ) .'">'. get_the_title( $location->ID ) .'</a></strong><br/>';
                                                                    echo $locationAddress1 .'<br />';
                                                                    echo $locationCity.', '. $locationState .' '. $locationZip .'</p>';
                                                                endif;
                                                            } else {
                                                                echo '<p class="LocationTitle"><strong><a href="'. get_permalink( $location->ID ) .'">'. get_the_title( $location->ID ) .'</a></strong></p>';
                                                            }
                                                            if ($locationMainPhone) {
                                                                 echo '<p class="phone">Phone: <a href="tel:'. $locationMainPhone .'">'. $locationMainPhone .'</a></p>';
                                                            }
                                                            if ($locationFax) {
                                                                 echo '<p class="fax">Fax: '. $locationFax .'</p>';
                                                            }
                                                        echo '</div>';    
                                                    endforeach;
                                                endif;
                                                if ($emailAddress) :
                                                    echo '<p class="Email"><a href="mailto:'. $emailAddress .'">'. $emailAddress .'</a></p>';
                                                endif;
                                                if ($emailDisclaimer) :
                                                    echo '<p>'. $emailDisclaimer .'</p>';
                                                endif;
                                            ?>
                                        </div>
                                        <div class="fusion-clearfix"></div>
                                    </div>
                                    <div class="nav fusion-mobile-tab-nav">
                                        <ul class="nav-tabs nav-justified">
                                            <li>
                                                <a class="tab-link" data-toggle="tab" id="mobile-fusion-tab-profile" href="#tab-820e17172deaceab05d">
                                                    <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-book"></i>Profile</h4>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="tab-820e17172deaceab05d">
                                        <?php 
                                            // Biography
                                            if ($biography) :
                                                echo '<h4>Biography</h4>';
                                                echo $biography; 
                                            endif;
                                            // Education
                                            if( have_rows('education') ) :
                                                echo '<h4>Education</h4>';
                                                echo '<div class="EducationWrap">';
                                                while( have_rows('education') ): the_row(); 
                                                ?>
                                                    <div class="Education">
                                                        <h5 class="EducationType"><?php the_sub_field('education_type'); ?></h5>
                                                        <p class="Program"><?php the_sub_field('program_of_study'); ?></p>
                                                        <p class="Institution"><?php the_sub_field('institution'); ?></p>
                                                    </div>
                                                <?php endwhile;
                                                echo '</div>';
                                                echo '<div class="fusion-clearfix"></div>';
                                            endif;
                                            // Certifications
                                            if ($certifications):
                                                echo '<h4>Certifications</h4>';
                                                echo $certifications;
                                            endif;
                                            if ($printableProfile):
                                                echo '<p><a href="'. $printableProfile .'">Print '. $staffFirstName .'&nbsp;'. $staffLastName .'&apos;s Profile [PDF]</a>';
                                            endif;
                                        ?>
                                    </div>
                                </div> <!-- End TabContent -->
                            </div>
                            <div class="fusion-clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
</section>
<?php get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
