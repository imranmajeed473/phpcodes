<?php 
// ali
function all_posts() {
    $args = array(  
        'post_type'   => 'post',
        'post_status' => 'publish',
        'posts_per_page' => '4'
    );

    $loop = new WP_Query( $args ); 
?>
	<div class="d-flex all-posts">
<?php		
    if($loop->have_posts()):
    	$inc = 1;
	    while ( $loop->have_posts() ) : $loop->the_post(); 
	        if($inc > 2){
	            $class = "post-reverse";
	        } else {
	            $class = "";
	        }
?>
	    	<div class="kyle-post-box <?php echo $class; ?>">
				<div class="kyle-post-content">
				    <p><?php 
				        $cate = get_the_category(get_the_ID());
				        echo $cate[0]->name;    
				     ?></p>
				    <h4><?php echo get_the_excerpt(); ?></h4>
				    <a href="<?php echo get_the_permalink(); ?>">Explore More</a>
				    <h6>Coperate <?php echo get_the_date(); ?></h6>
				</div>
				<div class="kyle-post-image" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');">
				    <a href="<?php echo get_the_permalink(); ?>">Explore more</a>
				</div>
			</div>
<?php
        $inc++;
	    endwhile;
	endif;
?>

	</div>
<?php 
	if($loop->found_posts > 4){
?>
		<div class="viewmore-services">
			<a href="#">VIEW ALL</a>
		</div>
<?php
	}
    wp_reset_postdata(); 
}
add_shortcode('all_posts', 'all_posts'); ?>
