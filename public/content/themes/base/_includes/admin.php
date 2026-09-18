<?php



/**
 * Funct
 *
 * @param [type] $post_id
 * @return void
 */
function rb_admin__update_post_meta_with_ttr($post_id, $post_after, $post_before)
{

    if ($post_before->post_type == 'cpt-articles') :

        $meta_key = 'ttr';
        $meta_value = rb_get__time_to_read($post_after->post_content);
        update_post_meta($post_id, $meta_key, $meta_value);

    endif;
}
add_action('post_updated', 'rb_admin__update_post_meta_with_ttr', 10, 3);
