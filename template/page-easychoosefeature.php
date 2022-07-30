<?php 
/* Template Name: - Easy-Choose Feature */
session_start();
get_header();
nectar_page_header( $post->ID );die;
?>
<?php
// var_dump($_POST['acf']);
// echo '<br>';
// var_dump($_SESSION['acf_last']);
// save data to sesstion
if ( isset($_POST['acf']) ){
  $_SESSION['acf_last']=$_POST['acf'];
} 
// on sort change
if ( isset($_GET['orderby']) AND !isset($_POST['acf']) AND isset($_SESSION['acf_last']) ) {
    $_POST['acf']=$_SESSION['acf_last'];
}
// get post data
if ( isset($_POST['acf']) ){
$writer_name            = ($_POST['acf']['field_writer_name']) ?  $_POST['acf']['field_writer_name'] : null;
$school_performance     = ($_POST['acf']['field_school_performance']) ?  $_POST['acf']['field_school_performance'] : null;
$students_grades        = ($_POST['acf']['field_students_grades']) ?  $_POST['acf']['field_students_grades'] : null;
$age_groups             = ($_POST['acf']['field_age_groups']) ?  $_POST['acf']['field_age_groups'] : null;
$classification_of_play = ($_POST['acf']['field_classification_of_play']) ?  $_POST['acf']['field_classification_of_play'] : null;
$type_of_play           = ($_POST['acf']['field_type_of_play']) ?  $_POST['acf']['field_type_of_play'] : null;
$genre_play_be          = ($_POST['acf']['field_genre_play_be']) ?  array($_POST['acf']['field_genre_play_be']) : null;
$estimated_duration     = ($_POST['acf']['field_estimated_duration']) ?  $_POST['acf']['field_estimated_duration'] : null;
$character_identities   = ($_POST['acf']['field_character_identities']) ?  $_POST['acf']['field_character_identities'] : null;
$characters_number      = ($_POST['acf']['field_characters_number']) ?  $_POST['acf']['field_characters_number'] : null;
$release_date           = ($_POST['acf']['field_release_date']) ?  $_POST['acf']['field_release_date'] : null;
$classification_rating  = ($_POST['acf']['field_classification_rating']) ?  $_POST['acf']['field_classification_rating'] : null;
}
// saerch
$searchterm = '';
if ( isset($_GET['searchterm']) ){
  $searchterm = $_GET['searchterm'];
}
// order
//sort
if ( isset($_POST['orderby']) ){
  $orderby = $_POST['orderby'];
} else {
  $orderby = 'title';
}
if ( isset($_POST['order']) ){
  $order = $_POST['order'];
} else {
  $order = 'asc';
}

// $orderby = 'title';
// $order = 'ASC';
// if ( isset($_GET['orderby']) ){
//   $orderby = $_GET['orderby'];
//   if( strpos( $orderby , '-desc' ) == true ){
//     $orderby = str_replace("-desc","",$orderby);
//     $order = 'DESC';
//   }
// }
 // echo '<br>$searchterm='.$searchterm.', $orderby='.$orderby.', $order='.$order;
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="container-wrap search-container" data-midnight="dark" style="margin-top: 0px; padding-top: 30px;">
  <div class="container main-content search-content">
    <?php 
    /* page content */
    $page = get_page_by_path('easychoosefeature');
    $content = apply_filters('the_content', $page->post_content);
    echo $content;
    ?>
    <div class="search-head">
      <?php if ( !empty($searchterm) ) {
        ?>
        <div class="searchfield searchresult ">
          <h5>Search result of:</h5>
          <div>
            <h3><?php echo $searchterm; ?></h3>
          </div>
        </div>
        <?php
      } ?>
    </div>
    <div class="row">
      <div class="post-searchby col span_9">
        <!--  -->
        <?php
        // get post data query
        $meta_query = array('relation' => 'AND');
        if (isset($writer_name))
        {
          $meta_query[] = array(
            'key' => 'writer_name',
            'value' => $writer_name,
            'compare' => 'LIKE'
          );
        }
        if (isset($school_performance))
        {
          $meta_query[] = array(
            'key' => 'school_performance',
            'value' => $school_performance,
            'compare' => 'LIKE'
          );
        }
        if (isset($students_grades))
        {
          $meta_query[] = array(
            'key' => 'students_grades',
            'value' => $students_grades,
            'compare' => 'LIKE'
          );
        }
        if (isset($age_groups))
        {
          $meta_query[] = array(
            'key' => 'age_groups',
            'value' => $age_groups,
            'compare' => 'LIKE'
          );
        }
        if (isset($classification_of_play))
        {
          $meta_query[] = array(
            'key' => 'classification_of_play',
            'value' => $classification_of_play,
            'compare' => 'LIKE'
          );
        }
        if (isset($type_of_play))
        {
          $meta_query[] = array(
            'key' => 'type_of_play',
            'value' => $type_of_play,
            'compare' => 'LIKE'
          );
        }
        if (isset($genre_play_be))
        {
          $meta_query[] = array(
            'key' => 'genre_play_be',
            'value' => $genre_play_be,
            'compare' => 'LIKE'
          );
        }
        if (isset($estimated_duration))
        {
          $meta_query[] = array(
            'key' => 'estimated_duration',
            'value' => $estimated_duration,
            'compare' => 'LIKE'
          );
        }
        if (isset($character_identities))
        {
          $meta_query[] = array(
            'key' => 'character_identities',
            'value' => $character_identities,
            'compare' => 'LIKE'
          );
        }
        if (isset($characters_number))
        {
          $meta_query[] = array(
            'key' => 'characters_number',
            'value' => $characters_number,
            'compare' => 'LIKE'
          );
        }
        if (isset($release_date))
        {
          $meta_query[] = array(
            'key' => 'release_date',
            'value' => $release_date,
            'compare' => '=',
            'type' => 'DATE'
          );
        }
        // if (isset($classification_rating))
        // {
        //   $meta_query[] = array(
        //     'key' => 'classification_rating',
        //     'value' => $classification_rating,
        //     'compare' => '<=', 
        //     'type' => 'NUMERIC'
        //   );
        // }
// echo '<pre style="position: absolute; z-index: 999; background: #ffffffd9; color: #000; font-weight: 600; ">'; 
// var_dump($meta_query); 
// echo '</pre>'; 
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
          'post_type' => 'product',
          'posts_per_page' => 6,
          'paged' => $paged,
          // 'tax_query' => array(
          //   array(
          //     'taxonomy' => 'product_tag',
          //     'field' => 'slug',
          //     'terms' => array('comedy','war'),
          //   ),
          // ),
          // 'tax_query' => array(
          //   array(
          //     'taxonomy' => 'product_tag',
          //     'field' => 'slug',
          //     'terms' => $genre_play_be,
          //   ),
          // ),
          'meta_query'    => $meta_query,
          'orderby'     => $orderby, 
          'order'       => $order,
        );
        $postslist = new WP_Query( $args );
        if ( $postslist->have_posts() ) :
          while ( $postslist->have_posts() ) : 
            $postslist->the_post(); 
            $postid = get_the_ID();
            $title = get_the_title();
            $posturl = get_the_permalink();
            $excerpt = get_the_excerpt();
            $featured_img_url = get_the_post_thumbnail_url();
            $regular_price = get_post_meta( $post->ID, 'regular_price', true );
            $writer_name = get_field( 'writer_name' );
            $release_date = get_field( 'release_date' );
            $price = get_field( '_price' );
            ?>
            <div class="col span_4">
              <div class="product-wrap">
                <div class="image">
                  <img src="<?php echo $featured_img_url; ?>" alt="">
                </div>
                <a href="<?php echo $posturl; ?>">
                  <h2><?php echo $title; ?></h2>
                </a>
                <span>Write: <strong><?php echo $writer_name; ?></strong></span><br>
                <span>Release date: <strong><?php echo $release_date; ?></strong></span><br>
                <span>Price: <strong><?php echo $price; ?></strong></span><br>
                <span>Rating: <strong><?php echo $classification_rating; ?></strong></span>
              </div>
            </div>
            <?php //acf_form(); ?>
            <?php
          endwhile;
          ?>
        </div>
      <div class="post-searchby col span_3 col_last">
        <div id="searchfield" class="searchfield easysort">
          <?php do_shortcode('[easychoosefeaturesort]'); ?>
        </div>
        <div id="searchfield" class="searchfield easychoosefeature">
          <?php 
          include_once 'page-easychoosefeature-form.php';
          ?>
        </div>
      </div>
        <div class="clearfix"></div>
        <div class="span_12 pagination">
          <div class="left"><?php previous_posts_link( '&laquo; PREV ' );  ?></div>
          <div class="right"><?php next_posts_link( 'NEXT &raquo;', $postslist->max_num_pages ); ?></div>
        </div>
        <?php
        wp_reset_postdata();
      else :
        $return .= '<p>No benefit found.</p>';
      endif;
      ?>
<!--  -->
<?php 
/*
$options = array(
  'field_groups' => array('group_5c7ebe089367e'),
  // 'submit_value'  => 'SAERCH',
  'new_post' => false,
    'post_id' => false,
  'form' => false,
    'fields' => array('classification_of_play','type_of_play'),
  'html_before_fields' => '<li><label><input type="radio" id="acf-field_classification_of_play" name="acf[field_classification_of_play]" value="">000</label></li>',
);
acf_form($options);
*/
 ?>
<!--  -->
<?php 
/*$settings = array(
  'field_groups' => array('group_5c7ebe089367e'),
  'id' => 'easychoosefeature-form',
  'post_id' => false,
  'new_post' => false,
  // 'fields' => false,
  'post_title' => false,
  'post_content' => false,
  'form' => true,
  'form_attributes' => array(),
  'return' => '',
  'html_before_fields' => '',
  'html_after_fields' => '',
  'submit_value' => "SEARCH",
  'updated_message' => '',
  'label_placement' => 'top',
  'instruction_placement' => false,
  'field_el' => '',
  'uploader' => 'wp',
  'honeypot' => true,
  'html_updated_message'  => '',
  'html_submit_button'  => '<input type="submit" class="searchfieldsubmit" value="%s" />',
  'html_submit_spinner' => '<span class="acf-spinner"></span>',
  'kses'  => false
);*/
//acf_form($settings);
?> 
<!--  -->
    </div>
  </div>
</div>
<script type="text/javascript">
  jQuery(document).ready(function(){
    setTimeout(function() {
      jQuery(".message").hide();
    }, 10000);
  });
</script>
<?php 
$args = array(
  'post_type' => 'product',
  'posts_per_page' => -1,
  'post_status' => 'publish',
  'orderby'     => 'title', 
  'order'       => 'ASC'
);
$titlelist = new WP_Query( $args );
if ( $titlelist->have_posts() ) :
  $titlehtml = '';
  while ( $titlelist->have_posts() ) :
    $titlelist->the_post();
    // $titlehtml .= '"'.get_the_title().'",';
    $titlehtml .= '"'.get_field('writer_name').'",';
  endwhile;
endif;
?>
<style type="text/css">
.searchfield{max-width: 500px;margin:10px auto 30px;padding:4px 20px 15px;box-shadow:0 0 9px rgba(0,0,0,.2);width: 100%;}
.searchfield.searchresult{max-width: 330px; }
.searchfield.easysort{max-width: 300px; }
.ui-autocomplete{position:absolute;cursor:default;}
.ui-autocomplete-loading{background:white url('images/ui-anim_basic_16x16.gif') right center no-repeat;}
.ui-autocomplete{cursor:pointer;height:120px;overflow-y:scroll;}
.ui-autocomplete{/*   position: absolute; */ /* top: 100%; */ /* left: 0; */ z-index:1000;display:none;  /* float: left; */  /* padding: 5px 0; */ margin:2px 0 0;list-style:none;  /* font-size: 14px; */text-align:left;  /* background-color: #ffffff; */  /* border: 1px solid #cccccc; */ /* border: 1px solid rgba(0, 0, 0, 0.15); */ /* border-radius: 4px; */ -webkit-box-shadow:0 6px 12px rgba(0,0,0,0.175);box-shadow:0 6px 12px rgba(0,0,0,0.175);background-clip:padding-box;}
.ui-autocomplete > li > div{display:block;padding:3px 20px;clear:both;font-weight:normal;line-height:1.42857143;color:#333333;white-space:nowrap;}
.ui-state-hover,
.ui-state-active,
.ui-state-focus{text-decoration:none;color:#262626;background-color:#f5f5f5;cursor:pointer;}
.ui-helper-hidden-accessible{border:0;clip:rect(0 0 0 0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px;}
.ui-menu{list-style:none;margin:0;display:block;}
.ui-menu .ui-menu{margin-top:-3px;}
.ui-menu .ui-menu-item a{text-decoration:none;display:block;padding:.2em .4em;line-height:1.5;zoom:1;}
.ui-menu .ui-menu-item a.ui-state-hover,
.ui-menu .ui-menu-item a.ui-state-active{margin:-1px;}
.ui-menu .ui-menu-item:not(.ui-state-focus) {border-top: 1px solid transparent; border-bottom: 1px solid transparent; }
.ui-menu .ui-menu-item strong {font-family: 'Quicksand', sans-serif; font-weight: 700; }
.ui-menu .ui-menu-item {margin: 0; padding: 0px 10px; line-height: 27px; border-left: 0; border-right: 0; font-family: 'Quicksand', sans-serif; }
</style>
<script>
  // var sourcedata= [< ?php echo $titlehtml; ?>]
  // sourcedata.sort();
  // jQuery(document).ready(function(){
  //   jQuery( "#autocomplete" ).autocomplete({
  //     source: sourcedata,
  //     minLength: 0,
  //     scroll: true
  //   }).focus(function() {
  //           jQuery(this).autocomplete("search", "");
  //       });
  // });
</script>
<script>
  var sourcedata= [<?php echo $titlehtml; ?>]
  sourcedata.sort();
  jQuery(document).ready(function(){
    // highlight 
    $.ui.autocomplete.prototype._renderItem = function (ul, item) {        
      var t = String(item.value).replace(
        new RegExp(this.term, "gi"),
        "<strong>$&</strong>");
      return $("<li></li>")
      .data("item.autocomplete", item)
      // .append("<div>" + t + "</div>")
      .append(t)
      .appendTo(ul);
    };
    // autocomplete
    jQuery( "#autocomplete" ).autocomplete({
      source: sourcedata,
      minLength: 0,
      scroll: true
    })
    .focus(function() {
            jQuery(this).autocomplete("search", "");
        }
    );
    // select2 destroy
    // jQuery('select#sortbox').select2('destroy');
  });
//radio unckeck
jQuery('ul.acf-radio-list[data-allow_null="1"] :radio').mousedown(function(e){
  var $self = $(this);
  if( $self.is(':checked') ){
    var uncheck = function(){
      setTimeout(function(){$self.removeAttr('checked');},0);
    };
    var unbind = function(){
      $self.unbind('mouseup',up);
    };
    var up = function(){
      uncheck();
      unbind();
    };
    $self.bind('mouseup',up);
    $self.one('mouseout', unbind);
  }
});
</script>
<?php 
get_footer();
?>