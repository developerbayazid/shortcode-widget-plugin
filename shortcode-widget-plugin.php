<?php
/*
 * Plugin Name:       ShortCode Widget WP
 * Plugin URI:        https://github.com/developerbayazid/shortcode-widget-plugin
 * Description:       ShortCode Widget Plugin
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Bayazid Hasan
 * Author URI:        https://github.com/developerbayazid
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       swp
*/

/**
 * ShortCode Functionality
 */

//ShortCode with params
add_shortcode('student', 'swp_handle_student_data');
function swp_handle_student_data($attr = []){
    $swp_attr = shortcode_atts(array(
        'name' => 'Default Name',
        'email' => 'Default Email',
    ), $attr, 'student');
    return "<h3>Student Data: Name- ".$swp_attr['name'].", Email- ".$swp_attr['email']."</h3>";
}

//ShortCode with DB operation
add_shortcode('list-posts', 'swp_handle_list_posts');
function swp_handle_list_posts(){
    global $wpdb;
    
    $table_prefix = $wpdb->prefix; //wp_
    $table_name = $table_prefix."posts"; //wp_posts

    //get posts where post_type = post and post_status = publish
    $posts = $wpdb->get_results(
        "SELECT post_title from {$table_name} WHERE post_type = 'post' AND post_status = 'publish'"
    );

    if(count($posts) > 0){
        $output_html = "<ul>";
        foreach ($posts as $post) {
            $output_html.= "<li>".$post->post_title."</li>";
        }
        $output_html .= "</ul>";
        return $output_html;
    }
    return "No Post Found!";
        
}

//Short Code using wp query
add_shortcode('posts', 'swp_handle_posts');
function swp_handle_posts($attr = []){
    $attr = shortcode_atts(array(
        'number' => 5
    ), $attr, 'posts');

    $query = new WP_Query(array(
        'posts_per_page' => $attr['number'],
        'post_status' => 'publish',
        'order' => 'DESC'
    ));

    if($query->have_posts()){
        $output_html = "<div>";
        while($query->have_posts()){
            $query->the_post();
            $output_html .= '<h2><a href="'.get_the_permalink(  ).'">'.get_the_title().'</a></h2>';
        }
        $output_html .= "</div>";
        return $output_html;
    }
    return "No Post Found!";
}



?>