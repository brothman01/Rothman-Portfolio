<?php include '../class-rothmanportfolio.php'; $instance = new Rothmanportfolio(); ?>

<p <?php echo get_block_wrapper_attributes(); ?>>

<?php
if (null === $GLOBALS['counter']) {
    $GLOBALS['counter'] = 0;
}
?>
<div class="portfolio-block"  data-counter="<?php echo $GLOBALS['counter']++;?>" data-id="<?php echo $attributes['yourId']; ?>">

<?php echo $instance->bp_portfolio_page_shortcode([]); ?>

</div>
</p>
