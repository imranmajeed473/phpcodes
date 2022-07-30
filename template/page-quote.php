<?php 
    
get_header(); 
nectar_page_header($post->ID); 

//full page
$fp_options = nectar_get_full_page_options();
extract($fp_options);

?>

<div class="container-wrap">
	<div class="<?php if($page_full_screen_rows != 'on') echo 'container'; ?> main-content">
		<div class="row">
	<br>
	<br>
	<?php echo do_shortcode( '[_quote]' ); ?>

		</div><!--/row-->
	</div><!--/container-->
</div><!--/container-wrap-->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
<?php if(isset($_GET['quote'])){
    echo "swal('Your quote request has been processed');";
}
?>
</script>
<?php get_footer(); ?>