<?php

global $porto_settings;

$post_layout     = 'medium';
$featured_images = porto_get_featured_images();

$post_class   = array();
$post_class[] = 'post post-' . $post_layout;
if ( isset( $porto_settings['post-title-style'] ) && 'without-icon' == $porto_settings['post-title-style'] ) {
	$post_class[] = 'post-title-simple';
}
$post_meta  = '';
$post_meta .= '<div class="post-meta ' . ( empty( $porto_settings['post-metas'] ) ? ' d-none' : '' ) . '">';
if ( isset( $porto_settings['post-metas'] ) && in_array( 'date', $porto_settings['post-metas'] ) ) {
	$post_meta .= '<span class="meta-date"><i class="far fa-calendar-alt"></i>' . get_the_date( esc_html( $porto_settings['blog-date-format'] ) ) . '</span>';
}
if ( isset( $porto_settings['post-metas'] ) && in_array( 'author', $porto_settings['post-metas'] ) ) {
	$post_meta .= '<span class="meta-author"><i class="far fa-user"></i>' . esc_html__( 'By ', 'porto' ) . get_the_author_posts_link() . '</span>';
}
	$cats_list = get_the_category_list( ', ' );
if ( $cats_list && isset( $porto_settings['post-metas'] ) && in_array( 'cats', $porto_settings['post-metas'] ) ) {
	$post_meta .= '<span class="meta-cats"><i class="far fa-folder"></i>' . porto_filter_output( $cats_list ) . '</span>';
}
	$tags_list = get_the_tag_list( '', ', ' );
if ( $tags_list && isset( $porto_settings['post-metas'] ) && in_array( 'tags', $porto_settings['post-metas'] ) ) {
	$post_meta .= '<span class="meta-tags"><i class="far fa-envelope"></i>' . porto_filter_output( $tags_list ) . '</span>';
}
if ( isset( $porto_settings['post-metas'] ) && in_array( 'comments', $porto_settings['post-metas'] ) ) {
	$post_meta .= '<span class="meta-comments"><i class="far fa-comments"></i>' . get_comments_popup_link( __( '0 Comments', 'porto' ), __( '1 Comment', 'porto' ), '% ' . __( 'Comments', 'porto' ) ) . '</span>';
}
if ( function_exists( 'Post_Views_Counter' ) && 'manual' == Post_Views_Counter()->options['display']['position'] && in_array( 'post', (array) Post_Views_Counter()->options['general']['post_types_count'] ) ) {
	$post_count = do_shortcode( '[post-views]' );
	if ( $post_count ) {
		$post_meta .= $post_count;
	}
}
if ( isset( $porto_settings['post-metas'] ) && in_array( 'like', $porto_settings['post-metas'] ) ) {
	$post_meta .= '<span class="meta-like">' . porto_blog_like() . '</span>';
}

	$post_meta .= '<span class="d-block float-sm-end mt-3 mt-sm-0"><a class="btn btn-xs btn-default text-xs text-uppercase" href="' . esc_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">' . esc_html__( 'Read more...', 'porto' ) . '</a></span>';
$post_meta     .= '</div>';

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
	<!-- Post meta before content -->
	<?php
	if ( isset( $porto_settings['post-meta-position'] ) && 'before' === $porto_settings['post-meta-position'] ) {
		echo '<div class="row"><div class="col-12">' . porto_filter_output( $post_meta ) . '</div></div>';}
	?>
	<div class="row">
	<?php if ( count( $featured_images ) ) : ?>
		<div class="col-lg-5">
			<?php
				// Post Slideshow
				$slideshow_type = get_post_meta( get_the_ID(), 'slideshow_type', true );

			if ( ! $slideshow_type ) {
				$slideshow_type = 'images';
			}
				porto_get_template_part(
					'views/posts/post-media/' . $slideshow_type,
					null,
					( 'images' == $slideshow_type ? array(
						'image_size' => 'blog-medium',
					) : false )
				);
			?>
		</div>
		<div class="col-lg-7">
	<?php else : ?>
		<div class="col-lg-12">
	<?php endif; ?>

			<div class="post-content">

				<?php
				if ( is_sticky() && is_home() && ! is_paged() ) {
					printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured', 'porto' ) );
				}
				?>

				<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

				<?php
				porto_render_rich_snippets( false );
				if ( ! empty( $porto_settings['blog-excerpt'] ) ) {
					echo porto_get_excerpt( $porto_settings['blog-excerpt-length'], false );
				} else {
					echo '<div class="entry-content">';
					porto_the_content();
					wp_link_pages(
						array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'porto' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'porto' ) . ' </span>%',
							'separator'   => '<span class="screen-reader-text">, </span>',
						)
					);
					echo '</div>';
				}
				?>

			</div>
		</div>
	</div>

	<!-- Post meta after content -->
	<?php
	if ( isset( $porto_settings['post-meta-position'] ) && 'before' !== $porto_settings['post-meta-position'] ) {
		echo porto_filter_output( $post_meta );}
	?>

</article>
