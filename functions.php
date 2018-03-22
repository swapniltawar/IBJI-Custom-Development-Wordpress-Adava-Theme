<?php

require_once(get_stylesheet_directory().'/doc_page/doc_page_function.php');
require_once(get_stylesheet_directory().'/doc_page/doc_page_ajax_function.php');

//CREATE CHILD THEME
function theme_enqueue_styles() {
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', ['avada-stylesheet']);
    
    if (is_singular('doctors')) {
       wp_enqueue_style('doctors-style', get_stylesheet_directory_uri() . '/css/doctor-profile.css'); 
    }
    
    if (is_singular('staff')) {
       wp_enqueue_style('team-style', get_stylesheet_directory_uri() . '/css/doctor-profile.css'); 
    }
    
    if (is_singular('locations')) {
       wp_enqueue_style('locations-style', get_stylesheet_directory_uri() . '/css/location-profile.css'); 
    }
    
    if (is_post_type_archive('doctors') || is_post_type_archive('staff')  ) {
       wp_enqueue_style('doctor-results-style', get_stylesheet_directory_uri() . '/css/doctor-results.css'); 
    }
    
    if (is_post_type_archive('locations')) {
       wp_enqueue_style('location-results-style', get_stylesheet_directory_uri() . '/css/location-results.css'); 
    }

    wp_enqueue_script('jquery');
    wp_enqueue_script( 'doc_page_js', get_stylesheet_directory_uri().'/js/doc_page.js');
    wp_localize_script( 'doc_page_js', 'doc_page', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

    wp_enqueue_script('autocomplete', get_stylesheet_directory_uri().'/js/jquery.auto-complete.js', array('jquery'));
    wp_enqueue_style('autocomplete.css', get_stylesheet_directory_uri().'/js/jquery.auto-complete.css');

}

//function theme_enqueue_scripts() {
//    //wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer);
//    wp_enqueue_script('script', get_stylesheet_directory_uri() . '/avada-child.js', ['jquery'], TRUE);
//}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
//add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

function avada_lang_setup() {
    $lang = get_stylesheet_directory() . '/languages';
    load_child_theme_textdomain('Avada', $lang);
}

add_action('after_setup_theme', 'avada_lang_setup');



//Enqueue Styles for Geonetric Related Doctors and Geonetric Related Locations Plugins
function geo_styles() {
    
    if ( is_plugin_active( '/plugins/geonetric-related-doctors.php' || '/plugins/geonetric-related-locations.php' ) ) {
        // Plugin is active
        $dir = trailingslashit( plugins_url( '/', $file ) );
        wp_enqueue_style('plugin-style', $dir . 'wp-posts-carousel/templates/light.css');
    }
}
add_action('wp_enqueue_scripts', 'geo_styles');


// MOVE STUFF AROUND IN THE ADVANCED CUSTOM FIELDS ADMIN
function my_acf_admin_head() {
    ?>
    <script type="text/javascript">
        (function ($) {

            $(document).ready(function () {
                // Admin styles for Advanced Custom Fields

                // Move main content area into the profile tab on doctors AND Locations
                $('#postdivrich').insertAfter('.acf-field p.BioLabel');
                $('p.BioLabel').addClass('Hide');
                
                // Hide taxonomy and other sidebar fields that are not needed bedause we are applying those through ACF instead
                $('#side-sortables #service-linesdiv, #side-sortables #tagsdiv-regions, #side-sortables #tagsdiv-professional-titles, #side-sortables #specialtiesdiv, #side-sortables #hospital-affiliationsdiv, #side-sortables #tagsdiv-additional-languages, #side-sortables #tagsdiv-promotional-designations, #side-sortables #tagsdiv-location-types, #side-sortables #anatomiesdiv, #side-sortables #tagsdiv-certifications, #side-sortables #tagsdiv-eligible-certifications, #side-sortables #accepted-insurancesdiv, #side-sortables #job_titlesdiv').addClass('Hide');

            });
        })(jQuery);
    </script>
    <style type="text/css">
        .acf_postbox .field_type-message p.label {
            display: block;
        }

        .acf-field #wp-content-editor-tools {
            background: transparent;
            padding-top: 0;
        }

        .BioLabel, .EdLabel, .AddLabel {
            color: #333333;
            font-size: 17px;
            line-height: 1.5em;
            font-weight: bold;
            padding: 0;
            margin: 0 0 3px;
            display: block;
            vertical-align: text-bottom;
        }

        .Hide {
            display: none;
        }
    </style>
    <?php
}

add_action('acf/input/admin_head', 'my_acf_admin_head');


//GOOGLE MAPS API KEY -- THIS ONE IS USED TO DISPLAY THE MAP ON THE FRONT END
function nr_load_scripts() {
    if (is_singular('doctors') || is_singular('locations') || is_singular('staff')) {
        //The following is key is was set up using Amanada's personal gmail account - use the one on staging sites only
        //wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAi_zE8AKf69SMhRbVmbE5wDxB6H4Svg88', NULL, NULL, TRUE);
        //The following is from IBJI - use the one when the site goes live
        wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDaJsxMMQeATTOWU20BNUo5iMAcXG_c1T8', NULL, NULL, TRUE);

        wp_enqueue_script('googlemaps');
    }
}

add_action('wp_enqueue_scripts', 'nr_load_scripts');



// Hide Advanced Custom Fields for anyone who is NOT an admin or super admin
function my_acf_show_admin($show) {
    return current_user_can('manage_options');
}

add_filter('acf/settings/show_admin', 'my_acf_show_admin');


////REGISTERING NEW SIDEBARS FOR CHILD THEME
add_action('widgets_init', 'avada_child_widgets_init');
function avada_child_widgets_init() {
    register_sidebar([
        'name'          => __('Doctors Sidebar', 'theme-slug'),
        'id'            => 'doctors-sidebar',
        'description'   => __('Widgets in this area will be shown to the left of the list of doctors ONLY on the doctors archive search page.', 'theme-slug'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ]);
    register_sidebar([
        'name'          => __('Locations Sidebar', 'theme-slug'),
        'id'            => 'location-sidebar',
        'description'   => __('Widgets in this area will be shown to the left of the list of locations ONLY on the locations archive search page.', 'theme-slug'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ]);
    register_sidebar([
        'name'          => __('Staff Sidebar', 'theme-slug'),
        'id'            => 'staff-sidebar',
        'description'   => __('Widgets in this area will be shown to the left of the list of staff or team-members ONLY on the team-members archive (search) page.', 'theme-slug'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ]);
    register_sidebar([
        'name'          => __('Patient Stories Sidebar', 'theme-slug'),
        'id'            => 'patient-stories-sidebar',
        'description'   => __('Widgets in this area will be shown to the left of the list of stories ONLY on the patient stories archive (search) page.', 'theme-slug'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ]);
    register_sidebar([
        'name'          => __('News Sidebar', 'theme-slug'),
        'id'            => 'news-sidebar',
        'description'   => __('Widgets in this area will be shown to the left of the list of news stories ONLY on the news archive (search) page.', 'theme-slug'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ]);
}


/**
*
*   The Code below will modify the main WordPress loop, before the queries fired,
*   to show all doctors, ordered Asending by slug name and should only work on the doctors archive page.
*
*/
function archive_query($query){

    if ( $query->is_archive('doctors') && $query->is_main_query() && ! is_admin() ) {
        $query->set( 'posts_per_page', '-1'); // Show all posts
        $query->set( 'order', 'ASC');
        $query->set( 'orderby', 'rand' ); 
            // 'name' - Order by post name (post slug). ('post_name' is also accepted.)
            // Could also order by 'title' - Order by title. ('post_title' is also accepted.)
    }

    if ( $query->is_archive('staff') && $query->is_main_query() && ! is_admin() ) {
        $query->set( 'posts_per_page', '-1'); // Show all posts
        $query->set( 'order', 'ASC');
        $query->set( 'orderby', 'name' ); 
            // 'name' - Order by post name (post slug). ('post_name' is also accepted.)
            // Could also order by 'title' - Order by title. ('post_title' is also accepted.)
    }
    
    if ( $query->is_archive('locations') && $query->is_main_query() && ! is_admin() ) {
        $query->set( 'posts_per_page', '-1'); // Show all posts
        $query->set( 'order', 'ASC');
        $query->set( 'orderby', 'name' ); 
            // 'name' - Order by post name (post slug). ('post_name' is also accepted.)
            // Could also order by 'title' - Order by title. ('post_title' is also accepted.)
    }    
}

add_action('pre_get_posts','archive_query');



add_action('template_redirect', 'avada_sidebar_extra');
function avada_sidebar_extra() {
    /**
     * This should change the sidebars needed for archive pages
     *
     * There is an array called _sidebars the setup is this way:
     * 'post_slug' => ['avada_sidebar_slot', 'registered_sidebar']
     *
     * So for example to use the location-sidebar above in sidebar-1:
     * 'locations' => ['sidebar_1', 'location-sidebar']
     *
     */
    $_sidebars = [
        'doctors' => ['sidebar_1', 'doctors-sidebar'],
        'locations' => ['sidebar_1', 'location-sidebar'],
        'staff' => ['sidebar_1', 'staff-sidebar'],
        'patient-stories' => ['sidebar_1', 'patient-stories-sidebar'],
        'news' => ['sidebar_1', 'news-sidebar']
    ];

    $_type = get_post_type();
    $_slug = '';
    if (!is_search()) {
        if ($_type) {
            $post_data = get_post_type_object($_type);
            $_slug = $post_data->rewrite['slug'];
        }
    }
   

    if (array_key_exists($_slug, $_sidebars)) {
        $_sidebar = $_sidebars[$_slug];
        $_layout_sidebars = Avada()->layout->sidebars;

        $_layout_sidebars[$_sidebar[0]] = $_sidebar[1];
        Avada()->layout->sidebars = $_layout_sidebars;
    }
}
