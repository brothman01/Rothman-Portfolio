<p <?php echo get_block_wrapper_attributes(); ?>>

<?php if (null === $GLOBALS['counter']) {
    $GLOBALS['counter'] = 0;
}
?>
<div class="portfolio-block"  data-counter="<?php echo $GLOBALS['counter']++;?>" data-id="<?php echo $attributes['yourId']; ?>" style="overflow: hidden; max-width: 100%!important">

</div>
</p>
