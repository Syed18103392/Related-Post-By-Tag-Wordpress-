////// shortcode for related post by tag
//
//
add_shortcode('related-post-by-tags', 'related_post_by_tags');
function related_post_by_tags(){
	ob_start();
	
	$orig_post = $post;
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {
	$tag_ids = array();
	foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
	$args=array(
	'tag__in' => $tag_ids,
	'post__not_in' => array($post->ID),
	'posts_per_page'=>6, // Number of related posts that will be shown.
	'ignore_sticky_posts'=>1
	);
	$my_query = new wp_query( $args );
	
	if( $my_query->have_posts() ) { ?>
<div class='all-post-list' >
	<?php
	while( $my_query->have_posts() ) {
	$my_query->the_post(); ?>

            <a href="<?php the_permalink() ?>">
				<div class='artical' style="background-image:linear-gradient(to bottom, rgba(245, 246, 252, 0), rgba(0,0, 0, 0.73)),url('<?php the_post_thumbnail_url() ?>')">
					<h4 class="postCategory"><?php the_category() ?></h4>
				<h2 class="posttitle"><?php the_title() ?> </h2>
					<div class='postMata'>
						<span class='postdate'><?php the_time( 'g:i a, j F Y' ) ?></span>
						<span class='postTegs'><?php the_tags( '', ' ', '' ); ?></span>
					</div>
				</div>
            </a>

<?php
} ?>
</div>

<?php
}
	$post = $orig_post;
	wp_reset_query();
	}
	return ob_get_clean();
	
}
//
//..shortcode for related post by tag
