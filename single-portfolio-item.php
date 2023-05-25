<?php
/**
 * Rothman Portfolio
 *
 * @category  WordPress_Plugin
 * @package   Brothman-portfolio
 * @author    Ben Rothman <Ben@BenRothman.org>
 * @copyright 2023 Ben Rothman
 * @license   GPL-2.0+ https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 *
 * Template Name: Portfolio Item
 * Template Post Type: portfolio_item
 */

get_header();  ?>

<div class="wrap" style="width: 80%; margin: 0px auto;">

	<h2 style="margin-bottom: 3%;"> <?php echo esc_html( get_the_title() ); ?></h2>
	<div class="bp_singlepage_portfolio_item_huge_image" style="background-position: center;">
		<img src="<?php echo esc_html( get_post_meta( get_the_ID(), 'Brothman_Portfolio_image1', true ) ); ?>" style="margin: 0px auto;" />
	</div>

				<?php
				while ( have_posts() ) {
					the_post();

					get_template_part( 'template-parts/post/content', get_post_format() );

					?>
					<div style="overflow: hidden; margin-bottom: 5%;">
						<?php echo wp_kses_post( get_the_content() ); ?>
					</div>
					<?php

				}
				?>

	<?php
	$images = array();
	array_push( $images, get_post_meta( get_the_ID(), 'Brothman_Portfolio_image1', true ) );
	array_push( $images, get_post_meta( get_the_ID(), 'Brothman_Portfolio_image2', true ) );
	array_push( $images, get_post_meta( get_the_ID(), 'Brothman_Portfolio_image3', true ) );
	array_push( $images, get_post_meta( get_the_ID(), 'Brothman_Portfolio_image4', true ) );
	array_push( $images, get_post_meta( get_the_ID(), 'Brothman_Portfolio_image5', true ) );
	array_push( $images, );
	?>

<?php if ( null !== $images[0] && count( array_filter( $images ) ) > 1 ) { ?>
	<div id="bp-thumbnail-selector-row">

		<?php if ( null !== $images[0] && count( array_filter( $images ) ) > 1 ) { ?>
		<div class="bp-singlepage-thumbnail-div">
				<div class="bp-trim-thumbnail">
					<img class="bp-portfolio-item-selector-image bp_portfolio_item_selected_image" src="<?php echo esc_html( $images[0] ); ?> " />
				</div>
		</div>
		<?php } ?>

		<?php if ( null !== $images[1] ) { ?>
			<div class="bp-singlepage-thumbnail-div">
				<div class="bp-trim-thumbnail">
					<img class="bp-portfolio-item-selector-image" src="<?php echo esc_html( $images[1] ); ?> " />
				</div>
		</div>
		<?php } ?>

		<?php if ( null !== $images[2] ) { ?>
			<div class="bp-singlepage-thumbnail-div">
				<div class="bp-trim-thumbnail">
					<img class="bp-portfolio-item-selector-image" src="<?php echo esc_html( $images[2] ); ?> " />
				</div>
			</div>
		<?php } ?>

		<?php if ( null !== $images[3] ) { ?>
			<div class="bp-singlepage-thumbnail-div">
				<div class="bp-trim-thumbnail">
					<img class="bp-portfolio-item-selector-image" src="<?php echo esc_html( $images[3] ); ?> " />
		</div>
			</div>
		<?php } ?>

		<?php if ( null !== $images[4] ) { ?>
		<div class="bp-singlepage-thumbnail-div">
			<div class="bp-trim-thumbnail">
				<img class="bp-portfolio-item-selector-image" src="<?php echo esc_html( $images[4] ); ?> " />
			</div>
		</div>
			<?php
		}
		?>

	</div></div>
	<?php
}
?>

</div><!-- .wrap -->

<?php
get_footer();
