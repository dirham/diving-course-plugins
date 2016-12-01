<?php
function draf_course_list() {
		$current_user = wp_get_current_user();
		$user = $current_user->user_login;
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/draf-course/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Course Create By <?php echo $current_user->roles[0]. ' <u>'. $current_user->user_login.'</u>'; ?> </h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=draf_form_c_course'); ?>">Add New</a>
            </div>
            <br class="clear">
        </div>
        <?php
global $wpdb;
if(!isset($_POST['s-search'])){
$table_name = $wpdb->prefix . "register_pelajar";
$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$limit = 10; // number of rows in page
$offset = ( $pagenum - 1 ) * $limit;
$total = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE pengajar = '$current_user->user_login'" );

$num_of_pages = ceil( $total / $limit );
$entries = $wpdb->get_results( "SELECT * FROM wp_register_pelajar WHERE pengajar = '$current_user->user_login' LIMIT $offset, $limit" );
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

        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
								<th class="bgth manage-column ss-list-width">ID</th>
                <th class="bgth manage-column ss-list-width">Participan</th>
                <th class="bgth manage-column ss-list-width1">Participan email</th>
                <th class="bgth manage-column ss-list-width">Start date</th>
                <th class="bgth manage-column ss-list-width">Location</th>
                <th class="bgth manage-column ss-list-width1">Level</th>
                <th class="bgth manage-column ss-list-width">Action</th>
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
            <?php foreach ($entries as $row) { ?>
                <tr>
										<td class="manage-column ss-list-width"><?php echo $row->id; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->list_student_name; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->email_pelajar;?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->start_date;?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->location;?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->level;?></td>
                    <td><a href="<?php echo admin_url('admin.php?page=draf_course_update&id=' . $row->id); ?>">Update</a></td>
                </tr>
            <?php }
            echo "<b style='padding-right:10px;'>Total course so far is <u>{$total}</b></u>";
            echo "<form method ='POST'>";
            echo "<label for='search'>Search :</label>";
            echo "<input type='text' name='search' />";
            echo "<button class='button media-button elect-mode-toggle-button' name='s-search'>Search</button>";
            echo "</form>";
				}
			else{
				echo '<h3>Anda Belum Membuat <i>Course</i> !</h3>';
				}
}else{
$total = $wpdb->get_var( "SELECT COUNT(*) FROM wp_register_pelajar WHERE pengajar = '$current_user->user_login'" );

$entries = $wpdb->get_results( "SELECT * FROM wp_register_pelajar WHERE pengajar = '$current_user->user_login' AND email_pelajar  LIKE '%".$_POST['search']."%' OR level LIKE '%".$_POST['search']."%'" );
// print_r($entries);
?>
<table class='wp-list-table widefat fixed striped posts'>
            <tr>
              <th class="bgth manage-column ss-list-width">ID</th>
              <th class="bgth manage-column ss-list-width">Participan</th>
              <th class="bgth manage-column ss-list-width1">Participan email</th>
              <th class="bgth manage-column ss-list-width">Start date</th>
              <th class="bgth manage-column ss-list-width">Location</th>
              <th class="bgth manage-column ss-list-width1">Level</th>
              <th class="bgth manage-column ss-list-width">Action</th>
            </tr>
			<?php if(!empty($entries)){ ?>
            <?php foreach ($entries as $row) { ?>
                <tr>
                  <td class="manage-column ss-list-width"><?php echo $row->id; ?></td>
                  <td class="manage-column ss-list-width"><?php echo $row->list_student_name; ?></td>
                  <td class="manage-column ss-list-width"><?php echo $row->email_pelajar;?></td>
                  <td class="manage-column ss-list-width"><?php echo $row->start_date;?></td>
                  <td class="manage-column ss-list-width"><?php echo $row->location;?></td>
                  <td class="manage-column ss-list-width"><?php echo $row->level;?></td>
                  <td><a href="<?php echo admin_url('admin.php?page=draf_course_update&id=' . $row->id); ?>">Update</a></td>
                </tr>
            <?php }
            echo "<b style='padding-right:10px;'>Total course so far is <u>{$total}</b></u>";
            echo "<form method ='POST'>";
            echo "<label for='search'>Search :</label>";
            echo "<input type='text' name='search' />";
            echo "<button class='button media-button elect-mode-toggle-button' name='s-search'>Search</button>";
            echo "</form>";
				}
			else{
				echo '<h3>Anda Belum Membuat <i>Course</i> !</h3>';
				}
global $wp;
$url_part = add_query_arg(array(),$wp->request);
echo "</table>";
echo "<a href='$url_part'>Back</a>";
}
?>
        </table>

    </div>
    <?php
}
