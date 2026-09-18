<?php
class loadMoreOptions {

    // Default vars
    public $ppp = 1;
    public $cpt = 'cpt-articles';
    public $orderby = 'date';
    public $order = 'ASC';
    public $scriptName = 'example-filterController.js';

    public function paged() {
        return ( get_query_var('page') ) ? get_query_var('page') : 1;
    }

    /**
     * Default settings for ajax loadmore parameters
     *
     * @return array
     */
    public function defaultParams(){

        return array(
            'posts_per_page' => $this->ppp, 
            'orderby' => $this->orderby,
            'order'	=> $this->order, 
            'post_type'=>$this->cpt,
            'paged' => $this->paged()
        );
    }

    // Create your own

    // public function newParams(){
    //     return array(
    //         'posts_per_page' => 3, 
    //         'orderby' => $this->orderby, 
    //         'order'	=> $this->order, 
    //         'post_type'=> 'cpt-team',
    //         'paged' => $this->paged()
    //     );
    // }
}


add_action( 'wp_enqueue_scripts', 'rb_ajaxscripts_enqueue');
function rb_ajaxscripts_enqueue() {

    // Load options
    $opt = new loadMoreOptions();
    
    // Get default parameters
	$params = $opt->defaultParams();

    // New wp query with params
    $the_query = new WP_Query( $params );

    // wp_register_script( 'rb_ajaxscripts_enqueue', get_stylesheet_directory_uri() . '/_dist/js/libs/'.$opt->scriptName, array('jquery') );
	wp_register_script( 'rb_ajaxscripts_enqueue', get_stylesheet_directory_uri() . '/_includes/theme-options/ajax-loadmore/'.$opt->scriptName, array('jquery') );
 
	// passing parameters here
	wp_localize_script( 'rb_ajaxscripts_enqueue', 'ajax_loadmore_params', array(
		'ajaxurl'       => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts'         => json_encode( $the_query->query_vars ), // everything about your loop is here
		'current_page'  => $opt->paged(),
		'max_page'      => $the_query->max_num_pages,
		'post_type'     => $opt->cpt,
		'ppp'	        => $opt->ppp
	) );

}



add_action('wp_ajax_loadmorebutton', 'ajax_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_loadmorebutton', 'ajax_loadmore_ajax_handler');
 
function ajax_loadmore_ajax_handler(){
 
	// prepare our arguments for the query
	$params = json_decode( stripslashes( $_POST['query'] ), true ); // query_posts() takes care of the necessary sanitization 
	$params['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$params['post_status'] = 'publish';
 
	// it is always better to use WP_Query but not here
	query_posts( $params );
 
    
	if( have_posts() ) :
 
		// run the loop
		while( have_posts() ): the_post();
 
            // add your template
            echo '<div class="article-card">'.get_the_title(get_the_ID()).'</div>';
 
 
		endwhile;
	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}
 
 
 
add_action('wp_ajax_ajaxfilter', 'ajax_filter_function'); 
add_action('wp_ajax_nopriv_ajaxfilter', 'ajax_filter_function');
 
function ajax_filter_function(){

    // pass variables
    $tax_query = array();
    $cat = $_POST['ajax_category'];
    $pt = $_POST['post_type'];
    $ppp = $_POST['ppp'];

    // check if cat exists
    if($cat){
        // add to tax_query
        $tax_query[] = array(
            'taxonomy'      =>  'tax-content-type',
            'field'         =>  'term_id',
            'terms'         =>  array($cat)
        );
    };
    
	$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
	$params = array(
		'posts_per_page' => $ppp, // when set to -1, it shows all posts
		'orderby' => 'date', // example: date
		'order'	=> 'ASC', // example: ASC
        'post_type'=>$pt,
		'paged' => $paged,
        'tax_query'=> $tax_query
	);
 
 

     $the_query = new WP_Query( $params );
	
	if ( $the_query->have_posts() ) : 
        
 
 		ob_start(); // start buffering because we do not need to print the posts now
 
         while ( $the_query->have_posts() ) :
            $the_query->the_post(); 
 
			// adapted for Twenty Seventeen theme
            echo '<div class="article-card">'.get_the_title(get_the_ID()).'</div>';
            
		endwhile;
 
 		$posts_html = ob_get_contents(); // we pass the posts to variable
   		ob_end_clean(); // clear the buffer
	else:
		$posts_html = '<p>Nothing found for your criteria.</p>';
	endif;
 
	// no wp_reset_query() required
 
 	echo json_encode( array(
		'posts' => json_encode( $the_query->query_vars ),
		'max_page' => $the_query->max_num_pages,
		'found_posts' => $the_query->found_posts,
		'post_type'	=> $the_query->found_posts,
		'content' => $posts_html
	) );
 
	die();
}
