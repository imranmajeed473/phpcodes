<?php 
/* Template Name: - Search by Writers Name */
/* posttype - writers_couch */
get_header();
nectar_page_header( $post->ID );
?>
<?php 
if ( isset($_POST['searchterm']) ){
  $searchterm = $_POST['searchterm'];
  $spancol = 'span_12';
} else {
  $searchterm = '';
  $spancol = 'span_6';
}
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="container-wrap search-container" data-midnight="dark" style="margin-top: 0px; padding-top: 30px;">
  <div class="container main-content search-content">
    <div class="search-head">
      <?php if ( !empty($searchterm) ) {
        ?>
        <div class="searchfield searchresult ">
          <h5>Search Results for:</h5>
          <h3><?php echo $searchterm; ?></h3>
        </div>
        <?php
      } ?>
      <div id="searchfield" class="searchfield">
        <form action="" method="POST" id="searchform">
          <label for="searchfieldinput">ENTER WRITER'S NAME: </label>
          <input type="text" name="searchterm" id="autocomplete" class="searchfieldinput" value="<?php //echo $searchterm; ?>">
          <button type="submit" id="submit" class="searchfieldsubmit">Search</button>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="post-searchby searchbywritersname col span_12">
        <!--  -->
        <?php
        // function title_filter( $where, &$wp_query ) {
        //   global $wpdb;
        //   if ( $searchterm = $wp_query->get( 'search_prod_title' ) ) {
        //     $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $searchterm ) ) . '%\'';
        //   }
        //   return $where;
        // }
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
          'post_type' => 'writers_couch',
          'posts_per_page' => 6,
          'paged' => $paged,
          'meta_query'    => array(
            array( 'key' => 'writers_couch_writer_name', 'value' => $searchterm, 'compare' => 'LIKE' ),
            // array( 'key' => 'writer_name', 'value' => 'Mick', 'compare' => 'LIKE' ),
            // 'relation' => 'OR'
          ),
          'orderby'     => 'title', 
          'order'       => 'ASC'
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
            $writer_name = get_field( 'writers_couch_writer_name' );
            ?>
            <div class="col <?php echo $spancol; ?> ">
              <div class="image">
                <img src="<?php echo $featured_img_url; ?>" alt="">
              </div>
              <div class="desc">
                <a href="<?php echo $posturl; ?>">
                  <h2><?php echo $title; ?></h2>
                </a>
                <p><?php echo $excerpt; ?></p>
                <span><?php echo $writer_name; ?></span>
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
    $titlehtml .= '"'.get_field('writers_couch_writer_name').'",';
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