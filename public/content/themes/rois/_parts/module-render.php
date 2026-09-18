<?php

/**
* Renders the correct modules
* Specifies data and fields to use
* and renders the correct template
*
* @return array
*/
function ra__render_modules($id = '')
{
    if(empty($id)){
        $id = get_the_ID();
    }


    if (have_rows('page-builder', $id)) :
        while (have_rows('page-builder', $id)) : the_row();
    
        // Returns the correct module data
        $data = ra__get_module_data(get_row_layout());
        
        // Load the correct module template
        include(locate_template('./_parts/modules/' . get_row_layout() . '.php'));

        // OLD DATA THAN SHOULD BE MOVED AS ABOVE
        $data = array();

        endwhile;
    endif;
}


/**
 * Returns the correct module data
 *
 * @param string $module name
 * @return array of module $data1
 */
function ra__get_module_data($module)
{
    $data = array();
    if($module){

            switch ($module) {

                case 'text_and_image':
                   
                    break;


                case 'cta':
                   
                    break;


                case 'video_full_width':
                   
                    break;


                case 'display_posts':
                    $criteria = get_sub_field('criteria') ?: 'recent';
                    $post_type = get_sub_field('post_type') ?: 'cpt-articles';

                    if ($criteria === 'handpick') {
                        $data['posts'] = get_sub_field('handpick-articles');
                    } else {
                        // 'recent' and 'all' both pull the latest posts of the chosen type;
                        // 'by-tag' needs a taxonomy-term picker field added per project before it can filter.
                        $data['posts'] = get_posts(array(
                            'post_type'      => $post_type,
                            'posts_per_page' => $criteria === 'all' ? -1 : 4,
                            'post_status'    => 'publish',
                        ));
                    }

                    $data['show_filter'] = (bool) get_sub_field('filter');
                    break;


                case 'accordion':
                   
                    break;


                case 'quote':
                   
                    break;

                    
                case 'vacancies':
                   
                    break;

                    
                case 'team':
                   
                    break;

                    
                case 'timeline':
                   
                    break;

                    
                case 'text_only':
                   
                    break;
                    
                case 'image_gallery':
                   
                    break;
                    
                case 'contact_form':
                   
                    break;
                    
                case 'map':
                   
                    break;
                    
                case 'carousel':
                   
                    break;


                case 'spacer':
                        $array = array('smallest', 'small', 'medium', 'large', 'largest');
                        $data['size'] = $array[get_sub_field('spacer')];

                    break;

            }


        return $data;
        }
            
}