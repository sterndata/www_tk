<?php
/**
 * _sds functions and definitions
 *
 * @package _sds
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 750; /* pixels */

if ( ! function_exists( '_sds_setup' ) ) :
/**
 * Set up theme defaults and register support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function _sds_setup() {
	global $cap, $content_width;

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	if ( function_exists( 'add_theme_support' ) ) {

		/**
		 * Add default posts and comments RSS feed links to head
		*/
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails on posts and pages
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		*/
		add_theme_support( 'post-thumbnails' );

		/**
		 * Enable support for Post Formats
		*/
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

		/**
		 * Setup the WordPress core custom background feature.
		*/
		add_theme_support( 'custom-background', apply_filters( '_sds_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

	}

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on _sds, use a find and replace
	 * to change '_sds' to the name of your theme in all the template files
	*/
	load_theme_textdomain( '_sds', get_template_directory() . '/languages' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	*/
	register_nav_menus( array(
		'primary'  => __( 'Header bottom menu', '_sds' ),
	) );

}
endif; // _sds_setup
add_action( 'after_setup_theme', '_sds_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function _sds_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', '_sds' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
         register_sidebar( array(
                'name'          => __( 'Header', '_sds' ),
                'id'            => 'header',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
        ) );

         register_sidebar( array(
                'name'          => __( 'Footer', '_sds' ),
                'id'            => 'footer',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
        ) );
}
add_action( 'widgets_init', '_sds_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function _sds_scripts() {

	// load bootstrap css
	wp_enqueue_style( '_sds-bootstrap', get_template_directory_uri() . '/includes/resources/bootstrap/css/bootstrap.css' );

	// load _sds styles
	wp_enqueue_style( '_sds-style', get_stylesheet_uri() );

	// load bootstrap js
	wp_enqueue_script('_sds-bootstrapjs', get_template_directory_uri().'/includes/resources/bootstrap/js/bootstrap.js', array('jquery') );

	// load bootstrap wp js
	wp_enqueue_script( '_sds-bootstrapwp', get_template_directory_uri() . '/includes/js/bootstrap-wp.js', array('jquery') );

	wp_enqueue_script( '_sds-skip-link-focus-fix', get_template_directory_uri() . '/includes/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( '_sds-keyboard-image-navigation', get_template_directory_uri() . '/includes/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

}
add_action( 'wp_enqueue_scripts', '_sds_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/includes/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/includes/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/includes/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
require get_template_directory() . '/includes/bootstrap-wp-navwalker.php';

function load_fonts() {
  wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Open+Sans');
  wp_enqueue_style( 'googleFonts');
        }
    
// add_action('wp_print_styles', 'load_fonts');

function shortcode_year () {
   return date('Y');
}
add_shortcode('year',shortcode_year);

/*
 * customize the jetpack carousel
 */

function enqueue_carousel_style() {
        wp_enqueue_style( 'my-custom-jetpack-carousel', get_stylesheet_directory_uri() . '/my-jetpack-carousel.css', array( 'jetpack-carousel' ), wp_get_theme()->Version );
}
add_filter( 'post_gallery', 'enqueue_carousel_style', 1001, 2 );

function sds_sitemap_func() {
  $results="<div id=\"sds-sitemap\">\n";
  $results .= "<div id=\"sds-sitemap-pages\">\n";
  $results .= "<h2>Pages</h2>\n";
  $all_pages = get_pages();
  $results .= "<ul>\n";
  foreach ($all_pages as $page) {
     $results .= "<li><a href=\"".get_page_link( $page->ID )."\">".$page->post_title."</a></li>\n";
     }

  $results .= "</ul></div>\n<div id=\"sds-sitemap-posts;\">\n";
  $results .=  "<h2>Posts</h2>\n";
    $cats = get_categories();
     // loop through the categries
     foreach ($cats as $cat) {
        // setup the cateogory ID
        $cat_id= $cat->term_id;
        $first_post=true;
        // create a custom wordpress query
        query_posts( array( 'cat' => $cat_id, 'posts_per_page' => -1) );
        // start the wordpress loop!
        if (have_posts()) {
            if ( $first_post ) {
              $results .= "<h3>".$cat->name."</h3>\n<ul>\n";
              $first_post=false;
              }
            while ( have_posts() ) : the_post();
               $results .= "<li><a href='";
               $resuls .= get_permalink();
               $results .= "'>";
               $results .= get_the_title();
                $results .= "</a></li>\n";
            endwhile;
            $results .= "</ul>\n";
            }
          wp_reset_query();
          }
   $results .= "</div></div>";
   return $results;
}


add_shortcode('sds-sitemap','sds_sitemap_func');


/**
 * pagination
**/

function _sds_numeric_posts_nav() {
        echo "<!-- numeric_posts_nav -->\n";
	if( is_singular() )
		return;

	global $wp_query;

	/** Stop execution if there's only 1 page */
	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

	/**	Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="paging"><ul>' . "\n";

	/**	Previous Post Link */
	if ( get_previous_posts_link() )
		printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

	/**	Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

		if ( ! in_array( 2, $links ) )
			echo '<li>…</li>';
	}

	/**	Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	/**	Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>…</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	/**	Next Post Link */
	if ( get_next_posts_link() )
		printf( '<li>%s</li>' . "\n", get_next_posts_link() );

	echo '</ul></div>' . "\n";

}
