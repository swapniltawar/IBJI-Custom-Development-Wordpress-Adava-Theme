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

?>
<style>
#main{
    padding: 0 !important;
}
#main section#content {
    width: 100% !important;
}
#main #sidebar, .fusion-page-title-bar {
    display: none;
}
#main .fusion-row {
    max-width: none;
}
.doc_name_filter_sec #doc_name {
    background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/search-icon.png);
    padding-right: 30px;
    background-repeat: no-repeat;
    background-position: 98%;
    color: #000;
}

#doc_name:focus, .removesearchimg{
    background-image: unset !important;
}

.searchimg{
    background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/search-icon.png) !important;
}

@media (min-width:550px) and (max-width:1200px){
#main section#content {
    margin-bottom: 0 !important;
}
}
</style>

<div class="main_backgorund_img" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/images/background-img.png);">
<div class="top_row" id="top_row">
    <div class="row first_row">
        <div class="col-lg-12">
            <h1 class="page-title-h1">FIND A DOCTOR NEAR YOU</h1>
            <h4 class="page-h4">Select a body part to search for one of our top specialists for your specific needs.</h4>
        </div>
    </div>

    <div class="row second_row">

        <div id="back_container" class="col-lg-1"></div>
        <div id="front_container" class="col-lg-3">
            <img id="front_img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/fullbody_front.png" alt=""/>
            <img id="front_rollover_img" />

            <div id="ibji-circle_30" class="ibji-circle" data-x="43" data-y="275" style="left:29%; top:20%" data-termid="30" data-termslug="shoulder" title="Shoulder"></div>
			<div id="ibji-circle_15" class="ibji-circle" data-x="43" data-y="275" style="left:29%; top:92%" data-termid="15" data-termslug="foot and ankle" title="Foot and Ankle"></div>
			<div id="ibji-circle_18" class="ibji-circle" data-x="43" data-y="275" style="left:9%; top:48%" data-termid="18" data-termslug="hand" title="Hand"></div>
			<div id="ibji-circle_20" class="ibji-circle" data-x="43" data-y="275" style="left:32%; top:46%" data-termid="20" data-termslug="hip" title="Hip"></div>
			<div id="ibji-circle_60" class="ibji-circle" data-x="43" data-y="275" style="left:60%; top:67%" data-termid="60" data-termslug="knee" title="Knee"></div>

        </div>

        <div id="back_container" class="col-lg-3">
            <img id="back_img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/fullbody_back.png" alt="" />
            <img id="back_rollover_img" />

            <div id="ibji-circle_65" class="ibji-circle" data-x="43" data-y="275" style="left:48%; top:25%" data-termid="65" data-termslug="spine" title="Spine"></div>
            <div id="ibji-circle_11" class="ibji-circle" data-x="43" data-y="275" style="left:21%; top:33%" data-termid="11" data-termslug="elbow" title="Elbow"></div>
            <div id="ibji-circle_42" class="ibji-circle" data-x="43" data-y="275" style="left:83%; top:45%" data-termid="42" data-termslug="wrist" title="Wrist"></div>

        </div>
        <div id="back_container" class="col-lg-1"></div>
        <div class="col-lg-4" id="dropdown_filter_section" class="dropdown_filter_section">
            <h3 class="page-title-h3">Filter By Doctor:</h3>
            <?php require_once(get_stylesheet_directory().'/doc_page/doc_page_filters.php'); ?>
        </div>
    </div>
</div>
</div>

<div class="bottom_row" id="bottom_row">
    <div class="row third_row">
        <div class="col-lg-12">
            <h2 class="page-title-h2">OUR SPECIALISTS</h2>
	    <div class="total_doc_count"></div>
        </div>
    </div>

    <div class="row fourth_row row-eq-height">

    <?php
    if($_GET){
    ?>
    <style>
        .bottom_row{
            display: block !important;
        }
    </style>
    <?php
        $doc_name = $_GET['doc_name'];
        $doc_name = explode(' - ', $doc_name);
        $doc_fname = $doc_name[0];
        $doc_lname = $doc_name[1];
    
        $doc_loc = $_GET['doc_loc'];
        $doc_type = $_GET['doc_type'];
        $doc_gender = $_GET['doc_gender'];
        $doc_hospital = $_GET['doc_hospital'];
        $body_part = $_GET['body_part'];

	$rand_num = rand(1,10);
          
        $args = array(
            'post_type' => 'doctors',
	    'orderby' => 'RAND('.$rand_num.')',
	    'posts_per_page' => '-1',
        );
        $args['meta_query'] = array();
        $args['meta_query'][0] = array(
            'relation' => 'AND'
        );
    
        $args['tax_query'] = array(
            'relation' => 'AND'
        );
    
        if( $doc_fname != ''){
            $args['meta_query'][0][] = array(
                'key' => 'first_name',
                'value' => $doc_fname
            );
        }
    
        if( $doc_fname != ''){
            $args['meta_query'][] = array(
                'key' => 'last_name',
                'value' => $doc_lname
            );
        }
    
        if( $doc_gender != ''){
            $args['meta_query'][0][] = array(
                'key' => 'gender',
                'value' => $doc_gender
            );
        }
    
        if( $doc_loc != ''){
            $args['meta_query'][0][] = array(
                'key' => 'main_practice_location',
                'value' => $doc_loc,
                'compare' => 'LIKE'
            );
        }
    
        if( $doc_type != ''){
            $args['tax_query'][] = array(
                'taxonomy' => 'doctor-type',
                'field' => 'id',
                'terms' => $doc_type
            );
        }
    
        if( $doc_hospital != ''){
            $args['tax_query'][] = array(
                'taxonomy' => 'hospital-affiliations',
                'field' => 'id',
                'terms' => $doc_hospital
            );
        }

        if( $body_part != ''){
            $args['tax_query'][] = array(
                'taxonomy' => 'anatomies',
                'field' => 'id',
                'terms' => $body_part
            );
        ?>
            <script type='text/javascript'>
                jQuery(document).ready(function(){
                    jQuery('#ibji-circle_<?php echo $body_part ?>').hide();
                    jQuery("#body_part").val(<?php echo $body_part ?>);
                    
                    jQuery("#front_rollover_img").attr("src", '');
                    jQuery("#back_rollover_img").attr("src", '');
                    var drop_val = jQuery("#body_part").val();

                    jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : doc_page.ajaxurl, 
                    data : {action: "appendBodyImg",drop_val:drop_val},        	
                    success: function(response) {
                            if(response.img_type == '1'){
                                jQuery("#front_rollover_img").attr("src", response.img_url);
                            }
                            else if(response.img_type == '0'){
                                jQuery("#back_rollover_img").attr("src", response.img_url);
                            }
                        },
                        complete : function(){				
                        }
                    });
                });
            </script>
        <?php    
        }
      
        $res = new WP_Query( $args );

	if(!empty($res->posts)){
            $counter = 1;
            $grid = 2;
            $data = '';

	    $total_doc = count($res->posts);
	    ?>
	    <script type=text/javascript>
		jQuery('.total_doc_count_text').remove();
	    	jQuery('.total_doc_count').append('<span class="total_doc_count_text">'+<?php echo $total_doc ?>+' Results Found </span>');
            </script>	
	    <?php
            foreach($res->posts as $post){       
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                $specialties_text = get_post_meta($post->ID, 'specialties_text', true);
                
                if($counter == 1){
                    $data .= '<div class="col-lg-6 doc_detail_sec">';
                    $data .= '<div class="img_sec_col" id="img_sec_col1">';
                    $data .= '<img src="'.$image[0].'" id="doc_img1" class="doc_img"/>';
                    $data .='</div>';
                    $data .='<div class="doc_des_col">';
                    $data .='<a href="'.get_permalink($post->ID).'"><h2 class="page-title-h2 doc_name_col" id="doc_name_col1">'.$post->post_title.'</h2></a>';
                    $data .='<div class="doc_specialties_sec">'.$specialties_text.'</div>';
                    $data .='</div>';
                    $data .='</div>';
                }
        
                if($counter == $grid){
                    $data .='<div class="col-lg-6 doc_detail_sec">';
                    $data .='<div class="img_sec_col" id="img_sec_col2">';
                    $data .='<img src="'.$image[0].'" id="doc_img2" class="doc_img"/>';
                    $data .='</div>';
                    $data .='<div class="doc_des_col">';
                    $data .='<a href="'.get_permalink($post->ID).'"><h2 class="page-title-h2 doc_name_col" id="doc_name_col2">'.$post->post_title.'</h2></a>';
                    $data .='<div class="doc_specialties_sec">'.$specialties_text.'</div>';
                    $data .='</div>';
                    $data .='</div>';
                    $counter = 0;
                }
                $counter ++;
            }
        }else{
            $data .= '<div class="doc_detail_sec no_result"> No Result Found. Please try again...</div>';
        }
        echo $data;  
    }
    ?>
    </div>
</div>