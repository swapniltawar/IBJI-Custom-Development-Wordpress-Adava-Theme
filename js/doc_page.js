jQuery(document).ready(function(){

    jQuery('#doc_name').keydown(function(){
	if(jQuery(this).val()){
	    jQuery(this).removeClass('searchimg');
	    jQuery(this).addClass('removesearchimg');
    	}
    });

    jQuery('#doc_name').blur(function(){
	if(jQuery(this).val()){

    	}else{
	    jQuery(this).removeClass('removesearchimg');
	    jQuery(this).addClass('searchimg');
	}
    });

    function dropdown_click_fun(){
        jQuery("#front_rollover_img").attr("src", '');
        jQuery("#back_rollover_img").attr("src", '');
        var drop_val = jQuery("#body_part").val();

        jQuery.ajax({
		  type : "post",
		//   context: this,
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
    }

    jQuery('#body_part').change(function(){
        var drop_val = jQuery("#body_part").val();
        jQuery('.ibji-circle').show();
        jQuery("#ibji-circle_"+drop_val).hide();
        dropdown_click_fun();
    });

    jQuery(".ibji-circle").click(function(){
        jQuery('.ibji-circle').show();
        jQuery(this).hide();
        termid = jQuery(this).data('termid');
        jQuery("#body_part").val(termid);
        dropdown_click_fun();
    });

    jQuery('#doc_search').click(function(){
            
        var doc_name = jQuery('#doc_name').val();
        var doc_loc = jQuery('#doc_loc').val();
        var doc_type = jQuery('#doc_type').val();
        var doc_gender = jQuery('input[name="doc_gender"]:checked').val();
        var doc_hospital = jQuery('#doc_hospital').val();
        var body_part = jQuery('#body_part').val();

        var url ='';

        if(doc_name){
            url = '?doc_name='+doc_name;
        }
        
        if(doc_loc){
            if (url.indexOf("?") < 0)
                url += "?";
            else
                url += "&";

            url += 'doc_loc='+doc_loc;
        }

        if(doc_type){

            if (url.indexOf("?") < 0)
                url += "?";
            else
                url += "&";

            url += 'doc_type='+doc_type;
        }

        if(doc_gender){

            if (url.indexOf("?") < 0)
                url += "?";
            else
                url += "&";

            url += 'doc_gender='+doc_gender;
        }

        if(doc_hospital){

            if (url.indexOf("?") < 0)
                url += "?";
            else
                url += "&";

            url += 'doc_hospital='+doc_hospital;
        }

        if(body_part){

            if (url.indexOf("?") < 0)
                url += "?";
            else
                url += "&";

            url += 'body_part='+body_part;
        }

        window.history.pushState({} , '' , url);

	jQuery('#loadingmessage').show();
        
        jQuery.ajax({
            type: 'GET',
            dataType: 'html',
            url: doc_page.ajaxurl,
            data: 'action=get_doc_page_search_result&doc_name='+doc_name+'&doc_loc='+doc_loc+'&doc_type='+doc_type+'&doc_gender='+doc_gender+'&doc_hospital='+doc_hospital+'&body_part='+body_part,
            success: function(data) {
                jQuery('.fourth_row .doc_detail_sec').remove();
		jQuery('.total_doc_count_text').remove();
                jQuery('.bottom_row').show();
                if(data != ''){
                jQuery('.fourth_row').append(data);
                }else{
                jQuery('.fourth_row').append('<div class="doc_detail_sec no_result"> No Result Found. Please try again...</div>');
                }
		jQuery('#loadingmessage').hide();
		jQuery('html, body').animate({
        		scrollTop: jQuery("#bottom_row").offset().top - 100
    		}, 2000);
		jQuery(window).trigger('resize');
            }
        });
    });

    jQuery('#doc_reset_btn').click(function(){
    /**    var url = window.location.href.split("?")[0];
        window.location.href= url;  **/   //  Reload page functionality

	jQuery('#doc_name').val('');
	jQuery('#doc_loc').val('');
	jQuery('#doc_type').val('');
	jQuery('#body_part').val('');
	jQuery('#doc_gender').prop("checked", false);
	jQuery('#doc_hospital').val('');

	jQuery('#back_rollover_img').attr('src','');
	jQuery('#front_rollover_img').attr('src','');
        jQuery('.ibji-circle').show();

	var url = window.location.href.split("?")[0];
	window.history.pushState({} , '' , url);

	jQuery('.bottom_row').hide();
    });

 /*   jQuery('#doc_name').autoComplete({
        source: function(name, response) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: doc_page.ajaxurl,
                data: 'action=get_doc_page_names&name='+name,
                success: function(data) { 
                    response(data);
                    jQuery('#doc_name').value = data;
                }
            });
        }
    }); */
});