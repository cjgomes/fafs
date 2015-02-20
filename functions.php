<?php

function fafs_menu(){
  register_nav_menus( array(
    'primary' => 'Primary Navigation'
  ));
}

add_action( 'after_setup_theme', 'fafs_menu' );

	if (function_exists('register_sidebar'))
		register_sidebar (array(
			'before_widget' => '<div class="widgets">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
			
			));

add_filter('the_content_feed', 'rss_post_thumbnail');
function rss_post_thumbnail($content) {
	global $post;
	if( has_post_thumbnail($post->ID) )
		$content = '<p>' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</p>' . $content;
	return $content;
}

add_theme_support( 'post-thumbnails' );

function fafs_setup() {
	update_option('thumbnail_size_w', 290);
    update_option('thumbnail_size_h', 290);
    add_image_size( 'mini-thumbnail', 50, 50, true );
    add_image_size( 'slide', 550, 300, true );
}
add_action( 'init', 'fafs_setup' );

function fafs_scripts() {


     wp_enqueue_script('jquery');
			wp_enqueue_script('cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', 'jquery', false);
			wp_enqueue_script('cookie', get_template_directory_uri() . '/js/jquery.cookie.js', 'jquery', false);

            wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js', 'jquery', false);
}

add_action('wp_enqueue_scripts', 'fafs_scripts');


/*** Slideshow ***/

$prefix = 'sgt_';

$meta_box = array(
    'id' => 'slide',
    'title' => 'Slideshow Options',
    'page' => 'post',
    'context' => 'side',
    'priority' => 'low',
    'fields' => array(
        array(
            'name' => 'Show in slideshow',
            'id' => $prefix . 'slide',
            'type' => 'checkbox'
        )
    )
);
add_action('admin_menu', 'sight_add_box');

// Add meta box
function sight_add_box() {
    global $meta_box;

    add_meta_box($meta_box['id'], $meta_box['title'], 'sight_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}

// Callback function to show fields in meta box
function sight_show_box() {
    global $meta_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="sight_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>',
                '<th style="width:50%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
        echo     '<td>',
            '</tr>';
    }

    echo '</table>';
}

add_action('save_post', 'sight_save_data');

// Save data from meta box
function sight_save_data($post_id) {
    global $meta_box;

    // verify nonce
    if (!wp_verify_nonce($_POST['sight_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}
function improved_trim_excerpt($text) {
				global $post;
				if ( '' == $text ) {
								$text = get_the_content('');
								$text = apply_filters('the_content', $text);
								$text = str_replace('\]\]\>', ']]&gt;', $text);
								$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
								$text = strip_tags($text, '<p>');
								$excerpt_length = 50;
								$words = explode(' ', $text, $excerpt_length + 1);
								if (count($words)> $excerpt_length) {
												array_pop($words);
												array_push($words, '[...]');
												$text = implode(' ', $words);
								}
				}
				return $text;
}

function new_excerpt_length($length) {
	return 200;
}
add_filter('excerpt_length', 'new_excerpt_length');

function smart_excerpt($string, $limit) {
    $words = explode(" ",$string);
    if ( count($words) >= $limit) $dots = '...';
    echo implode(" ",array_splice($words,0,$limit)).$dots;
}
?>
