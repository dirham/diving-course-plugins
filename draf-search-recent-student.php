<?php

function draf_course_result_complit() {
		$current_user = wp_get_current_user();
		$user = $current_user->user_login;
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/draf-course/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Student alredy take a  <u>Course</u></h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=draf_form_c_course'); ?>">Add New Course</a>
            </div>
            <br class="clear">
        </div>
        <?php
global $wpdb;
if(!isset($_POST['s-search'])){
$table_name = $wpdb->prefix . "register_pelajar";
$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$limit = 5; // number of rows in page
$offset = ( $pagenum - 1 ) * $limit;
$sql_count = "SELECT COUNT(*) FROM ".$wpdb->prefix."exam_poin JOIN complyted_exam ON complyted_exam.id = ".$wpdb->prefix."exam_poin.exam_id JOIN ".$wpdb->prefix."registered_pelajar ON ".$wpdb->prefix."registered_pelajar.id = ".$wpdb->prefix."exam_poin.participan_id";
$total = $wpdb->get_var( $sql_count );

$num_of_pages = ceil( $total / $limit );
$sql_oke = "SELECT ".$wpdb->prefix."registered_pelajar.nama_pelajar, ".$wpdb->prefix."registered_pelajar.alamat, ".$wpdb->prefix."registered_pelajar.jkel , ".$wpdb->prefix."registered_pelajar.negara, ".$wpdb->prefix."registered_pelajar.email_pengajar, ".$wpdb->prefix."registered_pelajar.email_pelajar, complyted_exam.exam_name, CASE ".$wpdb->prefix."exam_poin.status WHEN 0 THEN 'FAILED' WHEN 1 THEN 'PASS' END AS Status FROM ".$wpdb->prefix."exam_poin JOIN complyted_exam ON complyted_exam.id = ".$wpdb->prefix."exam_poin.exam_id JOIN ".$wpdb->prefix."registered_pelajar
ON ".$wpdb->prefix."registered_pelajar.id = ".$wpdb->prefix."exam_poin.participan_id ORDER BY ".$wpdb->prefix."registered_pelajar.id LIMIT $offset, $limit";
$entries = $wpdb->get_results( $sql_oke );
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
								<th class="bgth manage-column ss-list-width">Participan</th>
                <th class="bgth manage-column ss-list-width">Alamat</th>
                <th class="bgth manage-column ss-list-width">Jeneis Kelamin</th>
                <th class="bgth manage-column ss-list-width1">Participan email</th>
                <th class="bgth manage-column ss-list-width1">Intructor email</th>
                <th class="bgth manage-column ss-list-width1">Negara</th>
                <th class="bgth manage-column ss-list-width1">Exam Name</th>
                <th class="bgth manage-column ss-list-width1">Status</th>
                <!-- <th class="bgth manage-column ss-list-width">Action</th> -->
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
										<td class="manage-column ss-list-width"><?php echo $row->nama_pelajar; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->alamat; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->jkel;?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->email_pelajar;?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->email_pengajar;?></td>
                    <td class="manage-column"><?php echo $row->negara;?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->exam_name;?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->Status;?></td>
                    <!-- <td><a href="<?php  // echo admin_url('admin.php?page=draf_course_update&id=' . $row->id); ?>">Update</a></td> -->
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
$total = $wpdb->get_var( $sql_count );
$sql_search = "SELECT wp_registered_pelajar.nama_pelajar, wp_registered_pelajar.alamat, wp_registered_pelajar.jkel , wp_registered_pelajar.negara, wp_registered_pelajar.email_pengajar,wp_registered_pelajar.email_pelajar, complyted_exam.exam_name,
CASE wp_exam_poin.status
       WHEN 0 THEN 'FAILED'
       WHEN 1 THEN 'PASS'
       END AS Status
FROM wp_exam_poin
JOIN complyted_exam ON complyted_exam.id = wp_exam_poin.exam_id
JOIN wp_registered_pelajar ON wp_registered_pelajar.id = wp_exam_poin.participan_id
WHERE wp_registered_pelajar.nama_pelajar LIKE '%".$_POST['search']."%' OR wp_registered_pelajar.email_pelajar LIKE '%".$_POST['search']."%'";
$entries = $wpdb->get_results( $sql_search );
// print_r($entries);
?>
<table class='wp-list-table widefat fixed striped posts'>
            <tr>
              <th class="bgth manage-column ss-list-width">Participan</th>
              <th class="bgth manage-column ss-list-width">Alamat</th>
              <th class="bgth manage-column ss-list-width">Jeneis Kelamin</th>
              <th class="bgth manage-column ss-list-width1">Participan email</th>
              <th class="bgth manage-column ss-list-width1">Instructor email</th>
              <th class="bgth manage-column ss-list-width1">Negara</th>
              <th class="bgth manage-column ss-list-width1">Exam Name</th>
              <th class="bgth manage-column ss-list-width1">Status</th>
              <!-- <th class="bgth manage-column ss-list-width">Action</th> -->
            </tr>
			<?php if(!empty($entries)){ ?>
            <?php foreach ($entries as $row) { ?>
                <tr>
                  <td class="manage-column ss-list-width"><?php echo $row->nama_pelajar; ?></td>
                  <td class="manage-column ss-list-width"><?php echo $row->alamat; ?></td>
                  <td class="manage-column ss-list-width"><?php echo $row->jkel;?></td>
                  <td class="manage-column ss-list-width"><?php echo $row->email_pelajar;?></td>
                  <td class="manage-column ss-list-width"><?php echo $row->email_pengajar;?></td>
                  <td class="manage-column ss-list-width"><?php echo $row->negara;?></td>
                  <td class="manage-column ss-list-width"><?php echo $row->exam_name;?></td>
                  <td class="manage-column ss-list-width"><?php echo $row->Status;?></td>
                  <!-- <td><a href="<?php //echo admin_url('admin.php?page=draf_course_update&id=' . $row->id); ?>">Update</a></td> -->
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
