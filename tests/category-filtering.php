<?php
/** Integration tests. Run with wp eval-file on a disposable WordPress site. */
if ( ! defined( 'ABSPATH' ) ) {
	exit( "Run this test inside WordPress.\n" );
}

$plugin = new Rothmanportfolio();
$plugin->bp_register_portfolio_item_cpt();
$prefix = 'rp-filter-' . wp_generate_password( 8, false, false );
$terms = array();
$posts = array();
$saved_get = $_GET;
$saved_front = array( get_option( 'show_on_front' ), get_option( 'page_on_front' ) );
$checks = 0;
$check = function ( $condition, $message ) use ( &$checks ) {
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
	++$checks;
};

try {
	foreach ( array( 'alpha', 'beta', '123456789' ) as $slug ) {
		$slug = '123456789' === $slug ? $slug : strtolower( $prefix . '-' . $slug );
		$result = wp_insert_term( $slug, 'category', array( 'slug' => $slug ) );
		if ( is_wp_error( $result ) ) {
			throw new RuntimeException( $result->get_error_message() );
		}
		$terms[] = $result['term_id'];
	}
	$alpha = get_term( $terms[0] )->slug;
	$beta = get_term( $terms[1] )->slug;
	$child = wp_insert_term( $prefix . '-child', 'category', array( 'parent' => $terms[0] ) );
	$terms[] = $child['term_id'];
	$website = get_term_by( 'slug', 'website', 'category' );
	if ( ! $website ) {
		$result = wp_insert_term( 'Website', 'category', array( 'slug' => 'website' ) );
		$terms[] = $result['term_id'];
		$website = get_term( $result['term_id'] );
	}
	$fixtures = array(
		'Alpha' => array( $terms[0] ),
		'Beta' => array( $terms[1] ),
		'Both' => array( $terms[0], $terms[1] ),
		'Child' => array( $child['term_id'] ),
		'Numeric' => array( $terms[2] ),
		'Default' => array( $website->term_id ),
		'Draft' => array( $terms[0] ),
	);
	foreach ( $fixtures as $label => $categories ) {
		$posts[] = wp_insert_post( array(
			'post_type' => 'portfolio_item',
			'post_title' => $prefix . $label,
			'post_status' => 'Draft' === $label ? 'draft' : 'publish',
			'post_category' => $categories,
		) );
	}
	$cases = array(
		array( array(), array( 'Default' ) ),
		array( array( 'cat' => '' ), array( 'Default' ) ),
		array( array( 'cat' => '   ' ), array( 'Default' ) ),
		array( array( 'cat' => array( $alpha ) ), array( 'Default' ) ),
		array( array( 'cat' => $alpha ), array( 'Alpha', 'Both' ) ),
		array( array( 'cat' => $beta, 'utm_source' => 'resume' ), array( 'Beta', 'Both' ) ),
		array( array( 'cat' => '123456789' ), array( 'Numeric' ) ),
		array( array( 'cat' => $prefix . '-missing' ), array() ),
		array( array( 'cat' => '!!!' ), array() ),
		array( array( 'cat' => $alpha . ',' . $beta ), array() ),
	);
	foreach ( $cases as $case ) {
		$_GET = $case[0];
		$output = $plugin->bp_portfolio_page_shortcode( array() );
		foreach ( $fixtures as $label => $unused ) {
			$check( ( false !== strpos( $output, $prefix . $label ) ) === in_array( $label, $case[1], true ), 'Incorrect result for ' . $label . ': ' . json_encode( $_GET ) );
		}
		// Exercise the actual dynamic block template, not a duplicate renderer.
		$attributes = array( 'yourId' => 'filter-test' );
		$GLOBALS['counter'] = 0;
		ob_start();
		include dirname( __DIR__ ) . '/wordpress-block/src/render.php';
		$block_output = ob_get_clean();
		$check( false !== strpos( $block_output, $output ), 'Block and shortcode differ' );
	}

	foreach ( array( '[portfolio_page]', '<!-- wp:create-block/my-block /-->' ) as $content ) {
		$page_id = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => $prefix, 'post_content' => $content ) );
		$posts[] = $page_id;
		$slug = get_post( $page_id )->post_name;
		foreach ( array( array( 'page_id' => $page_id ), array( 'pagename' => $slug ) ) as $route ) {
			$query_vars = $plugin->bp_portfolio_category_request( $route + array( 'cat' => '123456789' ) );
			$check( ! isset( $query_vars['cat'] ), 'cat hijacked portfolio page route' );
			$query = new WP_Query( $query_vars );
			$check( $query->is_page() && $page_id === $query->get_queried_object_id(), 'Portfolio page failed to resolve' );
		}
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_id );
		$check( array() === $plugin->bp_portfolio_category_request( array( 'cat' => $alpha ) ), 'Front page filter failed' );
	}
	update_option( 'show_on_front', 'posts' );
	$archive = array( 'cat' => $terms[0] );
	$check( $archive === $plugin->bp_portfolio_category_request( $archive ), 'Category archive changed' );
	$plain_id = wp_insert_post( array( 'post_type' => 'page', 'post_title' => $prefix . 'plain', 'post_status' => 'publish' ) );
	$posts[] = $plain_id;
	$plain = array( 'page_id' => $plain_id, 'cat' => $terms[0] );
	$check( $plain === $plugin->bp_portfolio_category_request( $plain ), 'Unrelated page changed' );
	echo "PASS: $checks category filtering assertions\n";
} finally {
	$_GET = $saved_get;
	update_option( 'show_on_front', $saved_front[0] );
	update_option( 'page_on_front', $saved_front[1] );
	foreach ( $posts as $id ) {
		wp_delete_post( $id, true );
	}
	foreach ( array_reverse( $terms ) as $id ) {
		wp_delete_term( $id, 'category' );
	}
}
