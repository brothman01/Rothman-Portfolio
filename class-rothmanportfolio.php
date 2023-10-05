<?php
/**
 * Rothman Portfolio
 *
 * @category  WordPressPlugin
 * @package   Brothman-portfolio
 * @author    Ben Rothman <Ben@BenRothman.org>
 * @copyright 2023 Ben Rothman
 * @license   GPL-2.0+ https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 *
 * @wordpress-plugin
 * Plugin Name: Rothman Portfolio
 * Plugin URI:  https://www.benrothman.org
 * Description: Just a simple WordPress plugin to display a full portfolio grid on a page where each item can be clicked into and examined.
 * Version:     1.3.0
 * Author:      Ben Rothman
 * Author URI:  https://www.BenRothman.org
 * Text Domain: Rothman-Portfolio
 * License:     GPL-2.0+
 **/

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

/* Require Composer autoloader */
require_once dirname( __FILE__ ) . '/vendor/autoload.php';

/**
 * Rothmanportfolio class
 *
 * @since 0.1
 */
class Rothmanportfolio {

	/**
	 * Rothmanportfolio class constructor
	 *
	 * @since 0.1
	 */
	public function __construct() {

		// register post type.
		add_action( 'init', array( $this, 'bp_register_portfolio_item_cpt' ), 0 );

		// load and start CMB2.
		if ( file_exists( dirname( __FILE__ ) . '/vendor/cmb2/init.php' ) ) {
			require_once dirname( __FILE__ ) . '/vendor/cmb2/init.php';
		} elseif ( file_exists( dirname( __FILE__ ) . '/vendor/CMB2/init.php' ) ) {
			require_once dirname( __FILE__ ) . '/vendor/CMB2/init.php';
		}

		// // register and add the metaboxes to the portfolio item CPT.
		add_action( 'cmb2_init', array( $this, 'bp_register_metaboxes' ) );

		// load styles.
		add_action( 'wp_enqueue_scripts', array( $this, 'rp_enqueue_styles' ) );

		// register full portfolio  page shortcode.
		add_shortcode( 'portfolio_page', array( $this, 'bp_portfolio_page_shortcode' ) );

		// use my single template for single portfolio-item.
		add_filter( 'template_include', array( $this, 'bp_include_template' ), 1 );

		// add support for home portfolio carousesl image size.
		add_action( 'init', array( $this, 'odevice_image_sizes' ) );

		// WordPress block actions.
		add_action( 'init', array( $this, 'bp_create_block' ) );
		add_filter( 'register_post_type_args', array( $this, 'brs_add_cpts_to_api' ), 10, 2 );

	}

	/**
	 * Register the Portfolio item CPT
	 *
	 * @since 0.1
	 */
	public function bp_register_portfolio_item_cpt() {

		$labels = array(
			'name'                  => _x( 'Portfolio Items', 'Post Type General Name', 'brothman_portfolio' ),
			'singular_name'         => _x( 'Portfolio Item', 'Post Type Singular Name', 'brothman_portfolio' ),
			'menu_name'             => __( 'Portfolio Item', 'brothman_portfolio' ),
			'name_admin_bar'        => __( 'Portfolio Item', 'brothman_portfolio' ),
			'archives'              => __( 'Portfolio Item Archives', 'brothman_portfolio' ),
			'attributes'            => __( 'Portfolio Item Attributes', 'brothman_portfolio' ),
			'parent_item_colon'     => __( 'Parent Item:', 'brothman_portfolio' ),
			'all_items'             => __( 'Portfolio Items', 'brothman_portfolio' ),
			'add_new_item'          => __( 'Add New Portfolio Item', 'brothman_portfolio' ),
			'add_new'               => __( 'Add New', 'brothman_portfolio' ),
			'new_item'              => __( 'New Item', 'brothman_portfolio' ),
			'edit_item'             => __( 'Edit Item', 'brothman_portfolio' ),
			'update_item'           => __( 'Update Item', 'brothman_portfolio' ),
			'view_item'             => __( 'View Item', 'brothman_portfolio' ),
			'view_items'            => __( 'View Items', 'brothman_portfolio' ),
			'search_items'          => __( 'Search Item', 'brothman_portfolio' ),
			'not_found'             => __( 'Not found', 'brothman_portfolio' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'brothman_portfolio' ),
			'featured_image'        => __( 'Featured Image', 'brothman_portfolio' ),
			'set_featured_image'    => __( 'Set featured image', 'brothman_portfolio' ),
			'remove_featured_image' => __( 'Remove featured image', 'brothman_portfolio' ),
			'use_featured_image'    => __( 'Use as featured image', 'brothman_portfolio' ),
			'insert_into_item'      => __( 'Insert into item', 'brothman_portfolio' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'brothman_portfolio' ),
			'items_list'            => __( 'Items list', 'brothman_portfolio' ),
			'items_list_navigation' => __( 'Items list navigation', 'brothman_portfolio' ),
			'filter_items_list'     => __( 'Filter items list', 'brothman_portfolio' ),
		);
		$args   = array(
			'label'               => __( 'Portfolio Item', 'brothman_portfolio' ),
			'description'         => __( 'Post Type Description', 'brothman_portfolio' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'comments', 'thumbnail' ),
			'taxonomies'          => array( 'category', 'post_tag' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'show_in_rest'        => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'show_in_rest'        => true,
		);
		register_post_type( 'portfolio_item', $args );

	}


	/**
	 * Add the metaboxes to the portfolio_item CPT
	 *
	 * @since 0.1
	 */
	public function bp_register_metaboxes() {

		$prefix = 'Brothman_Portfolio_';

		$bp_metabox = new_cmb2_box(
			array(
				'id'           => $prefix . 'metabox',
				'title'        => esc_html__( 'Data', 'cmb2' ),
				'object_types' => 'portfolio_item',
				'show_in_rest' => WP_REST_Server::READABLE,
			)
		);

		$bp_metabox->add_field(
			array(
				'name' => esc_html__( 'Image 1', 'cmb2' ),
				'desc' => esc_html__( 'Upload an image or enter a URL.', 'cmb2' ),
				'id'   => $prefix . 'image1',
				'type' => 'file',
			)
		);

		$bp_metabox->add_field(
			array(
				'name' => esc_html__( 'Image 1', 'cmb2' ),
				'desc' => esc_html__( 'Upload an image or enter a URL.', 'cmb2' ),
				'id'   => $prefix . 'image2',
				'type' => 'file',
			)
		);

		$bp_metabox->add_field(
			array(
				'name' => esc_html__( 'Image 2', 'cmb2' ),
				'desc' => esc_html__( 'Upload an image or enter a URL.', 'cmb2' ),
				'id'   => $prefix . 'image3',
				'type' => 'file',
			)
		);

		$bp_metabox->add_field(
			array(
				'name' => esc_html__( 'Image 3', 'cmb2' ),
				'desc' => esc_html__( 'Upload an image or enter a URL.', 'cmb2' ),
				'id'   => $prefix . 'image4',
				'type' => 'file',
			)
		);

		$bp_metabox->add_field(
			array(
				'name' => esc_html__( 'Image 4', 'cmb2' ),
				'desc' => esc_html__( 'Upload an image or enter a URL.', 'cmb2' ),
				'id'   => $prefix . 'image5',
				'type' => 'file',
			)
		);

	}

	/**
	 * Callback function to be executed when the portfolio page shortcode is used.
	 *
	 * @param (array) $atts : of all of the shortcode attributes to be used with the current shortcode.
	 *
	 * @since 0.1
	 */
	public function bp_portfolio_page_shortcode( $atts ) {

		$atts = shortcode_atts(
			array(
				'category' => 'Website',
			),
			$atts,
			'$atts'
		);

		$the_category = $atts['category'];

		$content = '<div class="portfolio-container" style="width: 80%!important; margin: 0px auto;">';

		$args = array(
			'post_type'      => 'portfolio_item',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => -1,
			'category_name'  => 'Website',
			'post_status'    => 'publish',
		);

		$posts = get_posts( $args );

		$rows = array_chunk( $posts, 3 );

		foreach ( $rows as $row ) {
			$content .= '<div class="bp-portfolio-row prevent-select col-md-12">';
			$content .= '<a href="' . get_permalink( $row[0]->ID ) . '">';
			$content .= '<div class="col-lg-3 col-md-2 col-sm-12 bp-portfolio-item-cell" style="float: left; overflow-y: hidden; margin-bottom: 20px;">';
			$content .= '<div id="portfolio-image-div">';
			$content .= get_the_post_thumbnail( $row[0]->ID, 'large' );
			$content .= '</div>';
			$content .= '<p style="text-align: center ">' . get_the_title( $row[0]->ID ) . '</p>';
			$content .= '</div></a>';

			if ( count( $row ) > 1 ) {
				$content .= '<a href="' . get_permalink( $row[1]->ID ) . '">';
				$content .= '<div class="col-lg-3 col-md-3 col-sm-12 bp-portfolio-item-cell" style="float: left; overflow-y: hidden; margin-bottom: 20px;">';
				$content .= '<div id="portfolio-image-div">';
				$content .= get_the_post_thumbnail( $row[1]->ID, 'large' );
				$content .= '</div>';
				$content .= '<p style="text-align: center;">' . get_the_title( $row[1]->ID ) . '</p>';
				$content .= '</div></a>';
			}

			if ( count( $row ) > 2 ) {
				$content .= '<a href="' . get_permalink( $row[2]->ID ) . '">';
				$content .= '<div class="col-lg-3 col-md-3 col-sm-12 bp-portfolio-item-cell" style="float: left; overflow-y: hidden; margin-bottom: 20px;">';
				$content .= '<div id="portfolio-image-div">';
				$content .= get_the_post_thumbnail( $row[2]->ID, 'large' );
				$content .= '</div>';
				$content .= '<p style="text-align: center;">' . get_the_title( $row[2]->ID ) . '</p>';
				$content .= '</div></a>';
			}

			$content .= '</div>';
		}

			$content .= '</div>';

		return $content;

	}

	/**
	 * Function to create theme support to serve smaller images for portfolio
	 *
	 * @since 1.0
	 */
	public function odevice_image_sizes() {

		add_image_size( 'home-size', 300, 100, true );

	}

	/**
	 * Callback function to be executed when the portfolio carousel shortcode is used
	 *
	 * @since 0.1
	 */
	public function rp_portfolio_carousel_shortcode() {

		$content      = '<div id="wrapper">';
			$content .= '<div id="carousel">';

						$items = new WP_Query(
							array(
								'post_type'      => 'portfolio_item',
								'orderby'        => 'date',
								'posts_per_page' => -1,
								'order'          => 'DESC',
								'category_name'  => 'Website',
								'post_status'    => 'publish',
							)
						);

		if ( $items->have_posts() ) {
			while ( $items->have_posts() ) {
				$items->the_post();

				$content .= '<div>';
				$content .= '<a href="' . get_permalink() . '">';
				$content .= get_the_post_thumbnail( get_the_ID(), 'home-size' );
				$content .= '</a>';
				$content .= '</div>';

			}
				wp_reset_postdata();
		}

			$content .= '</div>';

			$content .= '<div id="nav">';
			$content .= '<a id="prev" href="#">&laquo; Prev</a>';
			$content .= '<a id="next" href="#">Next &raquo;</a>';
			$content .= '</div>';

		$content .= '</div>';

		return $content;

	}

	/**
	 * Callback function to enqueue stylesheets and scripts for this plugin
	 *
	 * @since 0.1
	 */
	public function rp_enqueue_styles() {

		// my custom styles.
		wp_enqueue_style( 'my-styles', plugins_url( 'library/css/portfolio.css', __FILE__ ), array(), '1.0.0' );

		// brothman_portfolio script.
		wp_register_script( 'portfolio-script', plugins_url( 'library/js/brothman_portfolio.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'portfolio-script' );

		// enqueue the react to be used on the front end.

		wp_register_script( 'index', plugin_dir_url( __FILE__ ) . 'wordpress-block/build/index.js', array( 'wp-element' ), '1.0.0', true );
		wp_localize_script(
			'index',
			'vars',
			array(
				'rest_url' => get_rest_url( null, '/wp/v2/portfolio_item?filter[orderby]=date&order=desc&per_page=50&post_status=published&_embed' ),
			)
		);
		wp_enqueue_script( 'index' );

		// enqueue bootstrap.
		wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css', array(), '1.0.0' );

	}

	/**
	 * Function used to force the site to use my custom templpate for the single 'portfolio_item' page.
	 *
	 * @param obj $template_path : The object passed in by WordPress representing the template path.
	 *
	 * @since 0.1
	 */
	public function bp_include_template( $template_path ) {

		if ( get_post_type() === 'portfolio_item' ) {
				$theme_file    = plugin_dir_path( __FILE__ ) . 'single-portfolio-item.php';
				$template_path = $theme_file;
		}

		return $template_path;

	}

	/** Overides the declarations of every CPT to make sure they are all have endpoints in the REST API.
	 *
	 * @param array  $args : array of all args for the current CPT.
	 *
	 * @param string $post_type : the name of the CPT.
	 *
	 * @since 0.1
	 */
	public function brs_add_cpts_to_api( $args, $post_type ) {

		if ( 'result' === $post_type ) {
			$args['show_in_rest'] = true;
		}

		return $args;

	}

	/**
	 * Add the block to the WordPress block editor
	 */
	public function bp_create_block() {

		register_block_type( __DIR__ . '/wordpress-block/build' );

	}

}

new Rothmanportfolio();
