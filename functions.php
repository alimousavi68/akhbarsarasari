<?php
/**
 * Iran News functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Iran_News
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Custom widgets for this theme.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

function iran_news_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Custom image sizes
	add_image_size( 'iran-large', 850, 500, true ); // Hero Main, Post Featured
	add_image_size( 'iran-medium', 400, 250, true ); // Hero Sidebar Overlay
	add_image_size( 'iran-thumbnail', 200, 150, true ); // Hero Small, Archive, Most Visited
	add_image_size( 'iran-square', 150, 150, true ); // Latest News, Related News

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary Menu', 'iran' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-logo',
		array(
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'iran_news_setup' );

/**
 * Trim attribute text safely for HTML attributes.
 *
 * @param string $text Raw text.
 * @param int    $max_length Maximum length.
 * @return string
 */
function iran_news_trim_attribute_text( $text, $max_length ) {
	return wp_html_excerpt( wp_strip_all_tags( (string) $text ), $max_length, '' );
}

/**
 * Build header logo data from WordPress settings.
 *
 * @return array<string, string>
 */
function iran_news_get_header_logo_data() {
	$site_name        = get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description' );
	$logo_alt         = $site_description ? $site_description : $site_name;
	$custom_logo_id   = get_theme_mod( 'custom_logo' );
	$logo_url         = '';

	if ( $custom_logo_id ) {
		$logo_src = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		if ( ! empty( $logo_src[0] ) ) {
			$logo_url = $logo_src[0];
		}
	}

	return array(
		'site_name' => $site_name,
		'title'     => iran_news_trim_attribute_text( $site_name, 70 ),
		'alt'       => iran_news_trim_attribute_text( $logo_alt, 125 ),
		'logo_url'  => $logo_url,
	);
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function iran_news_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'سایدبار اصلی', 'iran' ),
			'id'            => 'main-sidebar',
			'description'   => esc_html__( 'ابزارک‌های خود را اینجا قرار دهید.', 'iran' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s mb-12">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="text-2xl font-medium mb-6 flex items-center gap-3"><span class="w-2 h-8 bg-brand rounded-full"></span><div class="flex items-center gap-1">',
			'after_title'   => '</div></h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'سایدبار نوشته‌ها', 'iran' ),
			'id'            => 'post-sidebar',
			'description'   => esc_html__( 'ابزارک‌های مخصوص صفحات نوشته.', 'iran' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s space-y-6">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="text-2xl font-medium mb-6 flex items-center gap-3"><span class="w-2 h-8 bg-brand rounded-full"></span><div class="flex items-center gap-1">',
			'after_title'   => '</div></h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'فوتر', 'iran' ),
			'id'            => 'footer-sidebar',
			'description'   => esc_html__( 'ابزارک‌های بخش فوتر.', 'iran' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s w-full lg:w-auto">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="text-white text-lg font-medium mb-5 text-center lg:text-right">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'iran_news_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function iran_news_scripts() {
	// Enqueue main stylesheet
	wp_enqueue_style( 'iran-news-style', get_stylesheet_uri(), array(), '1.0.0' );
	wp_enqueue_style( 'iran-news-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0' );

	// Enqueue scripts
	wp_enqueue_script( 'lucide', get_template_directory_uri() . '/assets/js/lucide.min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'iran-news-main', get_template_directory_uri() . '/assets/js/main.js', array('lucide'), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'iran_news_scripts' );

/**
 * Add custom attributes to scripts
 */
function iran_news_script_loader_tag($tag, $handle, $src) {
    if ('iran-news-main' === $handle) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'iran_news_script_loader_tag', 10, 3);

/**
 * Custom Walker for Navigation Menu
 */
class Iran_News_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"submenu\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</div>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        
        $is_active = in_array('current-menu-item', $classes);
        
        if ($depth === 0) {
            $link_class = $is_active ? 'nav-link-active' : 'nav-link';
            if ($has_children) {
                $output .= '<div class="submenu-container group flex items-center">';
                $output .= '<a href="' . esc_url($item->url) . '" class="' . $link_class . ' flex items-center gap-1">' . apply_filters('the_title', $item->title, $item->ID) . ' <i data-lucide="chevron-down" class="w-4 h-4 opacity-50"></i></a>';
            } else {
                $output .= '<a href="' . esc_url($item->url) . '" class="' . $link_class . '">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
            }
        } else {
            $output .= '<a href="' . esc_url($item->url) . '" class="submenu-item">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        if ($depth === 0 && $has_children) {
            $output .= '</div>';
        }
    }
}

/**
 * Custom Walker for Mobile Navigation Menu
 */
class Iran_News_Mobile_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<div class="mobile-submenu hidden flex-col pr-4 bg-gray-50/50 dark:bg-gray-900/50 rounded-lg mt-2 mb-2">';
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</div>';
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        $is_active = in_array('current-menu-item', $classes);

        if ($has_children) {
            $output .= '<div class="mobile-submenu-container flex flex-col py-2">';
            $output .= '<div class="flex items-center justify-between w-full">';
            $output .= '<a href="' . esc_url($item->url) . '" class="mobile-nav-item flex-1 ' . ($is_active ? 'mobile-nav-item-active' : '') . '">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
            $output .= '<button class="p-4 text-gray-400 hover:text-brand transition-all cursor-pointer"><i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-300"></i></button>';
            $output .= '</div>';
        } else {
            $output .= '<a href="' . esc_url($item->url) . '" class="mobile-nav-item py-4 border-b border-gray-50 dark:border-gray-900 last:border-0 ' . ($is_active ? 'mobile-nav-item-active' : '') . '">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children) {
            $output .= '</div>';
        }
    }
}

/**
 * Custom Comment Callback
 */
function iran_news_comment_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class('py-6'); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>" class="flex gap-4">
            <div class="shrink-0">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-full overflow-hidden border-2 border-white dark:border-gray-800 shadow-sm">
                    <?php echo get_avatar($comment, $args['avatar_size']); ?>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between mb-1">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate">
                        <?php echo get_comment_author_link(); ?>
                    </h4>
                    <span class="text-[10px] text-gray-400">
                        <?php printf(__('%s پیش', 'iran'), human_time_diff(get_comment_time('U'), current_time('timestamp'))); ?>
                    </span>
                </div>
                
                <?php if ($comment->comment_approved == '0') : ?>
                    <p class="text-[11px] text-brand italic mb-2"><?php _e('دیدگاه شما در انتظار تایید مدیریت است.', 'iran'); ?></p>
                <?php endif; ?>

                <div class="text-[13px] text-gray-600 dark:text-gray-400 leading-relaxed mb-3">
                    <?php comment_text(); ?>
                </div>

                <div class="flex items-center gap-4">
                    <?php
                    comment_reply_link(array_merge($args, array(
                        'reply_text' => '<span class="flex items-center gap-1 text-[11px] font-bold text-brand hover:underline"><i data-lucide="reply" class="w-3 h-3"></i> ' . __('پاسخ', 'iran') . '</span>',
                        'depth'      => $depth,
                        'max_depth'  => $args['max_depth']
                    )));
                    ?>
                    <?php edit_comment_link('<span class="text-[11px] text-gray-400 hover:text-brand">' . __('ویرایش', 'iran') . '</span>', '  ', ''); ?>
                </div>
            </div>
        </div>
    <?php
}
