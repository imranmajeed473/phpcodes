<?php
/* template name: - Start Browsing */
if ( ! defined( 'ABSPATH' ) ) {exit; }
get_header();
nectar_page_header( $post->ID );
?>
<!-- content - start -->
<div class="container-wrap">
  <div class="container main-content">
    <div class="row">
      <div class="post-area col span_9">
        <div class="desc">
          <?php //this_page_content(); ?>
        </div>
<?php
$params = array(
  'posts_per_page' => 2,
  'post_type' => array('product', 'product_variation'),
  'meta_query' => array(
    'relation' => 'AND',
    // 'relation' => 'AND',
    // array( //have prive
    //   'key' => '_price',
    //   'value' => 0,
    //   'compare' => '>',
    //   'type' => 'NUMERIC'
    // ),
    array( //have prive
      'key' => 'groups_performers',
      'value' => 50,
      'compare' => '>',
      'type' => 'NUMERIC'
    ),
    // array( //Simple products type
    //   'key'           => '_sale_price',
    //   'value'         => 0,
    //   'compare'       => '>',
    //   'type'          => 'numeric'
    // ),
    // array( //Variable products type
    //   'key'           => '_min_variation_sale_price',
    //   'value'         => 0,
    //   'compare'       => '>',
    //   'type'          => 'numeric'
    // ),
    array( //in stock
      'key' => '_stock_status',
      'value' => 'instock'
    )
  ),
  // 'tax_query' => array(
  //   array(
  //     'taxonomy' => 'product_cat',
  //     'field' => 'slug',
  //     'terms' => ''
  //   )
  // )
  );
$wc_query = new WP_Query($params);

if ($wc_query->have_posts()) :
  while ($wc_query->have_posts()) :
    $wc_query->the_post();
    $product = get_product( $wc_query->post->ID );
    $images = wp_get_attachment_image_src( get_post_thumbnail_id($wc_query->post->ID),'single-post-thumbnail');
    $image = $images[0];
    $id = $wc_query->post->ID;
    $title = the_title();
    $title2 =  preg_replace("@^(.*?) ([^ ]+)\W?$@","$1 <strong>$2</strong>",$title);
    $link = get_the_permalink();
    // $category = wc_get_product_category_list($id);
    $category = strip_tags( wc_get_product_category_list( $id, '=','','' ) );
    // $category = preg_replace('/\s+/', '-', $category);
    $category = str_replace(' ', '-', $category);
    $category = str_replace('=', ' ', $category);
    $category = strtolower($category);

    $price = $product->price;
    $price_r = $product->regular_price;
    $price_s = $product->sale_price;
    $desc_s = $product->short_description;
    $price_per = round( ( $price_r - $price_s ) / $price_r * 100 ).'%';
    /*
      <?php echo $id ?>
      <?php echo $title ?>
      <?php echo $title2 ?>
      <?php echo $category ?>
      <?php echo $image; ?>
      <?php echo $link ?>
      <?php echo $price_r ?>
      <?php echo $price_s ?>
      <?php echo $desc_s ?>
      <?php echo $price_per ?>
      // wishlist
      <li><?php echo do_shortcode("[ti_wishlists_addtowishlist]"); ?></li>
      // quickview
      <li><a href="#" class="button yith-wcqv-button" data-product_id="<?php echo $id ?>"><i class="fa fa-expand"></i></a></li>
      // add to cart
      <a rel="nofollow" href="/?add-to-cart=<?php echo $id ?>" data-quantity="1" data-product_id="<?php echo $id ?>" data-product_sku="" class="add_to_cart_button ajax_add_to_cart" title="basket"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
    */
?>
      <?php echo $id ?>
      <?php echo $title ?>
      <br> 
<?php 
  endwhile; 
  wp_reset_postdata(); 
endif; 
?>
      </div><!--/span_9-->
      <div id="sidebar" class="col span_3 col_last">
        <?php my_sidebar_filter(); ?>
      </div><!--/span_3-->
    </div><!--/row-->
  </div><!--/container-->
</div><!--/container-wrap-->
<!-- content - end -->
<?php get_footer(); ?>
<?php
function this_page_content(){
  if ( have_posts() ) :
    while ( have_posts() ) :
      the_post();
      the_content();
    endwhile;
  endif;
}
?>
<?php
function my_sidebar_filter(){
  echo "sidebar";
}
?>