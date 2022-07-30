<?php 
/* Template Name: - Search by Writers Name single */
/* postyupe - writers_couch */
get_header();
nectar_page_header('2679');
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
        global $post;
         // if ( have_posts() ) :
          // while ( have_posts() ) :
            the_post(); 
            $postid = get_the_ID();
            $title = get_the_title();
            $posturl = get_the_permalink();
            $excerpt = get_the_excerpt();
            $featured_img_url = get_the_post_thumbnail_url();
            $writer_name = get_field( 'writers_couch_writer_name' );
            $writerauthorId = get_field( 'field_writerauthor' );
            $writerauthorData = get_user_by( 'ID', $writerauthorId );
            $writerauthorName =  $writerauthorData->first_name . ' ' . $writerauthorData->last_name;
            ?>
<?php 
/* products list */
$params = array(
  'posts_per_page' => -1,
  'post_type' => 'product',
  'fields' => 'ids',
  'meta_query' =>
  array(
    array(
      'key' => 'writeauthor',
      'value' => $writerauthorId,
      'compare' => 'LIKE')
  )
);
$wc_query = new WP_Query($params);
$prod_ids = $wc_query->posts;
$prod_list = '<ul>';
foreach ($prod_ids as $prod_id) {
  $prod_list .= '<li><a href="'.get_the_permalink( $prod_id ).'">'.get_the_title( $prod_id ).'</a></li>';
}
$prod_list .= '</ul>';
/**/
?>
            <div class="col span_4">
              <div class="product-wrap image">
                <img src="<?php echo $featured_img_url; ?>" alt="">
              </div>
            </div>
            <div class="col span_8">
              <div class="">
                <h2><?php echo $title; ?></h2>
                <p><?php echo $excerpt; ?></p>
                <?php echo $prod_list; ?>
              </div>
            </div>
            <?php
          // endwhile;
          ?>
        </div>
        <?php
        // wp_reset_postdata();
      // endif;
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
  'post_type' => 'writers_couch',
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
  });
</script>
<?php 
get_footer();
?>