<?php

function fafs_menu(){
    register_nav_menu('Navigation', __('Navigation'));
    register_nav_menu('Campeonatos-M', __('Campeonatos-M'));
    register_nav_menu('Campeonatos-F', __('Campeonatos-F'));
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
add_theme_support( 'automatic-feed-links' );

function fafs_setup() {
	update_option('thumbnail_size_w', 290);
    update_option('thumbnail_size_h', 290);
    add_image_size( 'mini-thumbnail', 50, 50, true );
    add_image_size( 'slide', 550, 300, true );
	
}
add_action( 'init', 'fafs_setup' );

if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
    update_option( 'posts_per_page', 12 );
    update_option( 'paging_mode', 'default' );
}

/*** Navigation ***/

if ( !is_nav_menu('Navigation') || !is_nav_menu('Campeonatos-M') || !is_nav_menu('Campeonatos-F')) {
    $menu_id1 = wp_create_nav_menu('Navigation');
    $menu_id2 = wp_create_nav_menu('Campeonatos-M');
    $menu_id3 = wp_create_nav_menu('Campeonatos-F');
    wp_update_nav_menu_item($menu_id1, 1);
    wp_update_nav_menu_item($menu_id2, 2);
    wp_update_nav_menu_item($menu_id3, 3);
}

class extended_walker extends Walker_Nav_Menu{
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );

		//Adds the 'parent' class to the current item if it has children
		if( ! empty( $children_elements[$element->$id_field] ) )
			array_push($element->classes,'parent');

		$cb_args = array_merge( array(&$output, $element, $depth), $args);

		call_user_func_array(array(&$this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
}







/*** Scripts Fafs ***/
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

function comicpress_copyright() {
global $wpdb;
$copyright_dates = $wpdb->get_results("
SELECT
YEAR(min(post_date_gmt)) AS firstdate,
YEAR(max(post_date_gmt)) AS lastdate
FROM
$wpdb->posts
WHERE
post_status = 'publish'
");
$output = '';
if($copyright_dates) {
$copyright = "&copy; " . $copyright_dates[0]->firstdate;
if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
$copyright .= '-' . $copyright_dates[0]->lastdate;
}
$output = $copyright;
}
return $output;
}

/*** Options novoooooo ***/

function options_admin_menu() {
	// here's where we add our theme options page link to the dashboard sidebar
	add_theme_page("Sight Theme Options", "Theme Options", 'edit_themes', basename(__FILE__), 'options_page');
}
add_action('admin_menu', 'options_admin_menu');

function options_page() {
    if ( $_POST['update_options'] == 'true' ) { options_update(); }  //check options update
	?>
    <div class="wrap">
        <div id="icon-options-general" class="icon32"><br /></div>
		<h2>FAFS Theme Options</h2>

        <form method="post" action="">
			<input type="hidden" name="update_options" value="true" />

            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="logo_url"><?php _e('Custom logo URL:'); ?></label></th>
                    <td><input type="text" name="logo_url" id="logo_url" size="50" value="<?php echo get_option('logo_url'); ?>"/><br/><span
                            class="description"> <a href="<?php bloginfo("url"); ?>/wp-admin/media-new.php" target="_blank">Upload your logo</a> (max 290px x 128px) using WordPress Media Library and insert its URL here </span><br/><br/><img src="<?php echo (get_option('logo_url')) ? get_option('logo_url') : get_bloginfo('template_url') . '/img/logo.png' ?>"
                     alt=""/></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="bg_color"><?php _e('Custom background color:'); ?></label></th>
                    <td><input type="text" name="bg_color" id="bg_color" size="20" value="<?php echo get_option('bg_color'); ?>"/><span
                            class="description"> e.g., <strong>#27292a</strong> or <strong>black</strong></span></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="ss_disable"><?php _e('Disable slideshow:'); ?></label></th>
                    <td><input type="checkbox" name="ss_disable" id="ss_disable" <?php echo (get_option('ss_disable'))? 'checked="checked"' : ''; ?>/></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="ss_timeout"><?php _e('Timeout for slideshow (ms):'); ?></label></th>
                    <td><input type="text" name="ss_timeout" id="ss_timeout" size="20" value="<?php echo get_option('ss_timeout'); ?>"/><span
                            class="description"> e.g., <strong>7000</strong></span></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Pagination:'); ?></label></th>
                    <td>
                        <input type="radio" name="paging_mode" value="default" <?php echo (get_option('paging_mode') == 'default')? 'checked="checked"' : ''; ?>/><span class="description">Default + WP Page-Navi support</span><br/>
                        <input type="radio" name="paging_mode" value="ajax" <?php echo (get_option('paging_mode') == 'ajax')? 'checked="checked"' : ''; ?>/><span class="description">AJAX-fetching posts</span><br/>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="ga"><?php _e('Google Analytics code:'); ?></label></th>
                    <td><textarea name="ga" id="ga" cols="48" rows="18"><?php echo get_option('ga'); ?></textarea></td>
                </tr>
            </table>

            <p><input type="submit" value="Save Changes" class="button button-primary" /></p>
        </form>
    </div>
<?php
}

// Update options

function options_update() {
	update_option('logo_url', $_POST['logo_url']);
	update_option('bg_color', $_POST['bg_color']);
	update_option('ss_disable', $_POST['ss_disable']);
	update_option('ss_timeout', $_POST['ss_timeout']);
	update_option('paging_mode', $_POST['paging_mode']);
	update_option('ga', stripslashes_deep($_POST['ga']));
}

//Allow svg files

function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

/*** Widgets ***/

if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name'=>'Site description',
        'before_widget' => '<div class="site-description">',
        'after_widget' => '</div>'
    ));
    register_sidebar(array(
        'name'=>'Sidebar',
        'before_widget' => '<div id="%1$s" class="%2$s widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'

    ));

    register_sidebar(array(
        'name'=>'Homepage Sidebar',
        'id' => 'homepage-sidebar',
        'before_widget' => '<div id="%1$s" class="%2$s home-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'

    ));

}

/*** Comments ***/

function commentslist($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li>
        <div id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
            <table>
                <tr>
                    <td>
                        <?php echo get_avatar($comment, 70, get_bloginfo('template_url').'/images/no-avatar.png'); ?>
                    </td>
                    <td>
                        <div class="comment-meta">
                            <?php printf(__('<p class="comment-author"><span>%s</span> says:</p>'), get_comment_author_link()) ?>
                            <?php printf(__('<p class="comment-date">%s</p>'), get_comment_date('M j, Y')) ?>
                            <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                        </div>
                    </td>
                    <td>
                        <div class="comment-text">
                            <?php if ($comment->comment_approved == '0') : ?>
                                <p><?php _e('Your comment is awaiting moderation.') ?></p>
                                <br/>
                            <?php endif; ?>
                            <?php comment_text() ?>
                        </div>
                    </td>
                </tr>
            </table>
         </div>
<?php
}


add_filter('wp_title', 'seo_title');

function comments_link_attributes(){
    return 'class="comments_popup_link"';
}
add_filter('comments_popup_link_attributes', 'comments_link_attributes');

function next_posts_attributes(){
    return 'class="nextpostslink"';
}
add_filter('next_posts_link_attributes', 'next_posts_attributes');



/** pagina de login  ***/
function custom_login_css ( )  {
 
echo  '<link rel="stylesheet" type="text/css" href = "' . get_stylesheet_directory_uri ( ) . '/ login / login-styles.css "/>' ;
 
 }
 
add_action ( 'login_head' , 'custom_login_css' ) ;

function custom_fonts() {
 
echo '<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css">';
 
} ?>
 
<?php add_action('login_head', 'custom_fonts');

add_action( 'login_head', 'untame_fadein',30);
 
function untame_fadein() {
 
echo '<script type="text/javascript">// <![CDATA[
 
jQuery(document).ready(function() { jQuery("#loginform,#nav,#backtoblog").css("display", "none");          jQuery("#loginform,#nav,#backtoblog").fadeIn(3500);
 
});
 
// ]]></script>';
 
}
?>
<?php
add_filter( 'login_headerurl', 'custom_login_header_url' );
 
function custom_login_header_url($url) {
 
return 'http://futsalamazonas.com.br/'; 
 
}?><span style="font-family: Georgia, 'Times New Roman', 'Bitstream Charter', Times, serif;font-size: 13px;line-height: 19px"> </span>


