<?php

function brew_dependencies() {

		$brew_dependancies = [              
		  'inc/custom-header.php',	// Implement the Custom Header feature.
		  'inc/template-tags.php',	// Custom template tags for this theme.
		  'inc/extras.php', 		// Custom functions that act independently of the theme templates.
		  'inc/customizer.php',  	// Customizer additions.
		  'inc/jetpack.php'			// Load Jetpack compatibility file.              // Initial theme setup and constants
		];

		foreach ( $brew_dependancies as $file ) {
		  if ( !file_exists( BREW_DIR . $file ) ) {
		    trigger_error(sprintf(__('Error locating %s for inclusion', 'brew'), $file), E_USER_ERROR);
		  }
		  $filepath = BREW_DIR . $file;
		  require_once $filepath;
		}

		unset($file, $filepath);

	}
brew_dependencies();


add_action('wp_head','nmpza_ajaxurl');

function nmpza_ajaxurl() {
    ?>
    <script type="text/javascript">
        var ajaxurl 	= '<?php echo admin_url("admin-ajax.php"); ?>';
        var nmpza_root 	= '<?php echo get_stylesheet_directory_uri(); ?>';
    </script>
    <?php
    echo BREW_URL . ' ' . BREW_DIR;
}


if ( ! function_exists( 'brew_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function brew_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on BrewBase, use a find and replace
	 * to change 'brew' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'brew', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'brew' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'brew_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // brew_setup


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function brew_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'brew_content_width', 640 );
}
add_action( 'after_setup_theme', 'brew_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function brew_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'brew' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'brew_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function brew_scripts() {
	wp_enqueue_style( 'brew-style', get_stylesheet_uri() );

	wp_enqueue_script( 'brew-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'brew-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'brew_scripts' );


