<?php 
// [blogslider] [blogslider posts_per_page="3" category="upcoming-tours"]
add_shortcode( 'blogslider', 'blogslider_fn' );
function blogslider_fn( $atts ){
  extract(shortcode_atts(array(
    'posts_per_page'    => '-1',
    'category'      => '',
    'posttype'   => 'post',
  ), $atts));

  global $post;
  $args = array(
    'type'      => 'post',
    'post_type'   => $posttype,
    'tax_query' => array(
      array(
            'taxonomy' => 'category', // This is the taxonomy's slug!
            'field' => 'slug',
            'terms' => array($category) // This is the term's slug!
          )
    ),
    'status'    => 'publish',
    'orderby' => 'date',
    'order'   => 'DESC',
    'status'    => 'publish',
    'posts_per_page'=>5,
);
  $posts = get_posts( $args );
  $counttotal = count($posts);
  if( count($posts) ):
  $return = '';
    foreach( $posts as $post ): 
        setup_postdata( $post );
        $return .= '<!-- blog-'.$counttotal.' -->';
        $return .= '<div class="">';
        $return .= '<div class="image"><img src="'.get_the_post_thumbnail_url( null, 'full' ).'"></div>';
        // $return .= '<div class="image">'.get_the_post_thumbnail('full').'</div>';
        $return .= '<div class="desc"><h3>'.get_the_title().'</h3></div>';
        $return .= '<a class="overlayer" href="'.get_the_permalink().'"></a>';
        $return .= '</div>';
        $return .= '<!-- /blog-'.$counttotal.' -->';
        $counttotal--;
        if ($counttotal > 0) {
          $return .= '</div></div></div><div class="carousel-item"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper">';
        }
    endforeach; 
    wp_reset_postdata();
  //$return .= '';
  else :
    $return .= '<p>No posts found.</p>';
  endif;
return $return;
}