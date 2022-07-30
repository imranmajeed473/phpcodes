<?php 
/* Template Name: - Search By Play Title */
get_header();
nectar_page_header( $post->ID );
?>
<?php 
if ( isset($_POST['searchterm']) ){
  $searchterm = $_POST['searchterm'];
  $searchtermID = $_POST['searchtermID'];
  // $searchtermName = $_POST['searchtermName'];
} else {
  $searchterm = '';
}
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
// var_dump($_POST);
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
          <label for="searchfieldinput">SEARCH RESULTS FOR: </label>
          <div><h3><?php echo $searchterm; ?></h3></div>
        </div>
        <?php
      } ?>
      <div id="searchfield" class="searchfield">
        <form action="" method="POST" id="searchform">
          <label for="searchfieldinput">ENTER WRITER'S NAME: </label>
          <input type="text" name="searchterm" id="autocomplete" class="searchfieldinput" value="<?php //echo $searchterm; ?>">
          <input type="hidden" name="searchtermID" id="autocompleteID" class="searchfieldinput" value="<?php //echo $searchterm; ?>">
          <button type="submit" id="submit" class="searchfieldsubmit">Search</button>
        </form>
      </div>
      <?php //if ( !empty($searchterm) ) {
        ?>
        <div class="searchfield orderby ">
          <label for="searchfieldinput">Sort : </label>
        <form method="post" id="order">
          <input type="hidden" name="searchterm" value="<?php echo $searchterm; ?>">
          <select name="orderby" onchange='this.form.submit()'>
            <option value="title" <?php echo ($orderby == 'title') ? 'selected' : ''; ?>>Title</option>
            <option value="plafee" <?php echo ($orderby == 'plafee') ? 'selected' : ''; ?>>Performance Fee Pricing</option>
            <option value="write_name" <?php echo ($orderby == 'write_name') ? 'selected' : ''; ?>>Write name</option>
            <option value="play_duration" <?php echo ($orderby == 'play_duration') ? 'selected' : ''; ?>>Play duration</option>
          </select>
          <select name="order" onchange='this.form.submit()'>
            <option value="asc" <?php echo ($order == 'asc') ? 'selected' : ''; ?>>Asc</option>
            <option value="desc" <?php echo ($order == 'desc') ? 'selected' : ''; ?>>Desc</option>
          </select>
        </form>
      </div>
        <?php
      //} 
        ?>
    </div>
    <div class="row">
      <div class="post-searchby col span_12">
        <!--  -->
        <?php
        /*
        $writeauthor = get_field( 'writeauthor' );
        $writeauthorarray[] = $writeauthor['display_name'];
        */
        // function title_filter( $where, &$wp_query ) {
        //   global $wpdb;
        //   if ( $searchterm = $wp_query->get( 'search_prod_title' ) ) {
        //     $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $searchterm ) ) . '%\'';
        //   }
        //   return $where;
        // }
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
          'post_type' => 'product',
          'posts_per_page' => 6,
          'paged' => $paged,
          'meta_query'    => array(
            // array( 'key' => 'writer_name', 'value' => $searchterm, 'compare' => 'LIKE' ),
            // array( 'key' => 'writeauthor', 'value' => '39', 'compare' => 'LIKE' ),
            array( 'key' => 'writeauthor', 'value' => $searchtermID, 'compare' => 'LIKE' ),
            // 'relation' => 'OR'
          ),
          'orderby'     => $orderby,
          'order'       => $order
        );

        // add_filter( 'posts_where', 'title_filter', 10, 2 );
        $postslist = new WP_Query( $args );
        // remove_filter( 'posts_where', 'title_filter', 10, 2 );
        if ( $postslist->have_posts() && !empty($searchtermID) ) :
          while ( $postslist->have_posts() ) : 
            $postslist->the_post(); 
            $postid = get_the_ID();
            $title = get_the_title();
            $posturl = get_the_permalink();
            $excerpt = get_the_excerpt();
            $featured_img_url = get_the_post_thumbnail_url();
            $writeauthor = get_field( 'writeauthor' );
            $regular_price = get_post_meta( $post->ID, 'regular_price', true );

// var_dump($writeauthor);            
            ?>
            <div class="col span_3">
              <div class="product-wrap">
                <img src="<?php echo $featured_img_url; ?>" alt="">
                <a href="<?php echo $posturl; ?>">
                  <h2><?php echo $title; ?></h2>
                  <?php //echo $writeauthor['display_name']; ?>
                  <?php 
                  $wishlists = do_shortcode('[ti_wishlists_addtowishlist product_id="'.get_the_ID().'" variation_id="0"]');
                  $addtocardsearch = '<div class="overlay"><a href="'.get_permalink().'" class="button product_type_simple add_to_cart_button"><span>Select Options</span></a>'.$wishlists.'<a class="butn" href="'.get_permalink().'"><i class="fa fa-external-link" aria-hidden="true"></i></a></div>';
                  echo $addtocardsearch;
                  ?>
                </a>
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
    $writeauthor = get_field( 'writeauthor' );
    $writeauthorarray[] = '{value:"'.$writeauthor['user_nicename'].'",label:"'.$writeauthor['display_name'].'",id:"'.$writeauthor['ID'].'"}';
  endwhile;
  $writeauthorarray = array_unique($writeauthorarray);
  foreach ($writeauthorarray as $key => $value){
    // $titlehtml .= '"'.$value.'",';
    $titlehtml .= $value.',';
  }
endif;
// echo $titlehtml;
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
      minLength: 0,
      source: sourcedata,
      scroll: true,
      select: function( event, ui ) {
        jQuery( "#autocomplete" ).val( ui.item.label );
        jQuery("#autocompleteID").val(ui.item.id);
        return false;
      }
    })
    .focus(function() {
            jQuery(this).autocomplete("search", "");
        }
    );
    //select2 destroy
    jQuery('#order select').select2('destroy');
  });
</script>
<?php 
get_footer();
?>