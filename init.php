<?php
/*
Plugin Name: Draf course Plugin
Plugin URI: http://drafshare.blogspot.co.id/
Description: Simple non-bloated WordPress Form
Version: 1.0
Author: Dirham
Author URI: https://www.facebook.com/draf.dirham
*/

function draf_db_install() {

    global $wpdb;

    $table_name = $wpdb->prefix . "course";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE `wp_registered_pelajar` (
            `id` int(5) NOT NULL,
            `nama_pelajar` varchar(40) NOT NULL,
            `email_pelajar` varchar(35) NOT NULL,
            `jkel` varchar(15) NOT NULL,
            `negara` varchar(25) NOT NULL,
            `alamat` text NOT NULL,
            `message` text NOT NULL,
            `email_pengajar` varchar(35) NOT NULL,
            `pengajar` varchar(40) NOT NULL,
            `key_user_register` varchar(25) NOT NULL,
            `profil_picture_id` int(10) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          ALTER TABLE `wp_registered_pelajar`
            ADD PRIMARY KEY (`id`);
          ALTER TABLE `wp_registered_pelajar`
            MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

            CREATE TABLE `wp_register_pelajar` (
            `id` int(5) NOT NULL,
            `list_student_name` text NOT NULL,
            `email_pelajar` text NOT NULL,
            `level` varchar(7) NOT NULL,
            `email_pengajar` varchar(35) NOT NULL,
            `key_user_register` varchar(25) NOT NULL,
            `pengajar` varchar(40) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          ALTER TABLE `wp_register_pelajar`
          ADD PRIMARY KEY (`id`);
          ALTER TABLE `wp_register_pelajar`
          MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

          CREATE TABLE `complyted_exam` (
            `id` int(11) NOT NULL,
            `exam_name` varchar(35) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

          INSERT INTO `complyted_exam` (`id`, `exam_name`) VALUES
          (1, 'Complited Pool Requirement'),
          (2, 'Complited Theory Exam'),
          (3, 'Medical Sertificate Checked');
          ALTER TABLE `complyted_exam`
          ADD PRIMARY KEY (`id`),
            ADD UNIQUE KEY `examName` (`exam_name`);
          ALTER TABLE `complyted_exam`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
          ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'draf_db_install');

//menu items
add_action('admin_menu','draf_course_modifymenu');
function draf_course_modifymenu() {

	//membuat main menu
  add_menu_page('Course Information', //judul
	'Draf Course', //judul menu
	'read', //capabilities
	'draf_course_list_view', //menu slug
	'draf_course_list' //function
	);

	//menambakan menu untuk membuat course baru
	add_submenu_page('draf_course_list_view', //parent slug
	'Add New Course', //page title
	'Draf Create Course', //menu title
	'read', //capability
	'draf_form_c_course', //menu slug
	'call'); //function

  //menambakan menu untuk melihat hasil test
	add_submenu_page('draf_course_list_view', //parent slug
	'Hasil Kursus', //page title
	'Draf Course Result', //menu title
	'read', //capability
	'draf_course_result_complit', //menu slug
	'draf_course_result_complit'); //function

	//menu edit course, menu ini tidak akan ditampilkan tapi tetap harus di ikutkan.
  add_submenu_page(null, //parent slug
  'Update Course', //page title
  'Update', //menu title
  'read', //capability
  'draf_course_update', //menu slug
  'draf_course_update_course'); //function

  //menu untuk melakukan penginputan user
	add_submenu_page('draf_course_list_view',
  'Student Information Form', //judul
	'Course student information', //judul menu
	'read', //capabilities
	'draf_student_form', //menu slug
	'student_call' //function
	);

  add_submenu_page('draf_course_list_view',
  'Registered Student', //judul
	'Registered Student', //judul menu
	'read', //capabilities
	'draf_student_registered', //menu slug
	'draf_registered_student' //function
);

add_submenu_page(null,
'Pointing Each Student Exam', //judul
'Exam pointing', //judul menu
'read', //capabilities
'draf_exam_pointing', //menu slug
'exam_call' //function
);

add_submenu_page(null,
'Sudent profile', //judul
'Student Profile Update', //judul menu
'read', //capabilities
'draf_student_info_update', //menu slug
'draf_student_info_update' //function
);
}

//pembuatan shortcode
add_shortcode( 'student_info_form', 'student_call' );//shortcode untuk registrasi kelengkapan info pelajar
add_shortcode( 'draf_form_create_course', 'call' );//shortcode untuk membuat course
add_shortcode( 'draf_student_registered', 'draf_registered_student' );//shortcode untuk melihat daftar pelajar yang  telah mengisi kelengkapan info
add_shortcode( 'course_list', 'draf_course_list' );//shortcode untuk melihat course list

define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'draf-course-list.php');
require_once(ROOTDIR . 'exam-pointing.php');
require_once(ROOTDIR . 'draf-course-reg.php');
require_once(ROOTDIR . 'draf-course-update-course.php');
require_once(ROOTDIR . 'draf-course-registered-student.php');
require_once(ROOTDIR . 'draf-new-student-form.php');
require_once(ROOTDIR . 'draf-student-info-update.php');
require_once(ROOTDIR . 'draf-search-recent-student.php');
