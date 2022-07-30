<?php
/*
** Template Name: Add Post From Frontend
** https://www.phpkida.com/how-to-add-post-from-frontend-in-wordpress-without-plugin/
*/
?>
<div class="col-sm-12">
	<h3>Add New Post</h3>
	<form class="form-horizontal" name="form" method="post" enctype="multipart/form-data">
		<input type="hidden" name="ispost" value="1" />
		<input type="hidden" name="userid" value="" />
		<div class="col-md-12">
			<label class="control-label">Title</label>
			<input type="text" class="form-control" name="title" />
		</div>

		<div class="col-md-12">
			<label class="control-label">Sample Content</label>
			<textarea class="form-control" rows="8" name="sample_content"></textarea>
		</div>

		<div class="col-md-12">
			<label class="control-label">Choose Category</label>
			<select name="category" class="form-control">
				<?php
				$catList = get_categories();
				foreach($catList as $listval)
				{
					echo '<option value="'.$listval->term_id.'">'.$listval->name.'</option>';
				}
				?>
			</select>
		</div>

		<div class="col-md-12">
			<label class="control-label">Upload Post Image</label>
			<input type="file" name="sample_image" class="form-control" />
		</div>

		<div class="col-md-12">
			<input type="submit" class="btn btn-primary" value="SUBMIT" name="submitpost" />
		</div>
	</form>
	<div class="clearfix"></div>
</div>
<script>
function returnformValidations()
{
	var title = document.getElementById("title").value;
	var content = document.getElementById("content").value;
	var category = document.getElementById("category").value;

	if(title=="")
	{
		alert("Please enter post title!");
		return false;
	}
	if(content=="")
	{
		alert("Please enter post content!");
		return false;
	}
	if(category=="")
	{
		alert("Please choose post category!");
		return false;
	}
}
</script>
<?php
if(is_user_logged_in())
{
	if(isset($_POST['ispost']))
	{
		global $current_user;
		get_currentuserinfo();

		$user_login = $current_user->user_login;
		$user_email = $current_user->user_email;
		$user_firstname = $current_user->user_firstname;
		$user_lastname = $current_user->user_lastname;
		$user_id = $current_user->ID;

		$post_title = $_POST['title'];
		$sample_image = $_FILES['sample_image']['name'];
		$post_content = $_POST['sample_content'];
		$category = $_POST['category'];

		$new_post = array(
			'post_title' => $post_title,
			'post_content' => $post_content,
			'post_status' => 'pending',
			'post_name' => 'pending',
			'post_type' => $post_type,
			'post_category' => $category
		);

		$pid = wp_insert_post($new_post);
		add_post_meta($pid, 'meta_key', true);

		if (!function_exists('wp_generate_attachment_metadata'))
		{
			require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/includes/media.php');
		}
		if ($_FILES)
		{
			foreach ($_FILES as $file => $array)
			{
				if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK)
				{
					return "upload error : " . $_FILES[$file]['error'];
				}
				$attach_id = media_handle_upload( $file, $pid );
			}
		}
		if ($attach_id > 0)
		{
			//and if you want to set that image as Post then use:
			update_post_meta($new_post, '_thumbnail_id', $attach_id);
		}

		$my_post1 = get_post($attach_id);
		$my_post2 = get_post($pid);
		$my_post = array_merge($my_post1, $my_post2);

	}
}
else
{
	echo "<h2 style='text-align:center;'>User must be login for add post!</h2>";
}
?>

