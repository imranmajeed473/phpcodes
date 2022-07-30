<?php 

// [servicesslider]
add_shortcode( 'servicesslider', 'servicesslider_fn' );
function servicesslider_fn(){
  global $post;
  $args = array(
    'type'      => 'post',
    'post_type'   => 'services',
    'status'    => 'publish',
    'orderby' => 'menu_order',
    // 'order'   => 'DESC',
    'order'   => 'ASC',
    'status'    => 'publish',
    'posts_per_page'=>-1,
);
  $posts = get_posts( $args );
  $counttotal = count($posts);
  if( count($posts) ):
  $return = '';
    foreach( $posts as $post ): 
        setup_postdata( $post );
        $return .= '<!-- blog-'.$counttotal.' -->';
        $return .= '<div class="image">';
        $return .= get_the_post_thumbnail($post->ID, 'medium' );
        $return .= '<h3>'.get_the_title().'</h3>';
        $return .= '</div>';
        $return .= '<div class="desc">';
        $return .= '<h3>'.get_the_title().'</h3>';
        $return .= '<p>'.get_the_excerpt().'</p>';
        $return .= '<a href="'.get_the_permalink().'" class="readmore">READ MORE ></a>';
        $return .= '</div>';
        $return .= '<!-- /blog-'.$counttotal.' -->';
        $counttotal--;
        if ($counttotal > 0) {
          $return .= '</div></div></div><div class="carousel-item"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper">';
        }
    endforeach; 
    wp_reset_postdata();
  // $return .= '';
  else :
    $return .= '<p>No posts found.</p>';
  endif;
return $return;
}

// [blogs_sc] WP_Query shortcode
add_shortcode('blogs_sc', 'blogs_postfn');
function blogs_postfn() {
  $args = array(  
    'type'      => 'post',
    'post_type' => '',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC',
  );
  $loop = new WP_Query( $args ); 
  $return = '<div class="d-flex blogs-area col span_12 col_last">';
    if($loop->have_posts()):
       while ( $loop->have_posts() ) : 
          $loop->the_post(); 
          $return .= '<div class="blogs-box col span_4">';
          $return .= '<div class="blog-image-box">';
          $return .= '<img src="'.get_the_post_thumbnail_url(null,'full').'" class="blog-main-image">';
            $return .= '</div>';
            $return .= '<div class="blog-box-content">';
               $return .= '<span>By: admin - No Comments</span>';
               $return .= '<h3>'.get_the_title().'</h3>';
               $return .= '<p>'.get_the_excerpt().'</p>';
               $return .= '<a href="'.get_permalink().'" class="readmore">Read More >></a>';
            $return .= '</div>';
          $return .= '</div>';
      endwhile;
  endif;
 $return .='</div>';
 return $return;
 wp_reset_postdata(); 
}


// [cprblogs_sc] WP_Query shortcode
add_shortcode('cprblogs_sc', 'cprblogs_postfn');
function cprblogs_postfn() {
  $args = array(  
    'type'      => 'post',
    'post_type' => 'cdclivenews',
    'posts_per_page' => 4,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC',
  );
  $loop = new WP_Query( $args ); 
  $return = '<div class="col span_12">';
  $coltype = "newsfeedimage";

    if($loop->have_posts()):
       while ( $loop->have_posts() ) : 
          $loop->the_post();

          if ($coltype == "newsfeedimage") {
            $return .= '
            <div class="col span_6 newsfeedimage">
            <div class="image">
            <img src="/wp-content/uploads/2020/06/newsfeed2.jpg">
            <a class="overlayer" href="'.get_permalink().'"><i class="fa fa-link" aria-hidden="true"></i></a>
            </div>
            <div class="desc">
            <span class="date">'.get_the_date('d').'<br>'.get_the_date('M').'</span>
            <h3>'.get_the_title().'</h3>
            <!--
            <ul>
            <li><i class="fa fa-user" aria-hidden="true"></i>Mano</li>
            <li><i class="fa fa-eye" aria-hidden="true"></i>95 Views</li>
            <li><i class="fa fa-comment-o" aria-hidden="true"></i>5 Comments</li>
            </ul>
            -->
            <p>'.get_the_excerpt().'</p>
            <a class="readmore" href="'.get_permalink().'">Read More</a>
            </div>
            </div>
            ';
            $coltype = "newsfeedlist";
          } else {
              if ($coltype == "newsfeedlist"){
                $return .= '<div class="col span_6 newsfeedlist col_last">';
              }
              $coltype = "go close for newsfeedlist";
              $return .= '
              <div>
              <h3>'.get_the_title().'</h3>
              <a class="readmore" href="'.get_permalink().'">Read More</a>
              </div>
              ';
          }
      endwhile;
          $return .='</div>';// close for newsfeedlist
  endif;
 $return .='</div>';
 $return .='<a class="readmore" href="/cdclivenews/" style="margin: 0 auto !important; display: block; clear: both; text-align: center; width: max-content; bottom: -20px; position: relative; ">View All</a>'; 
 return $return;
 wp_reset_postdata(); 
}


?>