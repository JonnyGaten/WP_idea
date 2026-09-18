<?php 
if(class_exists('loadMoreOptions')){


    // only enqueue if module is loaded
    wp_enqueue_script( 'rb_ajaxscripts_enqueue' );

    // example data
    $terms = get_terms( 'tax-content-type' );
    ?>


    <div class="container">
        <div class="row">
            <form id="ajax_filters" action="#" class="col-12 mb-5 mb-lg-6">
                

                <?php if($terms){?>
                        <div class="d-none d-lg-block">
                            <label for="term-all"><input type="radio" id="term-all" name="ajax_category" value="0" checked><span>All</span></label>
                            <?php foreach($terms as $term){?>
                                <label for="term-<?=$term->slug;?>"><input type="radio" id="term-<?=$term->slug;?>" name="ajax_category" value="<?=$term->term_id;?>"><span><?=$term->name;?></span></label>
                            <?php };?>
                        </div>
                        <div class="custom-select d-lg-none">
                            <select name="ajax_category">
                                    <option value="0">All</option><!-- it is from Settings > Reading -->

                                <?php foreach($terms as $term){?>
                                    <option value="<?=$term->term_id;?>"><?=$term->name;?></option>
                                <?php };?>
                                
                            </select>
                        </div>
                        
                    
                <?php };?>
            
                <!-- required hidden field for admin-ajax.php -->
                <input type="hidden" name="action" value="ajaxfilter" />
            

            </form>
        </div>
    </div>
    <!-- Filters will be here -->
    <div class="container mb-4 mb-lg-6">
        <div id="ajax_posts_wrap" class="row article-grp-rows no-gutters">
            <!-- Posts will be here -->
            <?php 

            // Load options
            $opt = new loadMoreOptions();

            // get default params
            $params = $opt->defaultParams();
        
            // wp query
            $the_query = new WP_Query( $params );

            // if posts
            if ( $the_query->have_posts() ) : 
                
        
                ob_start(); // start buffering because we do not need to print the posts now
        
                while ( $the_query->have_posts() ) :
                    $the_query->the_post(); 
        
                    // suggest: function here to grab post data snippet, then load a component
                    echo '<div class="article-card">'.get_the_title(get_the_ID()).'</div>';

                    
                endwhile;

                // we pass the posts to variable
                $posts_html = ob_get_contents(); 

                // clear the buffer
                ob_end_clean(); 

            else:

                $posts_html = '<p>Nothing found for your criteria.</p>';

            endif;
            
            // Now we echo all posts
            echo $posts_html;

            ?>
        </div>
    </div>
    <!-- Load more button will be here -->

    <?php

    // global $wp_query;
    if (  $the_query->max_num_pages > 1 ) :?>
        
        <div class="container my-4 my-lg-6">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <div  id="ajax_loadmore" class="btn btn--primary btn-sweep justify-content-between border-md" style="max-width:100%;"><span class=" letter-spacing-vwide btn-text btn-text-lg font--weight-regular w-100 d-flex align-items-center">load more</span><span class="icon icon-lg icon-arrow-down-white"></span></div>
                </div>
            </div>
        </div>

    <?php endif;?>

<?php }