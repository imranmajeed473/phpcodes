<?php get_header(); ?>
<!-- header banner -->
<div id="page-header-wrap" data-animate-in-effect="zoom-out" data-midnight="light">
<div class="not-loaded  loaded" data-padding-amt="normal" data-animate-in-effect="zoom-out" id="page-header-bg" data-midnight="light" data-text-effect="rotate_in" data-bg-pos="center" data-alignment="center" data-alignment-v="bottom" data-parallax="0" data-height="300">
<div class="page-header-bg-image-wrap" id="nectar-page-header-p-wrap" data-parallax-speed="medium">
	<div class="page-header-bg-image"></div>
	</div> 
	<div class="container">
		<div class="row">
			<div class="col span_6 ">
				<div class="inner-wrap">
					<h1>Estate Sales</h1>
					<span class="subheader"><?php //the_title() ?></span>
				</div>
			</div>
		</div>
	</div><!-- container -->
</div><!-- page-header-bg -->
</div><!-- page-header-wrap -->
<!-- .header banner -->
<div class="container-wrap no-sidebar" data-midnight="dark">
<div class="container main-content">
<div class="row">
<div class="post-area col span_12 col_last">
<?php while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('postbox'); ?>>
 	<div class="image">
	<?php 
	if ( has_post_thumbnail() ) {
		echo get_the_post_thumbnail($post->ID, 'full', array('title' => ''));
	} ?>
 	</div>
	<h1 class="title"><?php the_title(); ?></h1>
	<span class="e_tag"><?php the_field( 'estate_tag' ); ?></span>
	<span class="e_price"><?php the_field( 'estate_price' ); ?></span>
	<span class="e_date"><?php the_field( 'estate_date' ); ?></span>
	<div class="desc"><?php echo the_excerpt(); ?>
		<a href="<?php echo get_the_permalink(); ?>" class="">Read More</a>
	</div>
</article><!--/article-->
<?php endwhile; // end of the loop. ?>
</div><!--/span_12-->
</div><!--/row-->
</div><!--/container-->
</div><!--/container-wrap-->
<style>
.page-header-bg-image {
    background-image: url('/wp-content/uploads/2019/07/slider1.jpg');
}
div#page-header-wrap,
div#page-header-bg {
    height: 350px;
}
article img.attachment-full.size-full.wp-post-image {
    /*width: 100%;*/
}
article h1.title {
    padding: 0 20px;
    font-size: 24px;
    line-height: 28px;
}
article .desc {
    padding: 0 20px 0;
}
.post-area.col.span_12.col_last {
	text-align: center;
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	width: 100%;
}
html body.archive article.postbox {
    flex-grow: 1;
    width: calc(50% - 30px);
}
.postbox span {
    display: inline-block;
}
.postbox span:not(:last-of-type):after {
    content: ' | ';
    color: #6db344;
    font-weight: 800;
    padding: 0 10px;
}
body.single .container-wrap {
    background: #f1f1f1;
}
article .desc p {
    font-size: 14px;
    line-height: 25px;
    text-shadow: #000000a6 0 0 1px;
}


body .desc a {font-size: 14px;font-weight: 500;background: #000000ad;padding: 7px 25px;box-shadow: #00000042 0 0 15px;color: #ffffff;margin: 10px 0px 0;display: inline-block;text-transform: uppercase;letter-spacing: 3px;text-shadow: #6db3446e 0 0 3px;}

body.archive article:hover {
    background: #6db344;
    color: #fff;
    transform: scale(1.05);
    transition: all .3s ease-in-out;
}

.postbox span:not(:last-of-type):after {}

body.archive article:hover span:after {
    color: #fff;
}
 

body.archive article:hover .desc a {
    background:#fff;
    color: #6db344;
}
body.archive article:hover h1.title {
    color:#fff;
}
 
 article h1.title {
    padding: 0 20px;
    font-size: 24px;
    font-size: 22px;
    line-height: 28px;
    text-transform: uppercase;
    font-weight: 500;
    letter-spacing: 0.5px;
    position: relative;
}
article .desc {
    padding: 0 20px 0;
    padding: 20px 20px 0;
}
.post-area.col.span_12.col_last {
	text-align: center;
}
</style>
<?php  get_footer(); 