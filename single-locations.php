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
		<div id="post-<?php the_ID(); ?>" <?php post_class( 'locations' ); ?>>
			
            <?php
                // Variables
                $locationFields = get_fields(); // Get all the fields for each location
                
                //var_dump($locationFields);
            
                $locationName = get_the_title();
                $location_image = $locationFields['profile_image'];
                $address1 = $locationFields['address_line_1'];
                $address2 = $locationFields['address_line_2'];
                $city = $locationFields['city'];
                $state = $locationFields['state'];
                $zip = $locationFields['zip_code'];
                $mainPhone = $locationFields['main_phone'];
                $appointmentURL = $locationFields['request_an_appointment_link'];
                $fax = $locationFields['fax_number'];
                
                $hours = $locationFields['hours_of_operation'];
                $directions = $locationFields['directions'];
            
                // Google Map Information
                // declare array to store each location's latitude and longatude
                $locationList = []; // Array of multiple Locations
                $locationInfo = []; // Array with information for one specific location
            
                $locationLatLng = get_geocode_latlng($post->ID);
                $locationLat = get_geocode_lat($post->ID);
                $locationLng = get_geocode_lng($post->ID);
            
                // Push this location's info to the locationInfo array
                array_push($locationInfo, $locationName, $locationLat, $locationLng, $address1, $address2, $city, $state, $zip, $mainPhone, $locationLatLng);
                // Push locationInfo array to LocationList array
                array_push($locationList, $locationInfo);
            
                // array of services
                //Get array of terms
                //$terms = get_the_terms( $post->ID , 'service-lines', 'string'); 
                
                        //Get array of terms
                        $terms = get_the_terms( $post->ID , 'service-lines', 'string');

                        //Pluck out the IDs to get an array of IDS
                        $term_ids = wp_list_pluck($terms,'term_id');
            
            
                $serviceLines = get_the_terms( get_the_ID(), 'service-lines');
                $otherServices = $locationFields['other_services'];
        
                // Is this an OrthoAccess Location?
                $isOrthoAccess = false;
                $locationType = $locationFields['location_types'];
                if ($locationType) :
                    foreach ($locationType as $type) {
                        if ($type->name == "OrthoAccess - Immediate Care") :
                             $isOrthoAccess = true;
                        endif;
                    }
                endif;
            
                $patientFeedback = $locationFields['patient_feedback'];
            ?>
            <?php 
                /*
                *  Query posts for a relationship value.
                *  This method uses the meta_query LIKE to match the string "123" to the database value a:1:{i:0;s:3:"123";} (serialized array)
                */

                $doctors = get_posts(array(
                    'post_type' => 'doctors',
                    'posts_per_page' => '-1', // Show all posts
                    'order' => 'ASC',
                    'orderby' => 'name', //Order by post name (post slug). ('post_name' is also accepted.)
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'key' => 'main_practice_location', // name of custom field
                            'value' => '"' . get_the_ID() . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                            'compare' => 'LIKE'
                        ),
                        array(
                            'key' => 'other_locations', // name of custom field
                            'value' => '"' . get_the_ID() . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                            'compare' => 'LIKE'
                        )
                    )
                ));
            
            
                /*
                *  Query posts for a relationship value.
                *  This method uses the meta_query LIKE to match the string "123" to the database value a:1:{i:0;s:3:"123";} (serialized array)
                */

                $teamMembers = get_posts(array(
                    'post_type' => 'staff',
                    'posts_per_page' => '-1', // Show all posts
                    'order' => 'ASC',
                    'orderby' => 'name', // Order by post name (post slug). ('post_name' is also accepted.)
                    'meta_query' => array(
                        array(
                            'key' => 'practice_locations', // name of custom field
                            'value' => '"' . get_the_ID() . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                            'compare' => 'LIKE'
                        )
                    )
                ));
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
            
            <div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth fusion-equal-height-columns" style='background-color: rgba(255,255,255,0);background-position: center center;background-repeat: no-repeat;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;'>
                <div class="fusion-builder-row fusion-row ">
                    <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_4  fusion-one-fourth fusion-column-first 1_4" style='margin-top:0px;margin-bottom:20px;width:25%;width:calc(25% - ( ( 4% ) * 0.25 ) );margin-right: 4%;'>
                        <div class="fusion-column-wrapper" style="padding: 0px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                            <div class="imageframe-align-center">
                                <span style="border:1px solid #ffffff;" class="fusion-imageframe imageframe-bottomshadow imageframe-1 element-bottomshadow hover-type-none">
                                    <?php
                                        if ($location_image) {
                                            echo '<img src="'. $location_image['url'] .'" alt="'. $location_image['alt'] .'" class="img-responsive" />';
                                        } else { 
                                            // default placeholder image
                                            echo '<img src="'. content_url() .'/plugins/wp-posts-carousel/images/placeholder.png" alt="placeholder" class="img-responsive" />';
                                        }
                                    ?>    
                                </span>
                            </div>
                            <div class="fusion-clearfix"></div>
                        </div>
                    </div>
                    <div class="fusion-layout-column fusion_builder_column fusion_builder_column_3_4  fusion-three-fourth fusion-column-last 3_4" style='margin-top:0px;margin-bottom:20px;width:75%;width:calc(75% - ( ( 4% ) * 0.75 ) );'>
                        <div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                            <div class="fusion-title title fusion-title-size-one" style="margin-top:0px;margin-bottom:31px;">
                                <h1 class="title-heading-left" data-fontsize="42" data-lineheight="58">
                                    <?php the_title(); ?>
                                </h1>
                                <div class="title-sep-container">
                                    <div class="title-sep sep-single sep-solid" style="border-color:#e0dede;"></div>
                                </div>
                            </div>
                           <?php 
                                if (the_content) :
                                    echo the_content(); 
                                endif;
                            ?>
                            <div class="fusion-builder-row fusion-builder-row-inner fusion-row ">
                                <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-first BorderLeft fusion-one-half fusion-column-first BorderLeft 1_2" style='width:50%;width:calc(50% - ( ( 4% ) * 0.5 ) );margin-right:4%;'>
                                    <div class="fusion-column-wrapper" style="background-color:#f6f6f6;padding: 10px 20px 10px 20px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                                        <?php
                                            if ($address1):
                                                if ($address2):
                                                    $fullAddress = $address1 . '<br>' . $address2 . '<br>' . $city . ', ' . $state . '&nbsp;' . $zip;
                                                else :
                                                    $fullAddress = $address1 . '<br>' . $city . ', ' . $state . '&nbsp;' . $zip;
                                                endif;
                                                echo '<p><strong>'. $locationName .'</strong><br/>' . $fullAddress .'</p>';
                                            endif;
                                            if ($mainPhone):
                                                if ($fax):
                                                    echo '<p><strong>Main:&nbsp;</strong><a href="tel:'. $mainPhone .'">'. $mainPhone .'</a>&nbsp;&nbsp;|&nbsp;&nbsp;<strong>Fax:&nbsp;</strong>'. $fax .'</p>';
                                                else:
                                                    echo '<p><strong>Main:&nbsp;</strong><a href="tel:'. $mainPhone .'">'. $mainPhone .'</a></p>';
                                                endif;
                                            endif;
//                                            if (have_rows('other_phone_numbers')) :
//                                                while( have_rows('other_phone_numbers') ): the_row();
//                                                    $phoneName = get_sub_field('number_title'); 
//                                                    $phoneNumber = get_sub_field('number');
//                                                    
//                                                    echo '<p><strong>'. $phoneName .':</strong>&nbsp;'. $phoneNumber .'</p>';
//                                                endwhile;
//                                            endif;
                                        ?>
                                        
                                    </div>
                                </div>
                                <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-last BorderLeft fusion-one-half fusion-column-last BorderLeft 1_2" style='width:50%;width:calc(50% - ( ( 4% ) * 0.5 ) );'>
                                    <div class="fusion-column-wrapper" style="background-color:#f6f6f6;padding: 10px 20px 10px 20px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                                        <h4 data-fontsize="26" data-lineheight="33"><strong>To Make an Appointment</strong></h4>
                                        <?php
                                            if ($mainPhone && $appointmentURL) :
                                                echo '<p><strong>Call <a href="tel:'. $mainPhone .'">'. $mainPhone .'</a></strong> or complete our <a href="'. $appointmentURL .'">online form</a> to request an appointment</p>';
                                            elseif ($mainPhone) :
                                                echo '<p><strong>Call <a href="tel:'. $mainPhone .'">'. $mainPhone .'</a></strong> or complete our <a href="/patient-resources/request-an-appointment/">online form</a> to request an appointment</p>';
                                            elseif ($appointmentURL) :
                                                echo '<p>Complete our <a href="'. $appointmentURL .'">online form</a> to request an appointment</p>';
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
            <div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth" style='background-color: rgba(255,255,255,0);background-position: center center;background-repeat: no-repeat;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;margin-top: 50px;'>
                <div class="fusion-builder-row fusion-row ">
                    <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1  fusion-one-full fusion-column-first fusion-column-last 1_1" style='margin-top:0px;margin-bottom:20px;'>
                        <div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                            <div class="fusion-tabs fusion-tabs-1 classic horizontal-tabs">
                                <div class="nav">
                                    <ul class="nav-tabs nav-justified">
                                        <?php if ($hours): ?>
                                        <li class="active">
                                            <a class="tab-link" data-toggle="tab" id="fusion-tab-hours" href="#tab-7acc2226014a44935a0">
                                                <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-clock-o"></i>Hours</h4>
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                        <li>
                                            <a class="tab-link" data-toggle="tab" id="fusion-tab-directions" href="#tab-5c4b69a75e565a33666">
                                                <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-map-marker"></i>Directions</h4>
                                            </a>
                                        </li>
                                       <?php if ($serviceLines) : ?>
                                            <li>
                                                <a class="tab-link" data-toggle="tab" id="fusion-tab-ourservices" href="#tab-84a1abbeef8b054753a">
                                                    <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-stethoscope"></i>Our Services</h4>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($doctors): ?>
                                            <li>
                                                <a class="tab-link" data-toggle="tab" id="fusion-tab-ourdoctors" href="#tab-8528a4894afb1f96b5b">
                                                    <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-user-md"></i>Our Doctors</h4>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($teamMembers): ?>
                                            <li>
                                                <a class="tab-link" data-toggle="tab" id="fusion-tab-ourteam" href="#tab-8528a4894afb1f96b5b2">
                                                    <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-users"></i>Our Team</h4>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                     <?php if ($hours): ?>
                                        <div class="nav fusion-mobile-tab-nav">
                                            <ul class="nav-tabs nav-justified">
                                                <li class="active">
                                                    <a class="tab-link" data-toggle="tab" id="mobile-fusion-tab-hours" href="#tab-7acc2226014a44935a0">
                                                        <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-clock-o"></i>Hours</h4>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade in active" id="tab-7acc2226014a44935a0">
                                            <div class="LeftColumn">
                                                <div class="OfficeHours">
                                                    <h3>Office Hours</h3>
                                                    <div class="Hours"><?php echo $hours ?></div>
                                                </div>
                                                <?php
                                                    $havePhone = false;
                                                    if ($mainPhone) : 
                                                        $havePhone = true;
                                                    endif;
                                                    if ($fax) :
                                                        $havePhone = true;
                                                    endif;
                                                    if (have_rows('other_phone_numbers')) :
                                                        $havePhone = true;
                                                    endif;
                                                ?>
                                                <?php if ($havePhone): ?>
                                                    <div class="PhoneNumbers">
                                                    <h3>Contact</h3>
                                                        <?php
                                                            if ($mainPhone):
                                                                echo '<p><strong>Main:&nbsp;</strong><a href="tel:'. $mainPhone .'">'. $mainPhone .'</a></p>';
                                                            endif;
                                                            if ($fax):
                                                                echo '<p><strong>Fax:&nbsp;</strong> '. $fax .'</p>';
                                                            endif;
                                                            if (have_rows('other_phone_numbers')) :
                                                                while( have_rows('other_phone_numbers') ): the_row();
                                                                    $phoneName = get_sub_field('number_title'); 
                                                                    $phoneNumber = get_sub_field('number');

                                                                    echo '<p><strong>'. $phoneName .':</strong>&nbsp;<a href="tel:'. $phoneNumber .'">'. $phoneNumber .'</a></p>';
                                                                endwhile;
                                                            endif;
                                                        ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php if ($isOrthoAccess == false): ?>
                                                <div class="OrthoAccess BorderLeft">
                                                    <h3>Find Immediate Care Centers</h3>
                                                    <p>IBJI has a number of immediate care, walk-in clinics available for your convenience.</p>
                                                    <p><a href="/locations/?fwp_locations_type=orthoaccess-immediate-care">See OrthoAccess walk-in clinics</a>.</p>
                                                </div>        
                                            <?php endif; ?>
                                            <div class="fusion-clearfix"></div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="nav fusion-mobile-tab-nav">
                                        <ul class="nav-tabs nav-justified">
                                            <li>
                                                <a class="tab-link" data-toggle="tab" id="mobile-fusion-tab-directions" href="#tab-5c4b69a75e565a33666">
                                                    <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-map-marker"></i>Directions</h4>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="tab-5c4b69a75e565a33666">
                                        <div class="AddressDirectionsWrap">
                                            <?php 
                                                if ($address1):
                                                    if ($address2):
                                                        $fullAddress = $address1 . '<br>' . $address2 . '<br>' . $city . ', ' . $state . '&nbsp;' . $zip;
                                                    else :
                                                        $fullAddress = $address1 . '<br>' . $city . ', ' . $state . '&nbsp;' . $zip;
                                                    endif;
                                                    echo '<p class="Address"><strong>'. $locationName .'</strong><br/>' . $fullAddress .'</p>';
                                                endif;
                                                if ($mainPhone):
                                                    echo '<p><strong>Main:&nbsp;</strong><a href="tel:'. $mainPhone .'">'. $mainPhone .'</a></p>';
                                                endif;
                                            ?>

                                            <?php 
                                                if ($directions) :
                                                    echo '<hr>';
                                                    echo '<h3>Directions</h3>';
                                                    echo $directions;
                                                endif; 
                                            ?>
                                        </div>
                                        <?php if ($locationLat) : ?>
                                            <div id="map"></div>
                                            <script type="text/javascript">
                                                 var $ = jQuery;
                                                // The following creates complex markers to indicate each location this doctor practices at

                                                // Convert our php array into a jquery array
                                                // Data for the markers consisting of the location Name, Lat, Lng, Address 1, Address 2, City, State, Zip, Main Phone, LatLng, 
                                                var locations = <?php echo json_encode($locationList); ?>;

                                                function initializeMap(locations) {
                                                    // Map will center on all locations, but you need to populate this with a location first
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
                                                $(window).load(function() {
                                                    $('#fusion-tab-directions, #mobile-fusion-tab-directions').click(function(){
                                                        setTimeout(function() {
                                                            $(initializeMap(locations)); 
                                                        }, 500);
                                                    });
                                                });
                                            </script>
                                        <?php endif; ?>
                                        <div class="fusion-clearfix"></div>
                                    </div>
                                    
                                    <?php if ($serviceLines) : ?>
                                        <div class="nav fusion-mobile-tab-nav">
                                            <ul class="nav-tabs nav-justified">
                                                <li>
                                                    <a class="tab-link" data-toggle="tab" id="mobile-fusion-tab-ourservices" href="#tab-84a1abbeef8b054753a">
                                                        <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-stethoscope"></i>Our Services</h4>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="tab-84a1abbeef8b054753a">
                                            <?php
                                                $servicePages_query = new WP_Query( array(
                                                    'post_type' => 'services',
                                                    'tax_query' => array(
                                                        array(
                                                            'taxonomy' => 'service-lines',
                                                            'field' => 'id',
                                                            'terms' => $term_ids,
                                                            'operator'=> 'IN' //'IN' Or 'AND' or 'NOT IN'
                                                         )),
                                                      'posts_per_page' => -1,
                                                      'ignore_sticky_posts' => 1,
                                                      'orderby' => 'title'
                                                ));

                                                $servicePages = $servicePages_query->have_posts();
                                                $servicePageArray = [];
                                                $service = [];
                                            
                                                if ($servicePages) :
                                                    while ($servicePages_query->have_posts() ) : $servicePages_query->the_post();
                                                        $service = []; // reset Array
                                            
                                                        // Push values into service array
                                                        $title = get_the_title();
                                                        $link = get_the_permalink();
                                            
                                                        // push title and link into service array
                                                        array_push($service, $title, $link);
                                                        
                                                        // Push service array into servicePageArray
                                                        array_push($servicePageArray, $service);
                                                    endwhile;
                                                endif;
                                                
                                                function in_multiarray($elem, $array) {
                                                    while (current($array) !== false) {
                                                        if (current($array) == $elem) {
                                                            return true;
                                                        } elseif (is_array(current($array))) {
                                                            if (in_multiarray($elem, current($array))) {
                                                                //var_dump (current($array));
                                                                $theServiceLink = current($array)[1];
                                                                echo '<li><a href="'. $theServiceLink .'">'. $elem .'</a></li>';
                                                                return true;
                                                            }
                                                        }
                                                        next($array);
                                                    }
                                                    return false;
                                                }
                                                
                                                $columns = 3; //This will really make 4 columns but because arrays start with 0
                                            
                                                // Break services array into 4 chunks to match the number of columns we need
                                                // this next line is counting the number of services, rounding up to the nearest whole number and then dividing by 4
                                                // this will tell us how many items should be in each column of the array/columns
                                                // var_dump($serviceLines);
                                                if (count($serviceLines) < 4) {
                                                    echo '<div class="ServiceColumn">';
                                                        echo '<ul class="ServiceList">';
                                                        foreach ($serviceLines as $service){
                                                            $serviceName = $service->name;
                                                            if (in_multiarray($serviceName, $servicePageArray) == true) {
                                                               // Grab link and service name from in_multiarray function                                                        
                                                            } else {
                                                                echo '<li>'. $serviceName .'</li>';
                                                            }
                                                        }
                                                        echo '</ul>';
                                                    echo '</div>';
                                                } else {
                                                    $thisData = array_chunk($serviceLines, ceil(count($serviceLines) / $columns - 1), true);
                                                
                                                    // Put the first two chunks of the array in one div, this is so on smaller devices we can have two columns instead of 4
                                                    $firstTwoColumns = array_slice($thisData, 0, 2);

                                                    // Put the last two chunks of the array in one div, this is so on smaller devices we can have two columns instead of 4
                                                    $lastTwoColumns = array_slice($thisData, 2, 3);

                                                    // Output column one markup
                                                    echo '<div class="ServiceColumn">';
                                                        foreach ($firstTwoColumns as $row) {
                                                            echo '<ul class="ServiceList">';
                                                                foreach ($row as $service) {
                                                                    $serviceName = $service->name;
                                                                    if (in_multiarray($serviceName, $servicePageArray) == true) {
                                                                       // Grab link and service name from in_multiarray function                                                        
                                                                    } else {
                                                                        echo '<li>'. $serviceName .'</li>';
                                                                    }
                                                                }
                                                            echo '</ul>';
                                                        }
                                                    echo '</div>';
                                                    // Output column two markup
                                                    echo '<div class="ServiceColumn">';
                                                        foreach ($lastTwoColumns as $row) {
                                                            echo '<ul class="ServiceList">';
                                                                foreach ($row as $service) {
                                                                    $serviceName = $service->name;
                                                                    if (in_multiarray($serviceName, $servicePageArray) == true) {
                                                                       // Grab link and service name from in_multiarray function                                                        
                                                                    } else {
                                                                        echo '<li>'. $serviceName .'</li>';
                                                                    }
                                                                }
                                                            echo '</ul>';
                                                        }
                                                    echo '</div>';     
                                                }                          
                                            ?>
                                            
                                            <div class="fusion-clearfix"></div> <!-- clear all four columns -->               
                                            <!-- Other Services -->       
                                            <?php 
                                                if ($otherServices) :
                                                    echo '<hr>';
                                                    echo $otherServices;
                                                endif;
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($doctors): ?>
                                        <div class="nav fusion-mobile-tab-nav">
                                            <ul class="nav-tabs nav-justified">
                                                <li>
                                                    <a class="tab-link" data-toggle="tab" id="mobile-fusion-tab-ourdoctors" href="#tab-8528a4894afb1f96b5b">
                                                        <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-user-md"></i>Our Doctors</h4>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="tab-8528a4894afb1f96b5b">
                                            <div class="DoctorsWrap">
                                            <!-- Doctors At this Location -->
                                           
                                                <?php foreach( $doctors as $doctor ):
                                                    $doctorFields = get_fields($doctor->ID);    
                                                    
                                                    $doctorPhoto = $doctorFields['profile_image'];
                                                    $doctorFirstName = $doctorFields['first_name'];
                                                    $doctorMiddleName = $doctorFields['middle_name'];
                                                    $doctorLastName = $doctorFields['last_name'];
                                                    $doctorSuffix = $doctorFields['suffix'];
                                                    $doctorFullName = "";
                                                    $professionalTitles = $doctorFields['professional_titles'];        
                                                    //$doctorSpecialtyNames = get_the_terms( $doctor->ID, 'specialties');
                                                    $doctorSpecialtyNames = $doctorFields['specialties'];
                                                    $doctorSpecialties = $doctorFields['specialties_text'];
                                                        
                                                ?>
                                                
                                                <div class="Doctor">
                                                    <?php if( !empty($doctorPhoto) ) { ?>
                                                        <div class="image"><a href="<?php the_permalink($doctor->ID); ?>" title="<?php the_title(); ?>"><img src="<?php echo $doctorPhoto['url']; ?>" alt="<?php echo $doctorPhoto['alt']; ?>" style="max-width:100%; max-height:100%" /></a></div>
                                                    <?php } else { ?>
                                                        <div class="image"><a href="<?php the_permalink($doctor->ID); ?>" title="<?php the_title(); ?>"><img src="<?php echo content_url() ?>/plugins/wp-posts-carousel/images/placeholder.png" alt="placeholder" style="max-width:100%; max-height:100%" /></a></div>
                                                    <?php } ?>
                                                         <div class="details">
                                                            <h3 class="title">
                                                                <a href="<?php the_permalink($doctor->ID); ?>" title="<?php the_title(); ?>">
                                                                    <?php 
                                                                        $doctorFullName =  "";
                                                                        
                                                                        if ($doctorMiddleName) {
                                                                            $doctorFullName =  $doctorFirstName ."&nbsp;". $doctorMiddleName ."&nbsp;". $doctorLastName;
                                                                        } else {
                                                                            $doctorFullName = $doctorFirstName ."&nbsp;". $doctorLastName;
                                                                        }

                                                                        if ($doctorSuffix) {
                                                                            $doctorFullName = $doctorFullName .", ". $doctorSuffix;
                                                                        }    
                                                                    
                                                                        if ($professionalTitles) {
                                                                            echo $doctorFullName .", ";
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
                                                                            echo $doctorFullName;
                                                                        }
                                                                    ?>
                                                                </a>
                                                            </h3>
                                                            <?php
                                                                if ($doctorSpecialties) { 
                                                                    echo '<div class="SpecialtiesText">'. $doctorSpecialties .'</div>';
                                                                }
                                                            ?>
                                                            <?php 
                                                                if ($doctorSpecialtyNames) {
                                                                    $i = 1;
                                                                    $numOfSpecialties = count($doctorSpecialtyNames);
                                                                    echo '<p class="specialties">';
                                                                    foreach ($doctorSpecialtyNames as $specialty) {
                                                                        if ($numOfSpecialties > 2):
                                                                            if ($i < $numOfSpecialties): 
                                                                                echo $specialty->name .', '; 
                                                                            else:
                                                                                echo $specialty->name;
                                                                            endif;
                                                                        elseif ($numOfSpecialties == 2):
                                                                            if ($i == 1):
                                                                                echo $specialty->name .' and ';
                                                                            else:
                                                                                echo $specialty->name;
                                                                            endif;
                                                                        else:
                                                                            echo $specialty->name;
                                                                        endif;
                                                                        $i++;
                                                                    }
                                                                    echo '</p>';
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                            <?php endforeach; ?>
                                            <div class="fusion-clearfix"></div>
                                            </div></div>
                                    <?php endif; ?>
                                    <?php if ($teamMembers) : ?>
                                        <div class="nav fusion-mobile-tab-nav">
                                            <ul class="nav-tabs nav-justified">
                                                <li>
                                                    <a class="tab-link" data-toggle="tab" id="mobile-fusion-tab-ourteam" href="#tab-8528a4894afb1f96b5b2">
                                                        <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-users"></i>Our Team</h4>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="tab-8528a4894afb1f96b5b2">
                                            <div class="TeamWrap">
                                            <!-- TeamMembers At this Location -->
                                           
                                                <?php foreach( $teamMembers as $member ):
                                                    $staffFields = get_fields($member->ID);
                                                    
                                                    $staffPhoto = $staffFields['profile_image'];
                                                    $staffFirstName = $staffFields['first_name'];
                                                    $staffMiddleName = $staffFields['middle_name'];
                                                    $staffLastName = $staffFields['last_name'];
                                                    $staffSuffix = $staffFields['suffix'];
                                                    $professionalTitles = $staffFields['professional_titles'];
                                                    $jobTitle = $staffFields['job_title'];
                                                ?>
                                                
                                                <div class="Member">
                                                    <?php if( !empty($staffPhoto) ) { ?>
                                                        <div class="image"><a href="<?php the_permalink($member->ID); ?>" title="<?php the_title(); ?>"><img src="<?php echo $staffPhoto['url']; ?>" alt="<?php echo $staffPhoto['alt']; ?>" style="max-width:100%; max-height:100%" /></a></div>
                                                    <?php } else { ?>
                                                        <div class="image"><a href="<?php the_permalink($member->ID); ?>" title="<?php the_title(); ?>"><img src="<?php echo content_url() ?>/plugins/wp-posts-carousel/images/placeholder.png" alt="placeholder" style="max-width:100%; max-height:100%" /></a></div>
                                                    <?php } ?>
                                                         <div class="details">
                                                            <h3 class="title">
                                                                <a href="<?php the_permalink($member->ID); ?>" title="<?php the_title(); ?>">
                                                                    <?php 
                                                                        $staffFullName = "";
                                                                    
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
                                                                            foreach ($professionalTitles as $professionalTitle ) {
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
                                                                </a>
                                                            </h3>
                                                            <?php
                                                                if ($jobTitle) :
                                                                    $i = 1;
                                                                    $numOfTitles = count($jobTitle);
                                                                    echo '<p>';
                                                                    foreach ($jobTitle as $jobTitle) {
                                                                        if ($numOfJobTitles > 2):
                                                                            if ($i < $numOfJobTitles): 
                                                                                if ($i == $numOfJobTitles - 1): 
                                                                                    echo $jobTitle->name .' and ';    
                                                                                else:
                                                                                    echo $jobTitle->name .', '; 
                                                                                endif;
                                                                            else:
                                                                                echo $jobTitle->name;
                                                                            endif;
                                                                        elseif ($numOfTitles == 2):
                                                                            if ($i == 1):
                                                                                echo $jobTitle->name .' and ';
                                                                            else:
                                                                                echo $jobTitle->name;
                                                                            endif;
                                                                        else:
                                                                            echo $jobTitle->name;
                                                                        endif;
                                                                        $i++;
                                                                    }
                                                                    echo '</p>';
                                                                endif;
                                                            ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                                <div class="fusion-clearfix"></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="fusion-clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($patientFeedback): ?>
            <div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth" style='background-color: rgba(255,255,255,0);background-position: center center;background-repeat: no-repeat;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;margin-top: 50px;'>
                <div class="fusion-builder-row fusion-row ">
                    <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1  fusion-one-full fusion-column-first fusion-column-last 1_1" style='margin-top:0px;margin-bottom:20px;'>
                        <div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                            <div class="fusion-tabs fusion-tabs-1 classic horizontal-tabs">
                                <div class="nav">
                                    <ul class="nav-tabs nav-justified">
                                        <li class="active">
                                            <a class="tab-link" data-toggle="tab" id="fusion-tab-feedback" href="#tab-6acc2226014a44935a1">
                                                <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-commenting"></i>Patient Feedback</h4>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="nav fusion-mobile-tab-nav">
                                        <ul class="nav-tabs nav-justified">
                                            <li class="active">
                                                <a class="tab-link" data-toggle="tab" id="mobile-fusion-tab-feedback" href="#tab-6acc2226014a44935a1">
                                                    <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-commenting"></i>Patient Feedback</h4>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade in active" id="tab-6acc2226014a44935a1">
                                        <?php echo $patientFeedback; ?>
                                    </div>
                                </div>
                                <div class="fusion-clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       <?php endif; ?>
    <?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
</section>
<script type="text/javascript">
    var equalHeight = (function($) {
        "use strict";

        // remove inline min height from the group
        function clear(group) {
            group.css('min-height', '');
        }

        // make group equal heights
        function equalHeight(group) {
           
            // reset height set by this script
            clear(group);

            // defining a variable that will keep track of the height of the tallest element
            var tallest = 0;

            // loop through elements, find the tallest outer height (includes padding)
            group.each(function () {

                // this is the outer height of the element (it doesn't round up or down to whole numbers)
                var thisHeight = this.getBoundingClientRect().bottom - this.getBoundingClientRect().top;

                if (thisHeight > tallest) {
                    tallest = thisHeight;
                }
            });

            // loop through elements again, individually set their min-height so that their total height (including padding) = our tallest element
            group.each(function () {

                // if this has css box-sizing: border box, set the min-height equal to the tallest
                if (isBorderBox(this)) {

                    group.css('min-height', Math.ceil(tallest));

                } else {

                    // if an element has padding
                    if ($(this).outerHeight() > $(this).height()) {

                        // calulate how much border and padding is on the element
                        var thisPadding = $(this).outerHeight() - $(this).height();

                        // set the height of the element to the tallest, but leave room for the padding
                        group.css('min-height', Math.ceil(tallest - thisPadding));

                    } else {

                        // if the element has no padding, simply set the height to our tallest
                        group.css('min-height', Math.ceil(tallest));
                    }
                }
            });
        }

        // check to see if the page is using box-sizing: border-box;
        function isBorderBox(elem) {
            return window.getComputedStyle(elem).boxSizing === "border-box";
        };

        return {
            equalHeight: equalHeight,
            outerHeight: equalHeight,
            clear: clear
        };
    })(jQuery);

    $(window).load(function() {
        $('#fusion-tab-ourdoctors, #mobile-fusion-tab-ourdoctors').click(function(){
            setTimeout(function(){
                equalHeight.equalHeight($('.DoctorsWrap .Doctor'));
            },500);
        });
        $('#fusion-tab-ourteam, #mobile-fusion-tab-ourteam').click(function(){
            setTimeout(function(){
                equalHeight.equalHeight($('.TeamWrap .Member'));
            },500);
        });
    });
</script>   
<?php get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
