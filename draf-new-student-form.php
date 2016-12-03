<?php

function form_student_form_course() {
	global $wpdb;
	$country = $wpdb->get_results("SELECT name FROM ".$wpdb->prefix."country");
	echo "<h3>Participan Form - Fill your information</h3>";
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post" enctype="multipart/form-data" id="formtlp" >';
	echo '<p>';
	echo 'Full Name : (required) <br/>';
	echo '<input type="text" name="f-name" required="" value="' . ( isset( $_POST["f-name"] ) ? esc_attr( $_POST["f-name"] ) : '' ) . '" size="32" />';
	echo '</p>';
	echo '<p>';
	echo 'Your mail : (required) <br/>';
	echo '<input type="text" name="f-email" required="" value="' . ( isset( $_POST["f-email"] ) ? esc_attr( $_POST["f-email"] ) : '' ) . '" size="32" />';
	echo '</p>';
  echo '<p>';
  echo 'Phone Number : (required) <br/>';
  echo '<input type="text" required="" name="f-phone" id="f-phone" value="' . ( isset( $_POST["f-phone"] ) ? esc_attr( $_POST["f-phone"] ) : '' ) . '" size="32" />';
  echo '</p>';
	echo '<p>';
	echo 'Genre :';
	echo '<select name="genre">
				  <option value="Male">Male</option>
				  <option value="Female">Female</option>
		  </select>';
	echo '</p>';
	echo '<p>';
	echo 'Address (required) <br/>';
	echo '<input type="text" required="" name="f-address" value="' . ( isset( $_POST["f-address"] ) ? esc_attr( $_POST["f-address"] ) : '' ) . '" size="32" />';
	echo '</p>';
	echo '<p>';
	echo 'City : (Required) <br/>';
	echo '<input type="text" name="f-city" required="" value="' . ( isset( $_POST["f-city"] ) ? esc_attr( $_POST["f-city"] ) : '' ) . '" size="32" />';
	echo '</p>';
	echo '<p>';
	echo 'Country (required) <br/>';
	echo '<select id="f-country" name="f-country"><option value="none">Your Country</country>';
	foreach ($country as $countrys) {
	echo '<option value="'.$countrys->name.'">'.$countrys->name.'</option>';
	}
	echo "</select>";
	echo '</p>';
	echo '<p>';
	echo '<p>';
	echo 'Key from email (insert the whcich you see in your email , very key important) <br/>';
	echo '<input type="text" name="f-key_student" required="" value="' . ( isset( $_POST["f-key_student"] ) ? esc_attr( $_POST["f-key_student"] ) : '' ) . '" size="32" />';
	echo '</p>';
	echo '<p>';
	echo 'Enter Dive Motto (the reason why) <br/>';
	echo '<textarea rows="10" required="" cols="30" name="f-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
	echo '</p>';
	echo "Chosee Profile Picture (this will use in you certificate) <br>";
  echo '<input type="file" name="uploadfiles[]" id="uploadfiles" size="32" class="uploadfiles" />
        <!-- <input type="file" name="f-student_pp" id="f-student_pp"  multiple="false" /> -->
        ';
	echo '<p><input type="submit" id="btn" onClick="return validasi()" name="f-submitted" value="Send"></p>';
	echo '</form>';

  ?>

      <script>
      function validasi(){
				var nomor_hp=document.getElementById("f-phone").value;
        var cnt=document.getElementById("f-country").value;
        // var number=/^[0-9]+$/;
				var number = /(082|082|085|087|089)\d{9}/;
        if (nomor_hp==null || nomor_hp==""){
          alert("Nomor Handphone tidak boleh kosong !");
          return false;
        };

        if (!nomor_hp.match(number) && nomor_hp.length < 11 && nomor_hp > 13){
          alert("Nomor Handphone Tidak sesuai format !");
          return false;
        };
				//
        if (cnt=='none'){
          alert("Hey men choose your country please");
          return false;
        };
     }
      </script>
  <?php
}

function save_student_info() {
	// if the submit button is clicked, send the email
	if ( isset( $_POST['f-submitted'] ) ) {
  $student_key = $_POST['f-key_student'];
  global $wpdb;

  //pengecekan email dan key dari pendaftar

  $valid_key = $wpdb->get_results("select email_pelajar from ".$wpdb->prefix."register_pelajar WHERE key_user_register = '$student_key'");

  	//pasang penanganan inputan foto

  $uploadfiles = $_FILES['uploadfiles'];
    if( is_array( $valid_key ) ){
        $pelajar_email = $valid_key[0]->email_pelajar;
        $get_pelajar_mail = explode(",", $pelajar_email);
        // print_r($get_pelajar_mail);
        $clean_pelajar_mail = array_map("trim", $get_pelajar_mail);
        // print_r($clean_pelajar_mail);
          if ( in_array(sanitize_text_field( $_POST["f-email"] ), $clean_pelajar_mail)){

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

        /**
         * perikasa nama file di folder upload jika ada rename
         * file jika diperlukan
         */
              $i = 0;
              while ( file_exists( $upload_dir['path'] .'/' . $filename ) ) {
                $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
                $i++;
              }
              $filedest = $upload_dir['path'] . '/' . $filename;

        /**
         * periksa apakah folder yang dituju dapat di tulisi
         */
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
    $email   = sanitize_text_field( $_POST["f-email"] );
    $phone   = sanitize_text_field( $_POST["f-phone"] );
		$genre   = sanitize_text_field( $_POST["genre"] );
    $city    = sanitize_text_field( $_POST["f-city"] );
    $country = sanitize_text_field( $_POST["f-country"] );
    $address = sanitize_text_field( $_POST["f-address"] );
    $message = esc_textarea( $_POST["f-message"] );
    // get the blog current user's email addressthe blog current user's email address
    $from = wp_get_current_user();
    $fromEmail = $from->user_email;
    // $to = get_option( 'admin_email' );
    $pengajar = $from->user_login;
    $subject = "Sukses melengkapi pendaftaran";
    $headers = "From: $pengajar <$fromEmail>" . "\r\n";
    $isi_pesan = "Terimakasih telah melengkapi pendaftaran sebagai siswa kursus kami, silahkan tunggu atau hubungi mentor terkait jadwal kursus dan lain - lain pada email berikut : $fromEmail ";

		// check country not none
		if($city == 'none'){
		echo	'<div class="notice notice-success is-dismissible">
				        <p>Please choose your country</p>
				    </div>';
		}else{
	    $insert = $wpdb->insert($wpdb->prefix.'registered_pelajar', array('id'=>'', 'nama_pelajar'=>$name,'email_pelajar'=>$email,'phone'=>$phone,'jkel'=>$genre,'city'=>$city,'negara'=>$country,'alamat'=>$address,'message'=>$message,'email_pengajar'=>$fromEmail, 'pengajar'=>$pengajar,'key_user_register'=>$student_key, 'profil_picture_id'=>$attach_id ), array('%d', '%s', '%s', '%s','%s','%s','%s','%s','%s','%s', '%s','%d'));
		}
      // jika berhasil melakukan penyimpanan data maka lakukan pengiriman email
      if($insert){
        echo '<div>';
        echo '<p>Data telah tersimpan</p>';
        echo '</div>';
          // cek pengiriman email
         if ( wp_mail( $email, $subject, $isi_pesan, $headers ) ) {
           echo '<div>';
           echo '<p>Kami telah mengirimkan email ke pesan anda</p>';
           echo '</div>';

          $dubject_to_instruktor = $name." baru saja melengkapi pendaftaran online";
          $isi_pesan_to_instruktor = "Hai, kami baru saja menerima data dari salah satu peserta course anda dengan nama ".$nama." Terimakasih";
          // jika berhasil melakukan pengiriman email ke pejar maka kirim juga email kepada instruktor
          if( wp_mail( $fromEmail, $dubject_to_instruktor, $isi_pesan_to_instruktor, $headers )){
           echo '<div>';
           echo '<p>Kami telah mengirimkan email ke instruktor '.$fromEmail.'</p>';
           echo '</div>';
          }
          // munculkan pesan kesalahan
          } else {
           echo 'Maaf, Terjadi kesalahan silahkan coba lagi';
          }

      }

       if($wpdb->last_error !== '') :

              $str   = htmlspecialchars( $wpdb->last_result, ENT_QUOTES );
              $query = htmlspecialchars( $wpdb->last_query, ENT_QUOTES );

              print "<div id='error'>
              <p class='wpdberror'><strong>WordPress database error:</strong> [$str]<br />
              <code>$query</code></p>
              </div>";

        endif;
      }
    }

    }

  }

}

//test function
function student_call(){

form_student_form_course();
save_student_info();

}

// panggil pengontroll file upload wp
require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );
?>
