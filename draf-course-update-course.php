<?php
function draf_course_update_course() {
    global $wpdb;
    $table_name     = $wpdb->prefix . "register_pelajar";
    $id             = $_GET["id"];
    $name           = $_POST["nameL"];
    $email_student  =$_POST["email_studentL"];
    $level          = $_POST["level"];
    $key            = $_POST["key"];
    $date            = $_POST["startdate"];
    $loc            = $_POST["location"];
    $current_user   = wp_get_current_user();
    $from           = wp_get_current_user();
    $pengajar       = $from->user_login;
    $fromEmail      = $from->user_email;
    $subject        = "Perubahan Data Kusrus";
    $message        = "Email Ini dirikim dikarenakan terjadi perubahan pada data kursus. <br>
                       jika anda melengkapi pendaftaran sebelumnya maka abaikan saja email ini, jika belum maka silahkan klik link yang tertera dibawah ini : <br>
                       <h4>Data terbaru : </h4><br>
                       <p>Daftar Nama peserta : ".$name."<br>Daftar <b>Email </b>: ".$email_student."<br>Waktu Mulai (start date) : ".$date."
                       Lokasi pelaksanaan (location) : ".$loc."<br>
                       Sekian info perubahan pada daftar data kursus. silahkan hubungi Mentor <b><i>".$pengajar."<i> email : ".$fromEmail."</b></p>";
    $keysend        = "click this link ".'<a href="http://localhost/dive/wp-admin/admin.php?page=draf_student_registered">this</a>'." and paste the key (bold) into the key form <b><h3>".$key." <-- this is the key </h3></b>";
    $text           = $message.''.$keysend;
    $headers        = "From: $pengajar <$fromEmail>" . "\r\n";


//update
    if (isset($_POST['update'])) {
      $update =  $wpdb->update(
                $table_name, //table
                array('list_student_name' => $name, 'email_pelajar'=>$email_student, 'start_date'=>$date, 'location'=>$loc, 'level'=>$level,), //data
                array('id' => $id), //where
                array('%s', '%s', '%s', '%s'), //data format
                array('%d') //where format
        );
        if( $update ){
          add_filter( 'wp_mail_content_type', 'set_html_content_type' );
          if ( wp_mail( $email_student, $subject, $text, $headers ) ) {
  					echo '<div>';
  					echo '<p>Terimakasih, kami telah mengirim email kesetiap participan</p>';
  					echo '</div>';
  					remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
  					} else {
  			           echo 'An unexpected error occurred';
  			        }
        }

    }
//delete
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));
    } else {
        //ambil data untuk update SELECT * FROM wp_register_pelajar WHERE pengajar = '$current_user->user_login'

        $course = $wpdb->get_results($wpdb->prepare("SELECT id,list_student_name,email_pelajar,start_date,location,level,email_pengajar,key_user_register,pengajar from $table_name WHERE pengajar = '$current_user->user_login' AND id=%d", $id));
        foreach ($course as $s) {
            $name_list = $s->list_student_name;
            $mail_list = $s->email_pelajar;
            $level     = $s->level;
            $email_pengajar = $s->email_pengajar;
            $pengajar  = $s->pengajar;
            $start_date  = $s->start_date;
            $location  = $s->location;
            $key       = $s->key_user_register;
        }
    }
    ?>
    <style>
      td{
        padding-left: 40px !important;
      }
    </style>
    <div class="wrap">
        <h2>Edit your course - (<?php echo $pengajar; ?>)</h2>
        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Course deleted</p></div>
            <a href="javascript:history.go(-1)">&laquo; Back</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>Course updated</p></div>
            <a href="javascript:history.go(-1)">&laquo; Back</a>

        <?php } else { ?>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
              <?php // FIXME: perbaiki form ini sesuaikan dengan database ?>
                <table>
                  <tr><th>Participan</th><td style="text-align:left;"><input type="text" name="nameL" value="<?php echo $name_list; ?>"/></td></tr>
                  <tr><th>Start Date</th><td style="text-align:left;"><input type="text" name="startdate" value="<?php echo $start_date; ?>"/></td></tr>
                    <tr><th>Location</th><td style="text-align:left;"><input type="date" name="location" value="<?php echo $location; ?>"/></td></tr>
					          <tr><th>Parisipan Mail </th><td style="text-align:left;"><textarea rows="3" name="email_studentL" cols="18"><?php echo $mail_list; ?></textarea></td></tr>
                    <tr><th>Level</th><td style="text-align:left;"><input readonly type="text" name="level" value="<?php echo $level; ?>"/></td></tr>
                    <input type="hidden" name="key" value="<?php echo $key; ?>">
                </table>
                <input type='submit' name="update" value='Save' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('Yakin... ingin hapus ?')">
            </form>
        <?php } ?>

    </div>
    <?php
}
