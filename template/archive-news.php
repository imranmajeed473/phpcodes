<?php 
/* Template Name: - Pagination Template*/
/* posttype - news */
get_header();
nectar_page_header($post->ID); 
// nectar_page_header('2679');
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="container-wrap search-container" data-midnight="dark" style="margin-top: 0px; padding-top: 30px;">
  <div class="container main-content search-content">
    <div class="row">
      <div class="post-searchby col span_12">
        <!--  -->
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
          'post_type' => 'news',
          'posts_per_page' => 6,
          'paged' => $paged,
          // 'orderby'     => 'title', 
          // 'order'       => 'ASC'
        );
        // add_filter( 'posts_where', 'title_filter', 10, 2 );
        $postslist = new WP_Query( $args );
        // remove_filter( 'posts_where', 'title_filter', 10, 2 );
        if ( $postslist->have_posts() ) :
          while ( $postslist->have_posts() ) : 
            $postslist->the_post(); 
            $postid = get_the_ID();
            $title = get_the_title();
            $posturl = get_the_permalink();
            $excerpt = get_the_excerpt();
            $featured_img_url = get_the_post_thumbnail_url();
            // $writer_name = get_field( 'news_writer_name' );
            ?>
            <div class="col span_6">
              <div class="product-wrap">
                <img src="<?php echo $featured_img_url; ?>" alt="">
                <a href="<?php echo $posturl; ?>">
                  <h2><?php echo $title; ?></h2>
                </a>
                <span><?php //echo $writer_name; ?></span>
              </div>
            </div>
            <?php
          endwhile;
          ?>
        </div>
        <div class="clearfix"></div>
        <div class="span_12 pagination">
          <div class="left"><?php previous_posts_link( '&laquo; PREV ' );  ?></div>
          <div class="right"><?php next_posts_link( 'NEXT &raquo;', $postslist->max_num_pages ); ?></div>
        </div>
        <?php
        wp_reset_postdata();
      else :
        echo '<h3 style="text-align:center;width:100%;"><span style="font-size:30px;"">&#128577;</span>Please broaden your search and try again.</h3>';
      endif;
      ?>
      <!--  -->
    </div>
  </div>
</div>
<?php 
get_footer();
?>