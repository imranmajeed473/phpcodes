<?php 
/* Template Name: - single testimonial*/
/* post-type - wpm-testimonial */
get_header();
nectar_page_header('3064');
?>
<?php 
global $nectar_theme_skin, $options;

$bg = get_post_meta($post->ID, '_nectar_header_bg', true);
$bg_color = get_post_meta($post->ID, '_nectar_header_bg_color', true);
$fullscreen_header = (!empty($options['blog_header_type']) && $options['blog_header_type'] == 'fullscreen' && is_singular('post')) ? true : false;
$blog_header_type = (!empty($options['blog_header_type'])) ? $options['blog_header_type'] : 'default';
$fullscreen_class = ($fullscreen_header == true) ? "fullscreen-header full-width-content" : null;
$theme_skin = (!empty($options['theme-skin'])) ? $options['theme-skin'] : 'original' ;
$headerFormat = (!empty($options['header_format'])) ? $options['header_format'] : 'default';
if($headerFormat == 'centered-menu-bottom-bar') $theme_skin = 'material';		
$hide_sidebar = (!empty($options['blog_hide_sidebar'])) ? $options['blog_hide_sidebar'] : '0'; 
$blog_type = $options['blog_type']; 
$blog_social_style = (!empty($options['blog_social_style'])) ? $options['blog_social_style'] : 'default';
$enable_ss = (!empty($options['blog_enable_ss'])) ? $options['blog_enable_ss'] : 'false';

 ?>

<div class="container-wrap <?php echo ($fullscreen_header == true) ? 'fullscreen-blog-header': null; ?> <?php echo 'no-sidebar'; ?>" data-midnight="dark">
	<div class="container main-content">




			
		<div class="row">
<h3 class="entry-title"><strong><?php the_title(); ?></strong></h3>

			<?php 

			$options = get_nectar_theme_options(); 

			global $options;

			$blog_standard_type = (!empty($options['blog_standard_type'])) ? $options['blog_standard_type'] : 'classic';
			$blog_type = $options['blog_type'];
			if($blog_type == null) $blog_type = 'std-blog-sidebar';
			
			if($blog_standard_type == 'minimal' && $blog_type == 'std-blog-sidebar' || $blog_type == 'std-blog-fullwidth')
				$std_minimal_class = 'standard-minimal';
			else
				$std_minimal_class = '';

			echo '<div class="post-area col '.$std_minimal_class.' span_12 col_last">';
			
				 if(have_posts()) : while(have_posts()) : the_post(); 

					if ( floatval(get_bloginfo('version')) < "3.6" ) {
						//old post formats before they got built into the core
						 get_template_part( 'includes/post-templates-pre-3-6/entry', get_post_format() ); 
					} else {
						//WP 3.6+ post formats
						 get_template_part( 'includes/post-templates/entry', get_post_format() ); 
					} 
	
				 endwhile; endif; 
				
				 wp_link_pages(); 
					

				    global $options; 
						
						if($blog_header_type == 'default_minimal' && $blog_social_style != 'fixed_bottom_right' && 'post' == get_post_type() )  { ?>
						
							<div class="bottom-meta">	
								<?php
								
								$using_post_pag = (!empty($options['blog_next_post_link']) && $options['blog_next_post_link'] == '1') ? true : false;
								$using_related_posts = (!empty($options['blog_related_posts']) && !empty($options['blog_related_posts']) == '1') ? true : false;
								$extra_bottom_space = ($using_related_posts && !$using_post_pag) ? 'false' : 'true';
								
									echo '<div class="sharing-default-minimal" data-bottom-space="'.$extra_bottom_space.'">'; 
										nectar_blog_social_sharing();
									echo '</div>'; ?>
							</div>
						<?php } 
						
				    if($theme_skin != 'ascend') {
							
						if( !empty($options['author_bio']) && $options['author_bio'] == true && 'post' == get_post_type() ){ 
							$grav_size = 80;
							$fw_class = null; 
							$has_tags = 'false';
							
							if(!empty($options['display_tags']) && $options['display_tags'] == true && has_tag()) { $has_tags = 'true'; }
							
						?>
							
							<div id="author-bio" class="<?php echo $fw_class; ?>" data-has-tags="<?php echo $has_tags; ?>">
								<div class="span_12">
									<?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), $grav_size, null, get_the_author() ); }?>
									<div id="author-info">
										<h3><span><?php if($theme_skin == 'ascend') { _e('Author', 'salient'); } else if($theme_skin != 'material') { _e('About', 'salient'); } ?></span> 
											
											<?php if($theme_skin == 'material') { echo '<a href="'. get_author_posts_url(get_the_author_meta( 'ID' )).'">'; }
											echo get_the_author(); 
											if($theme_skin == 'material') { echo '</a>'; } ?></h3>
										
										<p><?php the_author_meta('description'); ?></p>
									</div>
									<?php if($theme_skin == 'ascend'){ echo '<a href="'. get_author_posts_url(get_the_author_meta( 'ID' )).'" data-hover-text-color-override="#fff" data-hover-color-override="false" data-color-override="#000000" class="nectar-button see-through-2 large"> '. __("More posts by",'salient') . ' ' .get_the_author().' </a>'; } ?>
									<div class="clear"></div>
								</div>
							</div>
							
					<?php } 
			
			} ?>

			


			</div><!--/span_9-->
			
			<?php if($blog_type != 'std-blog-fullwidth' && $hide_sidebar != '1') { ?>
				
				<div id="sidebar" data-nectar-ss="<?php echo $enable_ss; ?>" class="col span_3 col_last">
					<?php get_sidebar(); ?>
				</div><!--/sidebar-->
				

			<?php } ?>
			
			
		</div><!--/row-->

		

		<!--ascend only author/comment positioning-->
		<div class="row">

			<?php if($theme_skin == 'ascend' && $fullscreen_header == true && 'post' == get_post_type() ) { ?>

			<div id="single-below-header" class="<?php echo $fullscreen_class; ?> custom-skip">
				<?php if($blog_social_style != 'fixed_bottom_right') { ?>
					<span class="meta-share-count"><i class="icon-default-style steadysets-icon-share"></i> <?php echo '<a href=""><span class="share-count-total">0</span> <span class="plural">'. __('Shares','salient') . '</span> <span class="singular">'. __('Share','salient') .'</span> </a>'; nectar_blog_social_sharing(); ?> </span>
				<?php } else { ?>
					<span class="meta-love"><span class="n-shortcode"> <?php echo nectar_love('return'); ?>  </span></span>
				<?php } ?>
				<span class="meta-category"><i class="icon-default-style steadysets-icon-book2"></i> <?php the_category(', '); ?></span>
				<span class="meta-comment-count"><i class="icon-default-style steadysets-icon-chat-3"></i> <a class="comments-link" href="<?php comments_link(); ?>"><?php comments_number( __('No Comments', 'salient'), __('One Comment ', 'salient'), __('% Comments', 'salient') ); ?></a></span>
			</div><!--/single-below-header-->

			<?php }

			if($theme_skin == 'ascend' || $theme_skin == 'material') {
				
			nectar_next_post_display(); 
			nectar_related_post_display();
			
		} ?>

			<?php if( !empty($options['author_bio']) && $options['author_bio'] == true && $theme_skin == 'ascend' && 'post' == get_post_type()) { 
						$grav_size = 80;
						$fw_class = 'full-width-section '; 
						$next_post = get_previous_post();
						$next_post_button = (!empty($options['blog_next_post_link']) && $options['blog_next_post_link'] == '1') ? 'on' : 'off';
					?>
						
						<div id="author-bio" data-midnight="dark" class="<?php echo $fw_class; if(empty($next_post) || $next_post_button == 'off' || $fullscreen_header == false && $next_post_button == 'off') echo 'no-pagination'; ?>">
							<div class="span_12">
								<?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), $grav_size,  null, get_the_author() ); }?>
								<div id="author-info">
									<h3><span><?php if($theme_skin == 'ascend') {  echo '<i>' . __('Author', 'salient') . '</i>'; } else { _e('About', 'salient'); } ?></span> <?php the_author(); ?></h3>
									<p><?php the_author_meta('description'); ?></p>
								</div>
								<?php if($theme_skin == 'ascend'){ echo '<a href="'. get_author_posts_url(get_the_author_meta( 'ID' )).'" data-hover-text-color-override="#fff" data-hover-color-override="false" data-color-override="#000000" class="nectar-button see-through-2 large">' . __("More posts by",'salient') . ' ' . get_the_author().' </a>'; } ?>
								<div class="clear"></div>
							</div>
						</div>
 
			 <?php } ?>


			  <?php if($theme_skin == 'ascend' || $theme_skin == 'material') { ?>

			 	 <div class="comments-section" data-author-bio="<?php if(!empty($options['author_bio']) && $options['author_bio'] == true) { echo 'true'; } else { echo 'false'; } ?>">
					   <?php comments_template(); ?>
				 </div>   

			 <?php } ?>

		</div>


	   <?php if($theme_skin != 'ascend' && $theme_skin != 'material') { 
			 nectar_next_post_display();
			 nectar_related_post_display();
		 } ?>
		
	</div><!--/container-->

</div><!--/container-wrap-->

<?php get_footer(); ?>