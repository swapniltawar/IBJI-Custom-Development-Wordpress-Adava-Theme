<?php
add_action( "wp_ajax_appendBodyImg", "appendBodyImg" );
add_action( "wp_ajax_nopriv_appendBodyImg", "appendBodyImg" );
function appendBodyImg(){
		$cat_id = $_POST['drop_val'];

		if(! defined( 'ABSPATH' )){
			echo "Unauthorized request.";
			exit;
		}
		
		$cat_info = get_term($cat_id);
		$cat = get_option('tax_meta_'.$cat_id);
		$img_type = get_option('img_taxonomy_'.$cat_id);
		$img_type = $img_type['featured'];

		$image_id = get_term_meta ( $cat_id, 'category-image-id', true );

		$cat_img_url = wp_get_attachment_image_src( $image_id , 'full')['0'];

		$data = array();
		$data['img_url'] = $cat_img_url;
		$data['img_type'] = $img_type;
		
        echo json_encode($data);	
		exit;
}

add_action('wp_ajax_nopriv_get_doc_page_search_result', 'get_doc_page_search_result');
add_action('wp_ajax_get_doc_page_search_result', 'get_doc_page_search_result'); 
function get_doc_page_search_result() {
    $doc_name = $_GET['doc_name'];
    $doc_name = explode(' ', $doc_name);
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

    if(!empty($doc_fname)){
        $args['meta_query'][0][] = array(
            'key' => 'first_name',
            'value' => $doc_fname
        );
    }

    if( !empty($doc_lname)){
        $args['meta_query'][] = array(
            'key' => 'last_name',
            'value' => $doc_lname
        );
    }

    if( !empty($doc_gender) && $doc_gender != 'undefined'){
        $args['meta_query'][0][] = array(
            'key' => 'gender',
            'value' => $doc_gender
        );
    }

    if( !empty($doc_loc)){
        $args['meta_query'][0][] = array(
            'key' => 'main_practice_location',
            'value' => $doc_loc,
            'compare' => 'LIKE'
        );
    }

    if( !empty($doc_type)){
        $args['tax_query'][] = array(
            'taxonomy' => 'doctor-type',
            'field' => 'id',
            'terms' => $doc_type
        );
    }

    if( !empty($doc_hospital)){
        $args['tax_query'][] = array(
            'taxonomy' => 'hospital-affiliations',
            'field' => 'id',
            'terms' => $doc_hospital
        );
    }

    if( !empty($body_part)){
        $args['tax_query'][] = array(
            'taxonomy' => 'anatomies',
            'field' => 'id',
            'terms' => $body_part
        );
    }

    $res = new WP_Query( $args );

    $counter = 1;
    $grid = 2;
    $data = '';

    $total_doc = count($res->posts);

    if($total_doc != 0){
    ?>
    <script type=text/javascript>
	jQuery('.total_doc_count_text').remove();
	jQuery('.total_doc_count').append('<span class="total_doc_count_text">'+<?php echo $total_doc ?>+' Results Found </span>');
    </script>	
    <?php
    }

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
    echo $data;  
    die();
}

add_action('wp_ajax_nopriv_get_doc_page_names', 'get_doc_page_names');
add_action('wp_ajax_get_doc_page_names', 'get_doc_page_names');   
function get_doc_page_names() {
    //$name = stripslashes($_POST['name']);   
    $args = array(
                'numberposts'   => '-1',
                'post_type'     => 'doctors'
            );
    $doctors = get_posts($args);
    
    $doc_id = array();
    foreach($doctors as $doctor){
        $doc_id[] = $doctor->ID;
    }

    $first_name = array();
    foreach($doc_id as $k=>$v){ 
        $current_first_name = get_post_meta($v,'first_name',true);
        $current_last_name = get_post_meta($v,'last_name',true);
        $fullname = $current_first_name .' '. $current_last_name;
        
       // if(strpos(strtolower($fullname), strtolower($name)) !== false){
            $first_name[] = $fullname;
       // }
    }      
    echo json_encode($first_name);
    die(); 
}
?>