<?php
$loc_args = array(
    'post_type' =>  'locations',
    'order' => 'ASC'
);
$loc_posts = get_posts($loc_args);

$body_part_args = array(
    'taxonomy' => 'anatomies',
    'hide_empty' => false,
);
$body_part_terms = get_terms($body_part_args);

$doc_type_args = array(
    'taxonomy' => 'doctor-type',
    'hide_empty' => false,
);
$doc_type_terms = get_terms($doc_type_args);

$doc_hospital_args = array(
    'taxonomy' => 'hospital-affiliations',
    'hide_empty' => false,
);
$doc_hospital_terms = get_terms($doc_hospital_args);
?>

<!-- <form action="" method="GET" id="doc_page_filter_form" class="doc_page_filter_form"> -->
<div id="doc_page_filter_form" class="doc_page_filter_form">
    <div class="doc_name_filter_sec doc_filter_sec">
        <label for="name">Full Name</label><br>
        <input type="text" name="doc_name" value="" id="doc_name" data-img="<?php echo get_stylesheet_directory_uri(); ?>/images/search-icon.png"/>
    </div>

    <div class="doc_location_filter_sec doc_filter_sec">
        <label for="doc_loc">Choose a Location</label><br>
        <select name="doc_loc" value="" id="doc_loc">
            <option value="">Any</option>
            <?php
            foreach($loc_posts as $loc_post){ ?>
                <option value="<?php echo $loc_post->ID ?>"><?php echo $loc_post->post_title ?></option>
            <?php
            }
            ?>
        </select>
    </div>    

    <div class="doc_type_filter_sec doc_filter_sec">
        <label for="doc_type">Type Of Doctor</label><br>
        <select name="doc_type" value="" id="doc_type">
            <option value="">Any</option>
            <?php
            foreach($doc_type_terms as $doc_type_term){ ?>
                <option value="<?php echo $doc_type_term->term_id ?>"><?php echo $doc_type_term->name ?></option>
            <?php    
            }
            ?>
        </select>
    </div>

    <div class="body_part_filter_sec doc_filter_sec">
        <label for="body_part">Body Part</label><br>
        <select name="body_part" value="" id="body_part">
            <option value=""> Any </option>
            <?php
            foreach($body_part_terms as $body_part_term){ ?>
                <option value="<?php echo $body_part_term->term_id ?>"><?php echo $body_part_term->name ?></option>
            <?php    
            }
            ?>
        </select>
    </div>

    <div class="doc_gender_filter_sec doc_filter_sec">
        <label for="doc_gender">Gender</label><br>
        <input type="radio" name="doc_gender" id="doc_gender" value="male" class="gender_radio"><span class="radio_text">Male</span><br>
        <input type="radio" name="doc_gender" id="doc_gender" value="female" class="gender_radio"><span class="radio_text">Female</span><br>
    </div>    

    <div class="doc_affiliation_filter_sec doc_filter_sec">
        <label for="doc_affiliation">Hospital Affiliations</label><br>
        <select name="doc_hospital" value="" id="doc_hospital">
        <option value=""> Any </option>
        <?php
        foreach($doc_hospital_terms as $doc_hospital_term){ ?>
            <option value="<?php echo $doc_hospital_term->term_id?>"><?php echo $doc_hospital_term->name; ?></option>
        <?php
        }
        ?>
        </select>
    </div>

    <div class="doc_form_filter_btn_sec">
        <a id="doc_reset_btn" class="doc_reset_btn">Reset</a>
        <input type="submit" value="Search" id="doc_search" name="doc_search" class="doc_search_btn">
	<div id='loadingmessage' style='display:none'>
        	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bx_loader.gif"/>
    	</div>
    </div>
</div>
<!-- </form> -->

<script type="text/javascript">

jQuery(document).ready(function(){
	var fullname = function() {
	var tmp = jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: doc_page.ajaxurl,
                data: 'action=get_doc_page_names',
		async: false,
                success: function(data) { 
		}
            }).responseText;
	  return tmp;
	}();

fullname = jQuery.parseJSON(fullname);

jQuery('#doc_name').autoComplete({
                minChars: 1,
                source: function(term, suggest){
                    term = term.toLowerCase();
                    var choices = fullname;
                    var suggestions = [];
                    for (i=0;i<choices.length;i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);
                }
            });
});
</script>