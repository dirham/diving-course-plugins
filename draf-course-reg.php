<?php

function randkey($length){
	//    karakter yang bisa dipakai sebagai key
    $string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    $len = strlen($string);

	//    mengenerate key
    for($i=1;$i<=$length; $i++){
        $start = rand(0, $len);
        $key .= substr($string, $start, 1);
    }

    return $key;
}

function form_daftar_course() {
  ?>
  <style>
    td{
      text-align: left !important;
    }
    th{
      text-align: left !important;
    }
  </style>
  <h3 style="padding-left:300px;">Create a new course</h3>
  <?php
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
	echo '<table>';
	echo '<tr><th>Instructor Name</th>';
  echo '<th>:</th>';
	echo '<td><input type="text" name="name-cd" value="' . ( isset( $_POST["name-cd"] ) ? esc_attr( $_POST["name-cd"] ) : '' ) . '" size="40" /> <span>(*required)</span></td></tr>';
	echo '<tr><th>Participan Name</th>';
  echo '<th>:</th>';
	echo '<td><input type="text" name="nameList" value="' . ( isset( $_POST["nameList"] ) ? esc_attr( $_POST["nameList"] ) : '' ) . '" size="40" /> <span>(required, ex : name1,name2,etc)</span></td></tr>';
  echo '<tr><th>Email of student</th>';
  echo '<th>:</th>';
	echo '<td><input type="text" name="email" value="' . ( isset( $_POST["email"] ) ?  $_POST["email"] : '' ) . '" size="40" /> <span>(required, ex : student@mail.com, student1@mail.com)</span></td></tr>';
  echo '<tr><th>Start date</th>';
  echo '<th>:</th>';
  echo '<td><input type="text" required="" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" name="start_date" value="' . ( isset( $_POST["start_date"] ) ?  $_POST["start_date"] : '' ) . '" size="40" /> <span>(Year-Month-Date)</span></td></tr>';
  echo '<tr><th>Select Level</th>';
  echo '<th>:</th>';
	echo '<td><select name="level">
          <option value="none">Select Level</option>
				  <option value="IFA1">IFA 1</option>
				  <option value="IFA2">IFA 2</option>
				  <option value="IFA3">IFA 3</option>
				  <option value="IFA4">IFA 4</option>
				</select></td></tr>';
  echo '<tr><th>Location</th>';
  echo '<th>:</th>';
  echo '<td><input type="text" name="location" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["location"] ) ?  $_POST["location"] : '' ) . '" size="40" /></td></tr>';
  echo '<tr><th>Subject</th>';
  echo '<th>:</th>';
	echo '<td><input type="text" name="subject" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["subject"] ) ? esc_attr( $_POST["subject"] ) : '' ) . '" size="40" /><span>(* required) </span></td></tr>';
  echo '<tr><th>Enter your message</th>';
  echo '<th>:</th>';
	echo '<td><textarea rows="10" cols="38" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea><span>(details for student)</span></td></tr>';
  echo "</table>";
	echo '<p style="margin-left: 497px;"><input type="submit" name="submitted" value="Send"></p>';
	echo '</form>';

}

function email_dan_simpan() {
		//membuat key ke student untuk kebutuhan registrasi student

		$key = randkey(11);

	// if the submit button is clicked, send the email
	if ( isset( $_POST['submitted'] ) ) {

		// sanitize form values
		$name    = sanitize_text_field( $_POST["name-cd"] );
		$studentnameList    = sanitize_text_field( $_POST["nameList"] );
    $email   =  $_POST["email"];
    $location   =  $_POST["location"];
		$start_date   =  $_POST["start_date"];
		$subject = sanitize_text_field( $_POST["subject"] );
		$message = esc_textarea( $_POST["cf-message"] );
		// $keysend = "klick this link ".'<a href="http://localhost/dive/wp-admin/admin.php?page=draf_student_registered">this</a>'." and paste the key (bold) into the key form <b><h3>".$key." <-- this is the key </h3></b>";
		// $text = $message.''.$keysend;

    // create mail template
      $sendText = '<html><body>';
      $sendText .= '<div marginwidth="0" marginheight="0">';
      $sendText .= '<div style="background-color:rgb(245,245,245);margin:0px;padding:70px 0px;width:100%">';
      $sendText .= '<table height="100%" border="0" cellpadding="0" cellspacing="0" width="100%">';
      $sendText .= '<tbody><tr><td align="center" valign="top">';
      $sendText .= '<table style="background-color:#fff;border:1px solid rgb(220,220,220);border-radius:3px!important" border="0" cellpadding="0" cellspacing="0" width="600">';
      $sendText .='<tbody><tr><td align="center" valign="top">';
      $sendText .='<table style="background-color:#fff;border-radius:3px 3px 0px 0px!important;color:rgb(255,255,255);border-bottom:1px inset #afc5dc;margin-top:10px;font-weight:bold;line-height:100%;vertical-align:middle;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif" border="0" cellpadding="0" cellspacing="0" width="500"><tbody><tr>';
      $sendText .='<td align="center"><h1 style="font-size:18px;color:rgb(115,115,115)">Diving Registration</h1></td>';
      $sendText .= '</tr></tbody></table></td></tr>';
      $sendText .= '<tr><td align="center" valign="top">';
      $sendText .= '<table border="0" cellpadding="0" cellspacing="0" width="600"><tbody><tr>';
      $sendText .= '<td style="background-color:#fff" valign="top">';
      $sendText .= '<table border="0" cellpadding="20" cellspacing="0" width="100%"><tbody><tr>';
      $sendText .= '<td style="padding:48px" valign="top">';
      $sendText .= '<div style="color:rgb(115,115,115);font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left">';
      $sendText .= '<h1 style="margin:0px 0px 16px; font-size:18px">Registrasi anda hampir selesai,</h1>';
      $sendText .= '<p style="margin:0px 0px 16px">Klik link aktivasi dan masukkan key registrasi anda</p>';
      $sendText .= '<table style="width:100%;border:1px solid rgb(238,238,238)" border="1" cellpadding="6" cellspacing="0">';
      $sendText .= '<thead><tr>';
      $sendText .= '<th scope="col" style="text-align:left;border:1px solid rgb(238,238,238);padding:12px">Keterangan</th>';
      $sendText .= '<th scope="col" style="text-align:left;border:1px solid rgb(238,238,238);padding:12px">Key Registrasi</th>';
      $sendText .= '</tr></thead><tbody><tr>';
      $sendText .= '<td style="text-align:left;vertical-align:middle;border:1px solid rgb(238,238,238);word-wrap:break-word;padding:12px">' .$message. '</td>';
      $sendText .= '<td style="text-align:left;vertical-align:middle;border:1px solid rgb(238,238,238);padding:12px">' .$key. '</td>';
      $sendText .= '</tr></tbody><tfoot>';
      $sendText .= '<tr><th scope="row" colspan="3" style="text-align:left;border-width:4px 1px 1px;border-style:solid;border-color:rgb(238,238,238);padding:12px">Link Aktivasi: <br><span style="font-weight:normal"><a href="http://localhost/dive/wp-admin/admin.php?page=draf_student_registered">Klik disini</a></span></th></tr>';
      $sendText .= '</tfoot></table>';
      $sendText .= '</td></tr>';
      $sendText .= '<tr><td align="center" valign="top"><table border="0" cellpadding="10" cellspacing="0" width="600"><tbody><tr>';
      $sendText .= '<td style="padding:0px" valign="top"><table border="0" cellpadding="10" cellspacing="0" width="100%"><tbody></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></div></div>';
      $sendText .= "</body></html>";
		// get the blog current user's email address
    // TODO: rubaha isi dari sendText masukkan key yang benar diatas
		$from = wp_get_current_user();
		$fromEmail = $from->user_email;
		// $to = get_option( 'admin_email' );
		$pengajar = $from->user_login;

		$headers = "From: $name <$fromEmail>" . "\r\n";
    // $headers .= "MIME-Version: 1.0\r\n";
    // $headers .= "Content-Type: text/html; charset=utf-8\r\n";


// echo $pengajar;
		add_filter( 'wp_mail_content_type', 'set_html_content_type' );
		global $wpdb;
		$insert = $wpdb->insert('wp_register_pelajar', array('id'=>'','list_student_name'=>$studentnameList,'email_pelajar'=>$email, 'start_date'=>$start_date,'location'=>$location,'level'=>$_POST["level"],'email_pengajar'=>$fromEmail, 'key_user_register'=>$key, 'pengajar'=>$pengajar),
    array('%d', '%s', '%s','%s', '%s','%s','%s', '%s','%s'));
		if($insert){
				echo '<div>';
				echo '<p>Data telah tersimpan</p>';
				echo '</div>';
				//jika berhasil menyimpan maka kirim email
				if ( wp_mail( $email, $subject, $sendText, $headers ) ) {
					echo '<div>';
					echo '<p>Thanks for contacting me, expect a response soon.</p>';
					echo '</div>';
					remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
					} else {
			           echo 'An unexpected error occurred';
			        }
		}else{
			if($wpdb->last_error !== '') :
			        $str   = htmlspecialchars( $wpdb->last_result, ENT_QUOTES );
			        $query = htmlspecialchars( $wpdb->last_query, ENT_QUOTES );
			        print "<div id='error'>
			        <p class='wpdberror'><strong>WordPress database error:</strong> [$str]<br />
			        <code>$query</code></p>
			        <p> $key</p>
			        </div>";
		    endif;
		echo "gaga;";
		}


	}
}

//untuk mengaktifkan html tag
function set_html_content_type()
{
    return 'text/html';
}
//test function
function call(){
form_daftar_course();
email_dan_simpan();
}

//akhir pembuatan form create course
?>
