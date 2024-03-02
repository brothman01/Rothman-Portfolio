<?php
/**
 * Rothman Portfolio Settings
 *
 * @category  WordPress_Plugin
 * @package   Brothman-portfolio
 * @author    Ben Rothman <Ben@BenRothman.org>
 * @copyright 2023 Ben Rothman
 * @license   GPL-2.0+ https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 */

/**
 * Function to create the Rothman Portfolio Settings options page
 *
 * @since 1.0.2
 */
function rp_options_page() {
	add_menu_page(
		'Rothman Portfolio Settings',
		'Rothman Portfolio Settings',
		'manage_options',
		'rp',
		'rp_options_page_html',
		'dashicons-bell'
	);
}

add_action( 'admin_menu', 'rp_options_page' );


/**
 * Helper function to get Rothman Portfolio Settings options or return empty strings if there are no values.
 *
 * @since 1.0.2
 */
function bh_get_options() {

	$defaults = array(
		'blocktheme' => '',
	);

	return get_option( 'bh_options', $defaults );

}

/**
 * Register the setting, initialize and add the section + fields to the section
 */
function rp_settings_init() {

	// Register a new setting for "bh" page.
	register_setting( 'bh', 'bh_options' );

	// Register a new section in the "bh" page.
	add_settings_section(
		'rp_settings_section',
		__( 'General', 'bh' ),
		null,
		'bh'
	);

	// Register a new field in the "rp_settings_section" section, on the "rp" page.
	add_settings_field(
		'blocktheme', // As of WP 4.6 this value is used only internally.
		__( 'Add blocktheme code?', 'bh' ),
		'bh_phone_cb',
		'bh',
		'rp_settings_section',
		array(
			'label_for' => 'blocktheme',
			'class'     => 'rp_row',
		)
	);

}

add_action( 'admin_init', 'rp_settings_init' );

/**
 * Phone field callback function.
 *
 * @param Array $args : An array of the parameters to be used in the callback function to build the shortcode.
 */
function bh_phone_cb( $args ) {

	// Get the value of the setting we've registered with register_setting().
	$value = get_option( 'bh_options', 'false' ) !== 'false' ? get_option( 'bh_options' )['blocktheme'] : '';
	?>
	<!-- output the html for the field being added -->
	<input
			id="blocktheme"
			type="text"
			name="bh_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			value="<?php echo esc_html( $value ); ?>">
</input><br />
	<?php

}


/**
 * Menu Page callback function
 */
function rp_options_page_html() {

	// check user capabilities.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "bh".
			settings_fields( 'bh' );

			// output setting sections and their fields.  sections are registered for "bh", each field is registered to a section.
			do_settings_sections( 'bh' );

			// output save settings button.
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php

}