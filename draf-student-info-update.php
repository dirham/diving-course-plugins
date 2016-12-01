<?php
function draf_student_info_update() {
    global $wpdb;
    $table_name = $wpdb->prefix . "registered_pelajar";
    $id = $_GET["id"];
    $name = $_POST["nameL"];
    $email_student =$_POST["email_studentL"];
    $level         = $_POST["level"];
    $key           = $_POST["key"];
      $uploadfiles = $_FILES['uploadfiles'];
    $current_user = wp_get_current_user();
    $from = wp_get_current_user();
    $fromEmail = $from->user_email;
    // $to = get_option( 'admin_email' );
    $pengajar = $from->user_login;

    $headers = "From: $pengajar <$fromEmail>" . "\r\n";
//update
    if (isset($_POST['update'])) {

    if (is_array($uploadfiles)) {

      foreach ($uploadfiles['name'] as $key => $value) {

      // cari file upload

        if ($uploadfiles['error'][$key] == 0) {

          $filetmp = $uploadfiles['tmp_name'][$key];

          //clean filename and extract extension
          $filename = $uploadfiles['name'][$key];

          // get file info
          // @fixme: wp checks the file extension....
          $filetype = wp_check_filetype( basename( $filename ), null );
          $filetitle = preg_replace('/\.[^.]+$/', '', basename( $filename ) );
          $filename = $filetitle . '.' . $filetype['ext'];
          $upload_dir = wp_upload_dir();
          $i = 0;
          while ( file_exists( $upload_dir['path'] .'/' . $filename ) ) {
            $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
            $i++;
          }
          $filedest = $upload_dir['path'] . '/' . $filename;

          if ( !is_writeable( $upload_dir['path'] ) ) {
            printf("Unable to write to directory %s. Is this directory writable by the server?",$upload_dir['path']);
            return;
          }

    /**
     * Save temporary file ke upload folder
     */
        if ( !@move_uploaded_file($filetmp, $filedest) ){
          sprintf("Error, the file %s could not moved to : %s ",$filetmp,$filedest );
          continue;
        }

        $attachment = array(
          'post_mime_type' => $filetype['type'],
          'post_title' => $filetitle,
          'post_content' => '',
          'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment( $attachment, $filedest );
        require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $filedest );
        wp_update_attachment_metadata( $attach_id,  $attach_data );

        // return $filedest;
      }
    }

// dapatkan seluruh inputan
$name    = sanitize_text_field( $_POST["f-name"] );
$emaile   = sanitize_text_field( $_POST["f-email"] );
$genre   = sanitize_text_field( $_POST["genre"] );
$country   = sanitize_text_field( $_POST["f-country"] );
$address = sanitize_text_field( $_POST["f-address"] );
$message = esc_textarea( $_POST["f-message"] );
$emailnya_pengajar = $_POST['f-pengajarmail'];
$key = $_POST["f-key_student"];
$currentPP = $_POST['idpp'];
if( empty($attach_id) ){
  $attach_id = $currentPP;
}
$update =  $wpdb->update(
          $table_name, //table
array('nama_pelajar' => $name, 'email_pelajar' => $emaile, 'jkel'=>$genre ,'negara'=>$country,'alamat'=>$address,'message'=>$message, 'email_pengajar'=>$emailnya_pengajar,'pengajar'=>$pengajar,'key_user_register'=>$key,'profil_picture_id'=>$attach_id), //data
          array('id' => $id)
  );
  if( $update ){
             echo 'Berhasil Merubah data';
  }else{
    echo "gagal";
    echo $emaile;
    echo $key;
    exit( var_dump( $wpdb->last_query ) );

  }

  }
    }
//delete
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %d", $id));
    } else {
        //ambil data untuk update SELECT * FROM wp_register_pelajar WHERE pengajar = '$current_user->user_login'

        $course = $wpdb->get_results($wpdb->prepare("SELECT id,nama_pelajar,email_pelajar,negara,alamat,message,email_pengajar,pengajar,key_user_register, profil_picture_id FROM $table_name WHERE pengajar = '$current_user->user_login' AND id=%d", $id));
        foreach ($course as $s) {
            $nama_pelajar = $s->nama_pelajar;
            $email_pelajar = $s->email_pelajar;
            $negara = $s->negara;
            $alamat = $s->alamat;
            $message = $s->message;
            $email_pengajar = $s->email_pengajar;
            $pengajar  = $s->pengajar;
            $key       = $s->key_user_register;
            $pp       = $s->profil_picture_id;
            // TODO: ambil data dan masukkan ke variable dan perbaiki form kemudiaan update
        }
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>../draf-course/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Registered student is deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=draf_course_list_view') ?>">&laquo; Back to course list</a>

        <?php } else if ($update) { ?>
            <div class="updated"><p>Success updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=draf_student_registered') ?>">&laquo; Back to course list</a>

        <?php } else { ?>
              <h3>Participan Form - Edit your information</h3>
              <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" >
              <p>
              Full Name : (required) <br/>
              <input type="text" name="f-name" value="<?php echo $nama_pelajar; ?>" size="40" />
              </p>
              <p>
              Your mail : (required) <br/>
              <input type="text" name="f-email" value="<?php echo $email_pelajar; ?>" size="40" />
              </p>
              <p>
                <input type="hidden" name="f-pengajarmail" value="<?php echo $email_pengajar; ?>">
              Genre :
              <select name="genre">
                      <option value="male">Male</option>
                      <option value="famale">Famale</option>
                  </select>
              </p>
              <p>
              Address (required) <br/>
              <input type="text" name="f-address" value="<?php echo $alamat; ?>" size="40" />
              </p>
              <p>
              <p>
              Country (required) <br/>
              <input type="text" name="f-country" value="<?php echo $negara; ?>" size="40" />
              </p>
              <input type="hidden" name="f-key_student" value="<?php echo $key; ?>" size="40" />
              <p>
              Enter Dive Motto (the reason why) <br/>
              <textarea rows="10" cols="35" name="f-message"><?php echo $message; ?></textarea>
              </p>
              Chosee Profile Picture (this will use in you certificate) <br>
              <input type="file" name="uploadfiles[]" id="uploadfiles" size="125" class="uploadfiles" /><br>
              <input type="hidden" name="idpp" value="<?php echo $pp; ?>">
                <input type='submit' name="update" value='Save' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('Yakin... ingin hapus ?')">
            </form>
        <?php } ?>

    </div>
    <?php
}
