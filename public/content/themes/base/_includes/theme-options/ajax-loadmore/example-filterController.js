// NOTE: RENAME AND MOVE TO `_src/assets/scripts/libs/`


jQuery(function($){
 
	/*
	 * Load More
	 */
	$('#ajax_loadmore').click(function(){

        $.ajax({
			url : ajax_loadmore_params.ajaxurl, // AJAX handler
			data : {
				'action': 'loadmorebutton', // the parameter for admin-ajax.php
				'query': ajax_loadmore_params.posts, // loop parameters passed by wp_localize_script()
				'page' : ajax_loadmore_params.current_page // current page
			},
			type : 'POST',
			beforeSend : function ( xhr ) {
				$('#ajax_loadmore .btn-text').text('Loading...'); // some type of preloader
			},
			success : function( posts ){

                if( posts ) {

                    // change as required
                    var itemClass = 'article-card ';
                    
                    // sets all posts to invisible
                    $(posts).css('opacity','0');

                    // appends posts and also adds a class to differentiate current elements with newly loaded
                    $('#ajax_posts_wrap').append( posts.replaceAll(itemClass, itemClass + 'begin-invisible ') ); // insert new posts

                    // animates the newly loaded
                    $($("#ajax_posts_wrap a.begin-invisible").get()).each( function(i, el){

                        $(el).css({'opacity':0,'left':"-50"});
                    
                        setTimeout(function(){
                            $(el).animate({
                            'opacity':1.0,'left':"0"
                            }, 200);
                        },250 + ( i * 250 ));

                        $(el).removeClass("begin-invisible");
                    });
                    
 
                    // replaces the text
					$('#ajax_loadmore .btn-text').text( 'More posts' );
					
                    // current page = next page
					ajax_loadmore_params.current_page++;
 
					if ( ajax_loadmore_params.current_page == ajax_loadmore_params.max_page ) 
						$('#ajax_loadmore').hide(); // if last page, HIDE the button
 
				} else {
					$('#ajax_loadmore').hide(); // if no data, HIDE the button as well
				}
			}
		}).fail(function (jqXHR, textStatus, error) {
            // Handle error here
            console.log(jqXHR.responseText);
           
        });
		return false;
	});
 
	/*
	 * Filter
	 */
	$('#ajax_filters').change(function(){
        console.log(ajax_loadmore_params.post_type);
        var sPT = '&post_type='+ajax_loadmore_params.post_type;
        var ppp = '&ppp='+ajax_loadmore_params.ppp;
		$.ajax({
			url : ajax_loadmore_params.ajaxurl,
			data : $('#ajax_filters').serialize()+sPT+ppp, // form data
			dataType : 'json', // this data type allows us to receive objects from the server
			type : 'POST',
			beforeSend : function(xhr){
			},
			success : function( data ){
                // when filter applied:
                // set the current page to 1
                ajax_loadmore_params.current_page = 1;

                // set the new query parameters
                ajax_loadmore_params.posts = data.posts;

                // set the new max page parameter
                ajax_loadmore_params.max_page = data.max_page;

                $('#ajax_posts_wrap').fadeOut( 250, function() {
                    
                        // insert the posts to the container
                        $('#ajax_posts_wrap').html(data.content);
                        $('#ajax_posts_wrap').css('display','flex');
                        $.each($('#ajax_posts_wrap a'), function(i, el){

                            $(el).css({'opacity':0,'right':"-50px"});
                        
                            setTimeout(function(){
                               $(el).animate({
                                'opacity':1.0,'right':"0"
                               }, 200);
                            },250 + ( i * 250 ));
                        
                        });
                        // hide load more button, if there are not enough posts for the second page
                        if ( data.max_page < 2 ) {
                            $('#ajax_loadmore').hide();
                        } else {
                            $('#ajax_loadmore').show();
                        }

                  });
 
			}
		});
 
		// do not submit the form
		return false;
 
	});

    /**
     * Function used in example as terms radio button changes to dropdown on mobile
     */
    $("[name^='ajax_category']").change(function(){
        $("select[name^='ajax_category']").val(this.value);
        $("[name^='ajax_category'][value='" + this.value + "']").prop('checked',true);
    });
 
});