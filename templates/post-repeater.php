<div class="col-md-4 col-sm-6">
	<div class="post-box equalize-col">
		<?php if ( has_post_thumbnail() ) { echo '<img src="'.vt_resize('', wp_get_attachment_url( get_post_thumbnail_id($post->ID) ), 385, 250, true )['url'] .'" />';
		}?>
		<div class="post-box-content">
			<div class="entry-meta">
			   <?php the_time("d.m.y"); ?>
			   <?php
			   	$name = $separator = $output = ' ';
			   	$categories = get_the_category();
			   	if ( ! empty( $categories ) ) {
				    foreach( $categories as $category ) {
				    	if($category->name != 'Uncategorized')
				        	$output .= ' / ' . esc_html( $category->name );
				    }
				    echo trim( $output, $separator );
				}
			   ?>
			</div>
			<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

			<div class="post-content"><?php the_excerpt(); ?></div>	
			<div class="readmore-container">
				<!--<a href="<?php echo get_permalink(); ?>" class="read-more"> Read more </a>-->
			</div>
		</div>
		
	</div>
</div>

