<style>
.table > tbody > tr > td {
     vertical-align: middle;
}
td{
	 text-align: center;
	 padding-top: 5px !important;
	 padding-left: 2px !important;
	 padding-right: 2px !important;
	 padding-bottom: 5px !important;
}
th{
	text-align: center !important;
}
</style>
<?php

function draf_registered_student() {
		$current_user = wp_get_current_user();
		$user = $current_user->user_login;
    ?>
    <!-- <link type="text/css" href="<?php //echo WP_PLUGIN_URL; ?>/draf-course/style-admin.css" rel="stylesheet" /> -->
			<link type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
		<div class="wrap">
        <h2>Registered Student Mentoring By <?php echo $current_user->roles[0]. ' <u>'. $current_user->user_login.'</u>'; ?> </h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=draf_course_create'); ?>">Add New</a>
            </div>
            <br class="clear">
        </div>
        <?php
global $wpdb;
if(!isset($_POST['s-search'])){
$table_name = $wpdb->prefix . "registered_pelajar";
$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$limit = 10; // number of rows in page
$offset = ( $pagenum - 1 ) * $limit;
$total = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE pengajar = '$current_user->user_login'" );

$num_of_pages = ceil( $total / $limit );
$entries = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."registered_pelajar WHERE pengajar = '$current_user->user_login' LIMIT $offset, $limit" );
    $page_links = paginate_links( array(
    'base' => add_query_arg( 'pagenum', '%#%' ),
    'format' => '',
    'prev_text' => __( '&laquo;', 'text-domain' ),
    'next_text' => __( '&raquo;', 'text-domain' ),
    'total' => $num_of_pages,
    'current' => $pagenum
) );
// echo "apsih";
// print_r($num_of_pages);
    if ( $page_links ) {
    echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
	}
?>

        <table class='tabel table-bordered table-striped' style='align:center;'>
            <tr>
                <th class="alert alert-success">ID</th>
                <th class="alert alert-success">Nama Pelajar</th>
                <th class="alert alert-success">Student email</th>
                <th class="alert alert-success">Jenis Kelamin</th>
                <th class="alert alert-success">Negara</th>
                <th class="alert alert-success">Alamat</th>
                <th class="alert alert-success">Instruktor</th>
                <th class="alert alert-success">Picture</th>
                <th class="alert alert-success" colspan="2" align="center">Action</th>
            </tr>
           <?php
           if($wpdb->last_error !== '') :

        $str   = htmlspecialchars( $wpdb->last_result, ENT_QUOTES );
        $query = htmlspecialchars( $wpdb->last_query, ENT_QUOTES );

        print "<div id='error'>
        <p class='wpdberror'><strong>WordPress database error:</strong> [$str]<br />
        <code>$query</code></p>
        </div>";

    endif;
    ?>

			<?php if(!empty($entries)){ ?>
            <?php $imgp =0; ?>
            <?php foreach ($entries as $row) { ?>
                <tr>
									<td><?php echo $row->id; ?><input type="checkbox" name="exm[]" class="exm" value="<?php echo $row->id; ?>"></td>
                    <td><?php echo $row->nama_pelajar;?></td>
                    <td><?php echo $row->email_pelajar;?></td>
                    <td><?php echo $row->jkel;?></td>
                    <td><?php echo $row->negara;?></td>
                    <td><?php echo $row->alamat;?></td>
                    <td><?php echo $row->pengajar;?></td>
                    <?php $image_pic = wp_get_attachment_image_src( $row->profil_picture_id ); ?>
                    <td>
                    <a href="<?php echo $image_pic[0]; ?>" rel="lightbox" data-lightbox="image<?php echo $imgp; ?>" data-title="My caption"><img src="<?php echo $image_pic[0]; ?>" widht="50" height="50" ></a>
                    </td>
                    <td><a href="<?php echo admin_url('admin.php?page=draf_student_info_update&id=' . $row->id); ?>">Update</a></td>
										<td><a href="<?php echo admin_url('admin.php?page=draf_exam_pointing&id=' . $row->id); ?>">Single Pointing</a></td>
                </tr>
            <?php }
            echo "<b style='padding-right:10px;'>Total registered user information : <u>{$total}</b></u>";
            echo "<form method ='POST'>";
            echo "<label for='search'>Search by name or email :</label>";
            echo "<input type='text' name='search' />";
            echo "<button class='button media-button elect-mode-toggle-button' name='s-search'>Search</button>";
            echo "</form>";
				}
			else{
				echo '<h3>Belum ada pelajar yang melengkapi data <i>Course</i> !</h3>';
				}
}else{
$total = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix."registered_pelajar WHERE pengajar = '$current_user->user_login'" );

$entries = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."registered_pelajar WHERE pengajar = '$current_user->user_login' AND email_pelajar LIKE '%".$_POST['search']."%' OR nama_pelajar LIKE '%".$_POST['search']."%'" );
// print_r($entries);
?>
<table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="bgth manage-column ss-list-width">ID</th>
                <th class="bgth manage-column ss-list-width1">Nama Pelajar</th>
                <th class="bgth manage-column ss-list-width1">Student email</th>
                <th class="bgth manage-column ss-list-width1">Jenis Kelamin</th>
                <th class="bgth manage-column ss-list-width1">Negara</th>
                <th class="bgth manage-column ss-list-width1">Alamat</th>
                <th class="bgth manage-column ss-list-width1">Instruktor</th>
                <th class="bgth manage-column ss-list-width1">Picture</th>
                <th class="bgth manage-column ss-list-width" colspan="2" align="center">Action</th>
            </tr>
			<?php if(!empty($entries)){ ?>
            <?php foreach ($entries as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->id; ?><input type="checkbox" name="exm[]" class="exm" value="<?php echo $row->id; ?>"></td>
                    <td class="manage-column ss-list-width"><?php echo $row->nama_pelajar;?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->email_pelajar;?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->jkel;?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->negara;?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->alamat;?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->pengajar;?></td>
                    <?php $image_pic = wp_get_attachment_image_src( $row->profil_picture_id ); ?>
                    <td class="manage-column ss-list-width">
                    <a href="<?php echo $image_pic[0]; ?>" rel="lightbox" data-lightbox="image<?php echo $imgp; ?>" data-title="My caption"><img src="<?php echo $image_pic[0]; ?>" widht="50" height="50" ></a>
                    </td>
										<td><a href="<?php echo admin_url('admin.php?page=draf_student_info_update&id=' . $row->id); ?>">Update</a></td>
                    <td><a href="<?php echo admin_url('admin.php?page=draf_exam_pointing&id=' . $row->id); ?>">Single Pointing</a></td>
                </tr>
            <?php }
            echo "<b style='padding-right:10px;'>Total Pendaftar yang telah melengkapi data sejauh inI : <u>{$total}</b></u>";
            echo "<form method ='POST'>";
            echo "<label for='search'>Search :</label>";
            echo "<input type='text' name='search' />";
            echo "<button class='button media-button elect-mode-toggle-button' name='s-search'>Search</button>";
            echo "</form>";
				}
			else{
				echo '<h3>Belum ada data terkait pencarian <i>'.$_POST["search"].'</i> !</h3>';
				}
global $wp;
$url_part = add_query_arg(array(),$wp->request);
echo "</table>";
echo "<a href='$url_part'>Back</a>";
}
?>

        </table>
				<div class="p" ></div>
				<p></p>
				<input id="test" class="btn btn-primary" type=button value="Multi Checked" />
				<script type="text/javascript">
				(function($) {
					$("#test").click(function(event) {
						var availTuesday = [];
										$("input[type=checkbox][name='exm[]']:checked").each(function() {
											 availTuesday.push($(this).val());
										});
								//alert(availTuesday);
						// $.each(availTuesday, function(key,val){
						// 	var to_url = val+"&";
						// 	console.log(to_url);
						// });
						var htmlStr = "Klik link to multiple Student Exam ";
						var url = "<?php echo admin_url('admin.php?page=draf_exam_pointing&multiID='); ?>";
						htmlStr += "<a href="+url+availTuesday+">Link</a>";
								// htmlStr += "<a href='http://to&id="+availTuesday+"'>another paragaraph</p>";
								$(".p").html(htmlStr);
								});

				})(jQuery);

				</script>
    </div>

<div id="txtAge" ></div>
    <?php
}

function light_load_js(){
    // wp_enqueue_script( 'light_js', plugins_url( 'lightbox/lightbox.min.js', __FILE__ ));
    // wp_enqueue_script( 'light_js', plugins_url( 'lightbox/lightbox-plus-jquery.js', __FILE__ ));
    // wp_enqueue_style('lidht_css', plugins_url( 'lightbox/lightbox.css', __FILE__ ));
		    wp_enqueue_script('jquery');

}
add_action('admin_enqueue_scripts', 'light_load_js');
add_action( 'wp_default_scripts', function( $scripts ) {
    if ( ! empty( $scripts->registered['jquery'] ) ) {
        $jquery_dependencies = $scripts->registered['jquery']->deps;
        $scripts->registered['jquery']->deps = array_diff( $jquery_dependencies, array( 'jquery-migrate' ) );
    }
} );
