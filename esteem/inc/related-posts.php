<?php $related_posts = esteem_related_posts_function(); ?>

<?php if ( $related_posts->have_posts() ) : ?>

	<div class="related-posts-wrapper">

		<h4 class="related-posts-main-title">
			<i class=" icon-thumbs-up"></i><span><?php esc_html_e( 'You May Also Like', 'esteem' ); ?></span>
		</h4>

		<div class="related-posts clearfix">

			<?php
			$count = 1;
			while ( $related_posts->have_posts() ) :
				$related_posts->the_post();
				?>
				<?php
				$class = 'tg-one-third';
				if ( $count % 3 == 0 ) {
					$class = 'tg-one-third tg-one-third-last';
				}
				?>

				<div class="<?php echo esc_attr( $class ); ?>">

					<?php if ( has_post_thumbnail() ) : ?>
						<?php
						$title_attribute     = get_the_title( $post->ID );
						$thumb_id            = get_post_thumbnail_id( get_the_ID() );
						$img_altr            = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
						$img_alt             = ! empty( $img_altr ) ? $img_altr : $title_attribute;
						$post_thumbnail_attr = array(
							'alt'   => esc_attr( $img_alt ),
							'title' => esc_attr( $title_attribute ),
						);
						?>
						<div class="post-thumbnails">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php the_post_thumbnail( 'blog-medium', $post_thumbnail_attr ); ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="wrapper">

						<h3 class="entry-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</h3><!--/.post-title-->

						<div class="entry-meta">
							<?php
							$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
							$time_string = sprintf(
								$time_string,
								esc_attr( get_the_date( 'c' ) ),
								esc_html( get_the_date() )
							);
							printf(
								__( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark"><i class="fa fa-calendar-o"></i> %3$s</a></span>', 'esteem' ),
								esc_url( get_permalink() ),
								esc_attr( get_the_time() ),
								$time_string
							);
							?>

							<span class="byline"><span class="author vcard"><i class="fa fa-user"></i><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span></span>
						</div>

					</div>

				</div><!--/.related-->
				<?php
				++$count;
		endwhile;
			?>

		</div><!--/.post-related-->

	</div>
<?php endif; ?>

<?php wp_reset_query(); ?>
