<?php

function form_examp_pointing() {
  //get student id untuk single user pointing
  $student_id = $_GET['id'];
  $multi_id   =$_GET['multiID'];
  global $wpdb;
  $exams = $wpdb->get_results("select * from complyted_exam");
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
  ?>
  <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/draf-course/style-admin.css" rel="stylesheet" />
  <h3>Course result check</h3>
  <table class='wp-list-table widefat fixed striped posts'>
      <tr>
        <th class="bgth manage-column ss-list-width1">Participan Name</th>
  <?php
      $exam_total = 0;
      $exam_names=array();
      foreach ($exams as $exam) {
        $exam_total++;
        $exam_names[] = $exam;
  ?>
        <th class="bgth manage-column ss-list-width1"><?php echo $exam->exam_name; ?></th>
  <?php } ?>
  <th class="bgth manage-column ss-list-width" colspan="2">Action</th>
      </tr>
  <?php
  if ( empty( $student_id ) ){
    if ( isset($multi_id) ) {
      echo "<input type='hidden' name='exam_total' value='$exam_total'>";
      echo "<input type='hidden' name='exam_names' value='".json_encode($exam_names)."'>";
      echo "<tr>";
      $a = 0;
      $multi_student = $wpdb->get_results("select id, nama_pelajar from wp_registered_pelajar WHERE id IN ($multi_id)");
      foreach ($multi_student as $r ) {
        echo "<td class='manage-column ss-list-width'>$r->nama_pelajar
        <input type='hidden' value='$r->id' name='x-id[]'></td>";
        //.str_replace(" ","_",$exam_names[$i]->exam_name)."[]
        for ($i=0; $i<$exam_total; $i++){
          echo "<td class='manage-column ss-list-width'>
          <input type='checkbox' name='".str_replace(" ","_",$exam_names[$i]->exam_name)."[]' value='".$r->id."#".$exam_names[$i]->id."#1'>Pass
          <input type='checkbox' name='".str_replace(" ","_",$exam_names[$i]->exam_name)."[]' value='".$r->id."#".$exam_names[$i]->id."#0' checked>Fail
          </td>";
// echo "<br><br><br>".$i;

        }
        echo "<td class='manage-column ss-list-width'><a href='#'>Delete Participan</a></td>";
        echo "</tr>";
        $a++;
      }
      echo "<input type='hidden' value='".$a * $i."' name='tot'>";
      // for ($i=0; $i<$exam_total; $i++){
      //   echo "<td class='manage-column ss-list-width'><input type='checkbox' name='exm$i'></td></tr>";
      // }
      // exit( var_dump( $wpdb->last_query ) );
      // print_r($multi_id);

    }else{
      echo "<tr>";
      echo "<td colspan='4' align='center'>Oooopss... There is no Student</td>";
      echo "</tr>";
    }

  }
  else{
    $pid= '';
    $one_student = $wpdb->get_results("select id, nama_pelajar from wp_registered_pelajar WHERE id = '$student_id'");
    foreach ($one_student as $r ) {
      echo "<td class='manage-column ss-list-width'>$r->nama_pelajar <input type='hidden' value='$r->nama_pelajar' name='x-name'>
      <input type='hidden' value='$r->id' name='one_insert'></td>";
      $pid = $r->id;
    }
    for ($i=0; $i<$exam_total; $i++){
      echo "<td class='manage-column ss-list-width'><input type='checkbox' id='gift$i' name='exm[]' value='".$exam_names[$i]->id."'>Check if pass<input type='hidden' id='gift-true$i' name='poin[]' value='".$pid."#".$exam_names[$i]->id."#0'></td>";
    }
    ?>
    <!--  jquery  -->

  <script>
    var jml = <?php echo $exam_total; ?>;
    jQuery(function($){
       for (var i = 0; i< jml; i++ ){
         $('#gift' + i).on('change', function(e) {
           $(this).next().val(($(this).is(':checked')) ? "<?php echo $pid; ?>#"+($(this).val())+"#1" : "<?php echo $pid; ?>#"+($(this).val())+"#0");
         });
       }
    });

  </script>
  <?php
  }

  echo '</table><p><input type="submit" id="btn" name="p-submitted" value="Save Result"></p>';
	echo '</form>';
}

function save_courese_result() {
	// if the submit button is clicked, send the email
  global $wpdb;
  $nameexam_post = array();
  $exa_post_val = array();
  // $fill = array();
  $exam_total = $_POST['tot'];
  $exm_tot1 = $_POST['exam_total'];
  $exam_namer = $_POST['exam_names'];
  $exam_names = json_decode(stripslashes($exam_namer));
  // print_r($exm_tot1);
	if ( isset( $_POST['p-submitted'] ) ) {
// jika menginput multi pelajar
    if( !isset($_POST['one_insert']) ){

      for($i=0; $i<$exm_tot1; $i++){
        $nameexam_post[] = str_replace(" ", "_",$exam_names[$i]->exam_name);
      }
      // mendapatkan input setip exam
      $a = 0;
      //persiapann insert multi
      $sql_in = "INSERT INTO wp_exam_poin
              (id, participan_id, exam_id, status)
              VALUES ";
      foreach( $nameexam_post as $input_chck ){
        if(is_array($_POST[$input_chck]) ){
            // echo $_POST[$input_chck];
            foreach($_POST[$input_chck] as $key => $val){
              // echo "value : ".$val."<br>";
              $get_to_in = explode("#",$val);
              $participan_id = $get_to_in[0];
              $exam_id       = $get_to_in[1];
              $status        = $get_to_in[2];
              $sql_in .= "('',$participan_id,$exam_id,$status),";
            }
            // echo count($_POST[$input_chck]);
        }elseif(count($_POST[$input_chck]) < 6){
          echo "<div class='warning'>
                  <p>Ohh... You need to select Pass or Fail
                </div>";
        }
        $a++;
      }
      $fix_to_in = trim($sql_in, ',');
      if( $wpdb->query("$fix_to_in") ){
        echo "Berhasil";
      }

    }else {
      //jika hanya satu
      $sqlin = "INSERT INTO wp_exam_poin
              (id, participan_id, exam_id, status)
              VALUES ";
      $examstatus = $_POST['poin'];
      foreach ($examstatus as $key => $value) {
        $get_to_in = explode("#",$value);
        $participan_id = $get_to_in[0];
        $exam_id       = $get_to_in[1];
        $status        = $get_to_in[2];
        $sqlin         .= "('',$participan_id,$exam_id,$status),";

      }
      $simpan_ini = trim($sqlin,',');
      // echo $simpan_ini;
      if( $wpdb->query("$simpan_ini") ){
        echo "Berhasil";
      }
    }
  // print_r($nameexam_post);
  }
}

function exam_call(){

form_examp_pointing();
save_courese_result();

}
