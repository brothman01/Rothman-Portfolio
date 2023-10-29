<p <?php echo get_block_wrapper_attributes(); ?>>

<?php
if (null === $GLOBALS['counter']) {
    $GLOBALS['counter'] = 0;
}

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

?>
<div class="portfolio-block"  theHTML=<?php echo base64_encode( $content ); ?> data-counter="<?php echo $GLOBALS['counter']++;?>" data-id="<?php echo $attributes['yourId']; ?>" style="overflow: hidden; max-width: 100%!important">

</div>
</p>
