<?php
/*
 * Template Name: Portfolio Item
 * Template Post Type: portfolio_item
 */

 get_header();  ?>

<div class="wrap" style="width: 80%; margin: 0px auto;">

	<h2 style="margin-bottom: 3%;"> <?php echo get_the_title(); ?></h2>
	<div class="bp_singlepage_portfolio_item_huge_image" style="background-position: center;">
		<img src="<?php echo get_post_meta( get_the_ID(), 'Brothman_Portfolio_image1', true );?>" style="margin: 0px auto;" />
	</div>
	
				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/post/content', get_post_format() );

					?>
					<div style="overflow: hidden; margin-bottom: 5%;">
						<?php echo get_the_content(); ?>
					</div>
					<?php

					// If comments are open or we have at least one comment, load up the comment template.
					//if ( comments_open() ) {



				endwhile; // End of the loop.
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

<?php if ( $images[0] != NULL && count( array_filter($images ) ) > 1 ) { ?>
	<div id="bp_thumbnail_selector_row">

		<?php if ( $images[0] != NULL && count( array_filter($images ) ) > 1 ) { ?>
		<div class="bp_singlepage_thumbnail_div">
				<div class="bp_trim_thumbnail">
					<img class="bp_portfolio_item_selector_image bp_portfolio_item_selected_image" src="<?php echo $images[0]; ?> " />
				</div>
		</div>
		<?php } ?>
		
		<?php if ( $images[1] != NULL ) { ?>
			<div class="bp_singlepage_thumbnail_div">
				<div class="bp_trim_thumbnail">
					<img class="bp_portfolio_item_selector_image" src="<?php echo $images[1];?> " />
				</div>
		</div>
		<?php } ?>

		<?php if ( $images[2] != NULL ) { ?>
			<div class="bp_singlepage_thumbnail_div">
				<div class="bp_trim_thumbnail">
					<img class="bp_portfolio_item_selector_image" src="<?php echo $images[2]; ?> " />
				</div>
			</div>
		<?php } ?>

		<?php if ( $images[3] != NULL ) { ?>
			<div class="bp_singlepage_thumbnail_div">
				<div class="bp_trim_thumbnail">
					<img class="bp_portfolio_item_selector_image" src="<?php echo $images[3]; ?> " />
		</div>
			</div>
		<?php } ?>

		<?php if ( $images[4] != NULL ) { ?>
		<div class="bp_singlepage_thumbnail_div">
			<div class="bp_trim_thumbnail">
				<img class="bp_portfolio_item_selector_image" src="<?php echo $images[4]; ?> " />
			</div>
		</div>
		<?php } ?>

	</div></div>
	<?php } ?>





</div><!-- .wrap -->

<?php get_footer();
