<?
// WP_Query shortcode
// [blogpostsc posttype="blogpost" offset="1" classimg="span_4" classdesc="span_8" ] 
add_shortcode('blogpostsc', 'blogpost_postfn');
function blogpost_postfn( $atts ) {
   extract(shortcode_atts(array(
    'posttype'   => 'post',
    'posts_per_page'    => 1,
    'offset' => '',
  ), $atts));
 $args = array(
    'type'      => 'post',
    'post_type' => $posttype,
    'posts_per_page' => $posts_per_page,
    'offset' => $offset,
    'post_status' => 'publish',
  );
  $loop = new WP_Query( $args ); 
  $return = '<div class="col span_12">';

    if($loop->have_posts()):
       while ( $loop->have_posts() ) : 
          $loop->the_post();
            $return .= '
<div class="ourblog col span_12 col_last">
  <div class="image col '.$classimg.' ">
    <img src="'.get_the_post_thumbnail_url( null, 'full' ).'">
  </div>
  <div class="desc col col_last '.$classdesc.' ">
    <div class="date">'
    .get_the_date('d').' '
    .get_the_date('M').' '
    .get_the_date('y').' 
    12 APRIL 2020</div>
    <h3>'.get_the_title().'</h3>
    <p>'.get_the_excerpt().'</p>
    <a class="btn2" href="'.get_permalink().'">Read More <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
  </div>
</div>
            ';
      endwhile;
  endif;
 $return .='';
 return $return;
 wp_reset_postdata(); 
}