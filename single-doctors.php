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
		<div id="post-<?php the_ID(); ?>" <?php post_class( 'doctors' ); ?>>
			
            <?php
                // Variables
                /* Above Tabs */
                $fields = get_fields();
                //var_dump($fields);
                
                $doctor_image = $fields['profile_image'];
                $doctorFirstName = $fields['first_name'];
                $doctorMiddleName = $fields['middle_name'];
                $doctorLastName = $fields['last_name'];
                $doctorSuffix = $fields['suffix'];
                $doctorFullName = "";
                
                $professionalTitles = $fields['professional_titles'];
                $doctorSpecialtyNames = $fields['specialties'];
                $doctorSpecialties = $fields['specialties_text'];
            
                $boardCertified = $fields['board_certified'];
                $boardCertifiedIn = $fields['board_certified_in'];
                $boardCertifiedText = $fields['board_certified_text'];
                $boardEligible = $fields['board_eligible'];
                $boardEligibleIn = $fields['board_eligible_in'];
                $boardEligibleText = $fields['board_eligible_text'];
                $additionalLanguages = $fields['additional_languages'];
                $appointmentPhone = $fields['appointment_phone'];
                $appointmentURL = $fields['request_an_appointment_link'];
                
                /* Contact Tab */
                $mainPracticeLocation = $fields['main_practice_location'];
                $otherPracticeLocations = $fields['other_locations'];
                $officeHours = $fields['office_hours'];
                $affiliatedHospitals = $fields['hospital_affiliations'];
                $contact = false;
                if ($mainPracticeLocation || $otherPracticeLocations || $officeHours || $affiliatedHospitals) :
                    $contact = true;
                endif;
            
                /* Profile Tab */
                $meetMeVideo = $fields['meet_me_video'];
                // Biography is simply the_post
                $biography = get_the_content();
                $areasOfExpertise = $fields['additional_areas_of_expertise'];
                $philosophy = $fields['philosophy_of_care'];    
                $whatPatientsShouldKnow = $fields['what_patients_should_know_about_you'];
                // Education is a repeater field so these are inline down in the code block
                $affilationsAssociations = $fields['affiliations_and_associations'];
                $researchPublications = $fields['research_and_publications'];
                $awards = $fields['awards'];
                $appointments = $fields['appointments'];
                $otherInformation = $fields['other_information'];
                $doctorWebsite = $fields['link_to_website'];
                $cv = $fields['cv'];
            
                /* Health Plans Tab */
                $acceptedInsurance = $fields['accepted_insurances'];
                $otherBillingInfo = $fields['other_billing_information'];
            
                /* Media Tab */
                $media = false;
                $mediaLinks = $fields['links'];
                if( have_rows('videos') || have_rows('audio_files') || have_rows('other_files') || ($mediaLinks) ) : 
                    $media = true;
                endif;
            
                //var_dump($fields);
            
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
                                        if ($doctor_image) {
                                            echo '<img src="'. $doctor_image['url'] .'" alt="'. $doctor_image['alt'] .'" class="img-responsive" />';
                                        } else { 
                                            // default placeholder image
                                            echo '<img src="'. content_url() .'/plugins/wp-posts-carousel/images/placeholder.png" alt="placeholder" class="img-responsive" />';
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
                                        //echo ($professioalTitles);
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
                                </h1>
                                <div class="title-sep-container">
                                    <div class="title-sep sep-single sep-solid" style="border-color:#e0dede;"></div>
                                </div>
                            </div>
                            <div class="fusion-builder-row fusion-builder-row-inner fusion-row ">
                                <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-first fusion-one-half fusion-column-first 1_2" style='margin-top: 0px;margin-bottom: 20px;width:50%;width:calc(50% - ( ( 4% ) * 0.5 ) );margin-right:4%;'>
                                    <div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                                        <?php
                                            if ($doctorSpecialties) {
                                                echo '<div class="SpecialtiesText">';
                                                echo '<h5 class="SpecialtiesHeader">Specialties</h5>';
                                                echo '<div class="Specialties">'. $doctorSpecialties .'</div>';
                                                echo '</div>';
                                            }
                                        ?>
                                        <?php 
                                            if ($doctorSpecialtyNames) {
                                                $i = 1;
                                                $numOfSpecialties = count($doctorSpecialtyNames);
                                                echo '<div class="SpecialtiesTaxonomy">';
                                                if ($numOfSpecialties >= 2) {
                                                    echo '<h5 class="SpecialtiesHeader">Specialties</h5>';
                                                } else {
                                                    echo '<h5 class="SpecialtiesHeader">Specialty</h5>';
                                                }
                                                echo '<ul class="Specialties">';
                                                foreach ($doctorSpecialtyNames as $specialty) {
                                                    // List Speialties in List Format
                                                    echo '<li>'. $specialty->name .'</li>';
                                                    // List Specialties in Paragraph Format
//                                                    if ($numOfSpecialties > 2):
//                                                        if ($i < $numOfSpecialties): 
//                                                            if ($i == $numOfSpecialties - 1): 
//                                                                echo $specialty->name .' and ';    
//                                                            else:
//                                                                echo $specialty->name .', '; 
//                                                            endif;
//                                                        else:
//                                                            echo $specialty->name;
//                                                        endif;
//                                                    elseif ($numOfSpecialties == 2):
//                                                        if ($i == 1):
//                                                            echo $specialty->name .' and ';
//                                                        else:
//                                                            echo $specialty->name;
//                                                        endif;
//                                                    else:
//                                                        echo $specialty->name;
//                                                    endif;
//                                                    $i++;

                                                }
                                                echo '</ul></div>';
                                            }
                                        ?>
                                        <?php
                                            if ($boardCertifiedText) {
                                                echo '<div class="CertificationsText">';
                                                echo '<h5 class="CertificationsHeader">Board Certifications</h5>';
                                                echo '<div class="Certifications">' . $boardCertifiedText . '</div>';
                                                echo '</div>';
                                            }
                                        ?>
                                        <?php
                                            if ($boardCertified == Yes) {
                                                $i = 1;
                                                $numOfCertifications = count($boardCertifiedIn);
                                                echo '<div class="CertificationsTaxonomy">';
                                                if ($numOfCertifications >= 2) {
                                                    echo '<h5 class="CertificationsHeader">Board Certifications</h5>';
                                                } else {
                                                    echo '<h5 class="CertificationsHeader">Board Certification</h5>';
                                                }
                                                echo '<ul class="Certifications">';
                                                foreach ($boardCertifiedIn as $certification) {
                                                    // List in List format
                                                    echo '<li>'. $certification->name .'</li>';
                                                    // List in Pargraph Format
//                                                        if ($numOfCertifications > 2):
//                                                            if ($i < $numOfCertifications): 
//                                                                if ($i == $numOfCertifications - 1): 
//                                                                    echo $certification->name .' and ';    
//                                                                else:
//                                                                    echo $certification->name .', '; 
//                                                                endif;
//                                                            else:
//                                                                echo $certification->name;
//                                                            endif;
//                                                        elseif ($numOfCertifications == 2):
//                                                            if ($i == 1):
//                                                                echo $certification->name .' and ';
//                                                            else:
//                                                                echo $certification->name;
//                                                            endif;
//                                                        else:
//                                                            echo $certification->name;
//                                                        endif;
//                                                        $i++;
                                                    }
                                                echo '</ul></div>';
                                                    
                                            }
                                        ?>
                                        <?php
                                            if ($boardEligibleText) {
                                                echo '<div class="CertificationsText">';
                                                echo '<h5 class="CertificationsHeader">Board Eligible</h5>';
                                                echo '<div class="Certifications">'. $boardEligibleText .'</div>';
                                                echo '</div>';
                                            }
                                        ?>
                                         <?php
                                            if ($boardEligible == Yes) {
                                                echo '<div class="CertificationsTaxonomy">';
                                                echo '<h5 class="CertificationsHeader">Board Eligible</h5>';
                                                $i = 1;
                                                $numOfEligible = count($boardEligibleIn);
                                                echo '<ul class="Certifications">';
                                                foreach ($boardEligibleIn as $eligible) {
                                                    // List in List Format
                                                    echo '<li>'. $eligible->name .'</li>';
                                                    // List in Paragraph Format
//                                                        if ($numOfEligible > 2):
//                                                            if ($i < $numOfEligible): 
//                                                                if ($i == $numOfEligible - 1): 
//                                                                    echo $eligible->name .' and ';    
//                                                                else:
//                                                                    echo $eligible->name .', '; 
//                                                                endif;
//                                                            else:
//                                                                echo $eligible->name;
//                                                            endif;
//                                                        elseif ($numOfEligible == 2):
//                                                            if ($i == 1):
//                                                                echo $eligible->name .' and ';
//                                                            else:
//                                                                echo $eligible->name;
//                                                            endif;
//                                                        else:
//                                                            echo $eligible->name;
//                                                        endif;
//                                                        $i++;
                                                }
                                                echo '</ul></div>';
                                                    
                                            }
                                        ?>
                                        <?php 
                                            if ($additionalLanguages) {
                                                $i = 1;
                                                $numOfLanguages = count($additionalLanguages);

                                                if ($numOfLanguages >= 2) {
                                                    echo '<h5 class="LanguagesHeader">Additional Languages</h5>';
                                                } else {
                                                    echo '<h5 class="LanguagesHeader">Additional Language:</h5>';
                                                }
                                                echo '<ul class="Languages">';
                                                foreach ($additionalLanguages as $language) {
                                                    //List in List Format
                                                    echo '<li>'. $language->name .'</li>';
                                                    // List in Paragraph Format
//                                                    if ($numOfLanguages > 2):
//                                                        if ($i < $numOfLanguages): 
//                                                            if ($i == $numOfLanguages - 1): 
//                                                                echo $language->name .' and ';    
//                                                            else:
//                                                                echo $language->name .', '; 
//                                                            endif;
//                                                        else:
//                                                            echo $language->name;
//                                                        endif;
//                                                    elseif ($numOfLanguages == 2):
//                                                        if ($i == 1):
//                                                            echo $language->name .' and ';
//                                                        else:
//                                                            echo $language->name;
//                                                        endif;
//                                                    else:
//                                                        echo $language->name;
//                                                    endif;
//                                                    $i++;
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
                                            if ($appointmentPhone && $appointmentURL) :
                                                echo '<p><strong>Call <a href="tel:'. $appointmentPhone .'">'. $appointmentPhone .'</a></strong> or complete our <a href="'. $appointmentURL .'">online form</a> to request an appointment</p>';
                                            elseif ($appointmentPhone) :
                                                echo '<p><strong>Call <a href="tel:'. $appointmentPhone .'">'. $appointmentPhone .'</a></strong> or complete our <a href="/patient-resources/request-an-appointment/">online form</a> to request an appointment</p>';
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
            <div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth" style='background-color: rgba(255,255,255,0);background-position: center center;background-repeat: no-repeat;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;margin-bottom: 30px;margin-top: 50px;'>
                <div class="fusion-builder-row fusion-row ">
                    <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1  fusion-one-full fusion-column-first fusion-column-last 1_1" style='margin-top:0px;margin-bottom:20px;'>
                        <div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                            <div class="fusion-tabs fusion-tabs-1 classic horizontal-tabs">
                                <div class="nav">
                                    <ul class="nav-tabs nav-justified">
                                        <?php if ($contact == true) : ?>
                                            <li class="active">
                                                <a class="tab-link" data-toggle="tab" id="fusion-tab-contact" href="#tab-2fdbee5d75cf64788ea">
                                                    <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-phone"></i>Contact</h4>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($contact == false): ?>
                                            <li class="active">
                                        <?php else: ?>
                                            <li>
                                        <?php endif; ?>
                                            <a class="tab-link" data-toggle="tab" id="fusion-tab-profile" href="#tab-820e17172deaceab05d">
                                                <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-book"></i>Profile</h4>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="tab-link" data-toggle="tab" id="fusion-tab-health-plans" href="#tab-467e1f7fb2120b96eec">
                                                <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-file-text"></i>Health Plans</h4>
                                            </a>
                                        </li>
                                        <?php if ($media) : ?>
                                            <li>
                                                <a class="tab-link" data-toggle="tab" id="fusion-tab-media" href="#tab-f84bfb1f8ec69413945">
                                                    <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-play-circle-o"></i>Media</h4>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <?php if ($contact == true) : ?>
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
                                               
                                                if ($mainPracticeLocation) :
                                                    foreach ($mainPracticeLocation as $location):
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
                                                if ($otherPracticeLocations):
                                                    foreach ($otherPracticeLocations as $location):
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
                                                            var firstlocation = locations[0];
                                                            var firstlatlng = firstlocation[8]; 

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
                                                    if ($mainPracticeLocation) :
                                                        $numOfPractices = count($mainPracticeLocation);
                                                        if ($numOfPractices >= 2) :
                                                            echo '<h4>Practice Locations</h4>';
                                                        else :
                                                            echo '<h4>Practice Location</h4>';
                                                        endif;
                                                        foreach ($mainPracticeLocation as $location):
                                                            
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
                                                                        echo $locationCity.',&nbsp;'. $locationState .' '. $locationZip .'</p>';

                                                                    else :
                                                                        echo '<p class="LocationAddress"><strong><a href="'. get_permalink( $location->ID ) .'">'. get_the_title( $location->ID ) .'</a></strong><br/>';
                                                                        echo $locationAddress1 .'<br />';
                                                                        echo $locationCity.',&nbsp;'. $locationState .' '. $locationZip .'</p>';
                                                                    endif;
                                                                } else {
                                                                    echo '<p class="LocationTitle"><strong><a href="'. get_permalink( $location->ID ) .'">'. get_the_title( $location->ID ) .'</a></strong></p>';
                                                                }
                                                                if ($locationMainPhone) {
                                                                     echo '<p class="phone">Phone:&nbsp;<a href="tel:'. $locationMainPhone .'">'. $locationMainPhone .'</a></p>';
                                                                }
                                                                if ($locationFax) {
                                                                     echo '<p class="fax">Fax: '. $locationFax .'</p>';
                                                                }
                                                            echo '</div>';    
                                                        endforeach;
                                                    endif;
                                                ?>
                                                <?php
                                                    if ($otherPracticeLocations) :
                                                         $numOfOtherPractices = count($otherPracticeLocations);
                                                        if ($numOfOtherPractices >= 2) :
                                                            echo '<h4>Other Practice Locations</h4>';
                                                        else :
                                                           echo '<h4>Other Practice Location</h4>';
                                                        endif;        
                                                        foreach ($otherPracticeLocations as $location):
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
                                                                        echo $locationCity.',&nbsp;'. $locationState .' '. $locationZip .'</p>';
                                                                    else :
                                                                        echo '<p class="LocationAddress"><strong><a href="'. get_permalink( $location->ID ) .'">'. get_the_title( $location->ID ) .'</a></strong><br/>';
                                                                        echo $locationAddress1 .'<br />';
                                                                        echo $locationCity.',&nbsp;'. $locationState .' '. $locationZip .'</p>';
                                                                    endif;
                                                                } else {
                                                                    echo '<p class="LocationTitle"><strong><a href="'. get_permalink( $location->ID ) .'">'. get_the_title( $location->ID ) .'</a></strong></p>';
                                                                }
                                                                if ($locationMainPhone) {
                                                                     echo '<p class="phone">Phone:&nbsp;<a href="tel:'. $locationMainPhone .'">'. $locationMainPhone .'</a></p>';
                                                                }
                                                                if ($locationFax) {
                                                                     echo '<p class="fax">Fax: '. $locationFax .'</p>';
                                                                }
                                                            echo '</div>';    
                                                        endforeach;
                                                    endif;
                                                ?>
                                            </div>
                                            <div class="fusion-clearfix"></div>
                                            <?php
                                                if ($officeHours):
                                                    echo '<hr />';
                                                    echo '<h4>Office Hours</h4>';
                                                    echo '<div>'. $officeHours .'</div>';
                                                endif;
                                            ?>
                                            <?php
                                                if ($affiliatedHospitals):
                                                    echo '<hr />';
                                                    echo '<h4>Affiliated Hospitals</h4>';
                                                    echo '<ul>';
                                                        foreach ($affiliatedHospitals as $hospital) {
                                                            echo '<li>'. $hospital->name .'</li>';
                                                        }
                                                    echo '</ul>';
                                                    echo '<div class="fusion-clearfix"></div>';
                                                endif;
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="nav fusion-mobile-tab-nav">
                                        <ul class="nav-tabs nav-justified">
                                            <?php if ($contact == false): ?>
                                                <li class="active">
                                            <?php else: ?>
                                                <li>
                                            <?php endif; ?>
                                                <a class="tab-link" data-toggle="tab" id="mobile-fusion-tab-profile" href="#tab-820e17172deaceab05d">
                                                    <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-book"></i>Profile</h4>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php if ($contact == false): ?>
                                        <div class="tab-pane fade in active" id="tab-820e17172deaceab05d">
                                    <?php else: ?>
                                        <div class="tab-pane fade" id="tab-820e17172deaceab05d">
                                    <?php endif; ?>
                                        <?php 
                                            if ($meetMeVideo):
                                                echo '<h4>Meet '. $doctorFullName .'</h4>';
                                                echo '<div class="Video"><div class="VideoContainer">';        
                                                echo $meetMeVideo;
                                                echo '</div></div>';
                                                echo '<div class="fusion-clearfix"></div>';
                                            endif;
                                            if ($biography) :
                                                echo '<h4>Biography</h4>';
                                                echo $biography; 
                                            endif;
                                            if ($areasOfExpertise) :
                                                $numOfInterests = count($areasOfExpertise);
                                                echo '<h4>Additional Areas of Expertise</h4>';
                                                echo $areasOfExpertise;
                                            endif;
                                            if ($philosophy) :
                                                echo '<h4>Philosophy of Care</h4>';
                                                echo $philosophy;
                                            endif;
                                            
                                            if ($whatPatientsShouldKnow) : 
                                                echo '<h4>What Patients Should Know About Me</h4>';
                                                echo $whatPatientsShouldKnow;
                                            endif;
                                            
                                            if ($affilationsAssociations) :
                                                echo '<h4>Affilations and Associations</h4>';
                                                echo $affilationsAssociations;
                                            endif;
                                        ?>
                                        <?php
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
                                        ?>
                                        <?php 
                                            if ($researchPublications) :
                                                echo '<h4>Research and Publications</h4>';
                                                echo $researchPublications;
                                            endif;
                                            if ($awards) :
                                                echo '<h4>Awards</h4>';
                                                echo $awards;
                                            endif;
                                            if ($appointments):
                                                echo '<h4>Appointments</h4>';
                                                echo $appointments;
                                            endif;
                                            if ($otherInformation) :
                                                echo $otherInformation;
                                            endif;
                                            if ($doctorWebsite) :
                                                echo '<h4>Visit My Website</h4>';
                                                echo '<a href="'. $doctorWebsite .'">'. $doctorWebsite .'</a>';
                                            endif;
                                            if ($cv) :
                                                echo '<h4>Curriculum Vitae</h4>';
                                                echo '<a href="'. $cv .'" title="Download PDF of CV">See my Curriculum Vitae [PDF]</a>';
                                            endif;
                                        ?>
                                    </div>
                                    <div class="nav fusion-mobile-tab-nav">
                                        <ul class="nav-tabs nav-justified">
                                            <li>
                                                <a class="tab-link" data-toggle="tab" id="mobile-fusion-tab-health-plans" href="#tab-467e1f7fb2120b96eec">
                                                    <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-file-text"></i>Health Plans</h4>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="tab-467e1f7fb2120b96eec">
                                        <?php
                                            if ($acceptedInsurance) :
                                                echo '<h4>Accepted Insurances</h4>';
                                                echo '<ul>';
                                                    foreach ($acceptedInsurance as $insurance) {
                                                       echo '<li>'. $insurance->name .'</li>';
                                                    }
                                                echo '</ul>';
                                            endif;
                                            
                                            echo '<p>See a <a href="/patient-resources/billing-insurance/accepted-insurance/">general list of health plans</a> in which our providers participate.</p>';
                                            echo '<p class="Disclaimer">PLEASE NOTE:  While many of IBJI’s providers participate in various plans from Blue Cross Blue Shield, Aetna,Cigna, Humana, United Healthcare and others, <strong>IBJI strongly encourages you to contact your specific health plan to ensure your chosen doctor is in-network.</strong></p>';
                                            
                                            if ($otherBillingInfo) :
                                                echo '<h4>Billing Information</h4>';
                                                echo $otherBillingInfo;
                                            endif;
                                        ?>
                                    </div>
                                    <?php if ($media) : ?>
                                        <div class="nav fusion-mobile-tab-nav">
                                            <ul class="nav-tabs nav-justified">
                                                <li>
                                                    <a class="tab-link" data-toggle="tab" id="mobile-fusion-tab-media" href="#tab-f84bfb1f8ec69413945">
                                                        <h4 class="fusion-tab-heading"><i class="fa fontawesome-icon fa-play-circle-o"></i>Media</h4>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="tab-f84bfb1f8ec69413945">
                                            <?php
                                                if( have_rows('videos') ): 
                                                    echo '<h4>Videos</h4>';
                                                    while( have_rows('videos') ): the_row(); ?>
                                                        <div class="Video">
                                                            <div class="VideoContainer">
                                                                <?php the_sub_field('video_link'); ?>
                                                            </div>
                                                        </div>
                                                    <?php endwhile;
                                                    echo '<div class="fusion-clearfix"></div>';
                                                endif;
                                            
                                                if( have_rows('audio_files') ): 
                                                    echo '<h4>Audio</h4>';
                                                    while( have_rows('audio_files') ): the_row(); ?>
                                                        <?php $audio = get_sub_field('audio_file'); ?> 
                                                        <div class="Audio">
                                                            <h5 class="AudioFile"><a id="" href="<?php echo $audio['url']; ?>" title="<?php echo $file['title']; ?>" data-rel="prettyPhoto"><i class="fa fa-play" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $audio['title']; ?></a></h5>
                                                            <?php if ($aduio['caption']): ?>
                                                                <p class="AudioCaption"><?php echo $audio['caption']; ?></p>
                                                            <?php endif; ?>
                                                            <?php if ($audio['description']): ?>
                                                                <p class="AudioDescription"><?php echo $audio['description']; ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endwhile;
                                                    echo '<div class="fusion-clearfix"></div>';
                                                endif;
                                            
                                                if ($mediaLinks):
                                                    echo $mediaLinks;
                                                endif;
                                            
                                                if( have_rows('other_files') ): 
                                                    echo '<h4>Media Files</h4>';
                                                    while( have_rows('other_files') ): the_row(); ?>
                                                        <?php $file = get_sub_field('other_file'); ?> 
                                                        <div class="OtherFiles">
                                                            <h5 class="OtherFile"><a href="<?php echo $file['url']; ?>" title="<?php echo $file['title']; ?>"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $file['title']; ?></a></h5>
                                                            <?php if ($file['caption']): ?>
                                                                <p class="OtherFileCaption"><?php echo $file['caption']; ?></p>
                                                            <?php endif; ?>
                                                            <?php if ($file['description']): ?>
                                                                <p class="OtherFileDescription"><?php echo $file['description']; ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endwhile;
                                                    echo '<div class="fusion-clearfix"></div>';
                                                endif;
                                            ?>
                                    
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
        $('#fusion-tab-profile, #mobile-fusion-tab-profile').click(function(){
            setTimeout(function(){
                equalHeight.equalHeight($('.EducationWrap .Education'));
            },500);
        });
    });
</script>   
<?php get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
