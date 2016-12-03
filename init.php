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
    $sql = "CREATE TABLE `".$wpdb->prefix."registered_pelajar` (
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
          ALTER TABLE `".$wpdb->prefix."registered_pelajar`
            ADD PRIMARY KEY (`id`);
          ALTER TABLE `".$wpdb->prefix."registered_pelajar`
            MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

            `id` int(5) NOT NULL,
            CREATE TABLE `".$wpdb->prefix."register_pelajar` (
            `list_student_name` text NOT NULL,
            `email_pelajar` text NOT NULL,
            `level` varchar(7) NOT NULL,
            `email_pengajar` varchar(35) NOT NULL,
            `key_user_register` varchar(25) NOT NULL,
            `pengajar` varchar(40) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          ALTER TABLE `".$wpdb->prefix"register_pelajar`
          ADD PRIMARY KEY (`id`);
          ALTER TABLE `".$wpdb->prefix."register_pelajar`
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

        CREATE TABLE `".$wpdb->prefix."exam_poin` (
        `id` int(5) NOT NULL,
        `participan_id` int(5) NOT NULL,
        `exam_id` int(11) NOT NULL,
        `status` int(2) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
      -- Indexes for table `".$wpdb->prefix."exam_poin`
          --
          ALTER TABLE `".$wpdb->prefix."exam_poin`
            ADD PRIMARY KEY (`id`);

          --
          -- AUTO_INCREMENT for dumped tables
          --

          --
          -- AUTO_INCREMENT for table `".$wpdb->prefix."exam_poin`
          --
          ALTER TABLE `".$wpdb->prefix."exam_poin`
            MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

            CREATE TABLE `".$wpdb->prefix."country` (
    `name` varchar(50) NOT NULL,
    `code` varchar(5) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

  --
  -- Dumping data for table `".$wpdb->prefix."country`
  --

  INSERT INTO `".$wpdb->prefix."country` (`name`, `code`) VALUES
  ('Afghanistan', 'AF'),
  ('Albania', 'AL'),
  ('Algeria', 'DZ'),
  ('American Samoa', 'AS'),
  ('AndorrA', 'AD'),
  ('Angola', 'AO'),
  ('Anguilla', 'AI'),
  ('Antarctica', 'AQ'),
  ('Antigua and Barbuda', 'AG'),
  ('Argentina', 'AR'),
  ('Armenia', 'AM'),
  ('Aruba', 'AW'),
  ('Australia', 'AU'),
  ('Austria', 'AT'),
  ('Azerbaijan', 'AZ'),
  ('Bahamas', 'BS'),
  ('Bahrain', 'BH'),
  ('Bangladesh', 'BD'),
  ('Barbados', 'BB'),
  ('Belarus', 'BY'),
  ('Belgium', 'BE'),
  ('Belize', 'BZ'),
  ('Benin', 'BJ'),
  ('Bermuda', 'BM'),
  ('Bhutan', 'BT'),
  ('Bolivia', 'BO'),
  ('Bosnia and Herzegovina', 'BA'),
  ('Botswana', 'BW'),
  ('Bouvet Island', 'BV'),
  ('Brazil', 'BR'),
  ('British Indian Ocean Territory', 'IO'),
  ('Brunei Darussalam', 'BN'),
  ('Bulgaria', 'BG'),
  ('Burkina Faso', 'BF'),
  ('Burundi', 'BI'),
  ('Cambodia', 'KH'),
  ('Cameroon', 'CM'),
  ('Canada', 'CA'),
  ('Cape Verde', 'CV'),
  ('Cayman Islands', 'KY'),
  ('Central African Republic', 'CF'),
  ('Chad', 'TD'),
  ('Chile', 'CL'),
  ('China', 'CN'),
  ('Christmas Island', 'CX'),
  ('Cocos (Keeling) Islands', 'CC'),
  ('Colombia', 'CO'),
  ('Comoros', 'KM'),
  ('Congo', 'CG'),
  ('Congo, The Democratic Republic of the', 'CD'),
  ('Cook Islands', 'CK'),
  ('Costa Rica', 'CR'),
  ('Cote D''Ivoire', 'CI'),
  ('Croatia', 'HR'),
  ('Cuba', 'CU'),
  ('Cyprus', 'CY'),
  ('Czech Republic', 'CZ'),
  ('Denmark', 'DK'),
  ('Djibouti', 'DJ'),
  ('Dominica', 'DM'),
  ('Dominican Republic', 'DO'),
  ('Ecuador', 'EC'),
  ('Egypt', 'EG'),
  ('El Salvador', 'SV'),
  ('Equatorial Guinea', 'GQ'),
  ('Eritrea', 'ER'),
  ('Estonia', 'EE'),
  ('Ethiopia', 'ET'),
  ('Falkland Islands (Malvinas)', 'FK'),
  ('Faroe Islands', 'FO'),
  ('Fiji', 'FJ'),
  ('Finland', 'FI'),
  ('France', 'FR'),
  ('French Guiana', 'GF'),
  ('French Polynesia', 'PF'),
  ('French Southern Territories', 'TF'),
  ('Gabon', 'GA'),
  ('Gambia', 'GM'),
  ('Georgia', 'GE'),
  ('Germany', 'DE'),
  ('Ghana', 'GH'),
  ('Gibraltar', 'GI'),
  ('Greece', 'GR'),
  ('Greenland', 'GL'),
  ('Grenada', 'GD'),
  ('Guadeloupe', 'GP'),
  ('Guam', 'GU'),
  ('Guatemala', 'GT'),
  ('Guernsey', 'GG'),
  ('Guinea', 'GN'),
  ('Guinea-Bissau', 'GW'),
  ('Guyana', 'GY'),
  ('Haiti', 'HT'),
  ('Heard Island and Mcdonald Islands', 'HM'),
  ('Holy See (Vatican City State)', 'VA'),
  ('Honduras', 'HN'),
  ('Hong Kong', 'HK'),
  ('Hungary', 'HU'),
  ('Iceland', 'IS'),
  ('India', 'IN'),
  ('Indonesia', 'ID'),
  ('Iran, Islamic Republic Of', 'IR'),
  ('Iraq', 'IQ'),
  ('Ireland', 'IE'),
  ('Isle of Man', 'IM'),
  ('Israel', 'IL'),
  ('Italy', 'IT'),
  ('Jamaica', 'JM'),
  ('Japan', 'JP'),
  ('Jersey', 'JE'),
  ('Jordan', 'JO'),
  ('Kazakhstan', 'KZ'),
  ('Kenya', 'KE'),
  ('Kiribati', 'KI'),
  ('Korea, Democratic People''S Republic of', 'KP'),
  ('Korea, Republic of', 'KR'),
  ('Kuwait', 'KW'),
  ('Kyrgyzstan', 'KG'),
  ('Lao People''S Democratic Republic', 'LA'),
  ('Latvia', 'LV'),
  ('Lebanon', 'LB'),
  ('Lesotho', 'LS'),
  ('Liberia', 'LR'),
  ('Libyan Arab Jamahiriya', 'LY'),
  ('Liechtenstein', 'LI'),
  ('Lithuania', 'LT'),
  ('Luxembourg', 'LU'),
  ('Macao', 'MO'),
  ('Macedonia, The Former Yugoslav Republic of', 'MK'),
  ('Madagascar', 'MG'),
  ('Malawi', 'MW'),
  ('Malaysia', 'MY'),
  ('Maldives', 'MV'),
  ('Mali', 'ML'),
  ('Malta', 'MT'),
  ('Marshall Islands', 'MH'),
  ('Martinique', 'MQ'),
  ('Mauritania', 'MR'),
  ('Mauritius', 'MU'),
  ('Mayotte', 'YT'),
  ('Mexico', 'MX'),
  ('Micronesia, Federated States of', 'FM'),
  ('Moldova, Republic of', 'MD'),
  ('Monaco', 'MC'),
  ('Mongolia', 'MN'),
  ('Montserrat', 'MS'),
  ('Morocco', 'MA'),
  ('Mozambique', 'MZ'),
  ('Myanmar', 'MM'),
  ('Namibia', 'NA'),
  ('Nauru', 'NR'),
  ('Nepal', 'NP'),
  ('Netherlands', 'NL'),
  ('Netherlands Antilles', 'AN'),
  ('New Caledonia', 'NC'),
  ('New Zealand', 'NZ'),
  ('Nicaragua', 'NI'),
  ('Niger', 'NE'),
  ('Nigeria', 'NG'),
  ('Niue', 'NU'),
  ('Norfolk Island', 'NF'),
  ('Northern Mariana Islands', 'MP'),
  ('Norway', 'NO'),
  ('Oman', 'OM'),
  ('Pakistan', 'PK'),
  ('Palau', 'PW'),
  ('Palestinian Territory, Occupied', 'PS'),
  ('Panama', 'PA'),
  ('Papua New Guinea', 'PG'),
  ('Paraguay', 'PY'),
  ('Peru', 'PE'),
  ('Philippines', 'PH'),
  ('Pitcairn', 'PN'),
  ('Poland', 'PL'),
  ('Portugal', 'PT'),
  ('Puerto Rico', 'PR'),
  ('Qatar', 'QA'),
  ('Reunion', 'RE'),
  ('Romania', 'RO'),
  ('Russian Federation', 'RU'),
  ('RWANDA', 'RW'),
  ('Saint Helena', 'SH'),
  ('Saint Kitts and Nevis', 'KN'),
  ('Saint Lucia', 'LC'),
  ('Saint Pierre and Miquelon', 'PM'),
  ('Saint Vincent and the Grenadines', 'VC'),
  ('Samoa', 'WS'),
  ('San Marino', 'SM'),
  ('Sao Tome and Principe', 'ST'),
  ('Saudi Arabia', 'SA'),
  ('Senegal', 'SN'),
  ('Serbia and Montenegro', 'CS'),
  ('Seychelles', 'SC'),
  ('Sierra Leone', 'SL'),
  ('Singapore', 'SG'),
  ('Slovakia', 'SK'),
  ('Slovenia', 'SI'),
  ('Solomon Islands', 'SB'),
  ('Somalia', 'SO'),
  ('South Africa', 'ZA'),
  ('South Georgia and the South Sandwich Islands', 'GS'),
  ('Spain', 'ES'),
  ('Sri Lanka', 'LK'),
  ('Sudan', 'SD'),
  ('Suriname', 'SR'),
  ('Svalbard and Jan Mayen', 'SJ'),
  ('Swaziland', 'SZ'),
  ('Sweden', 'SE'),
  ('Switzerland', 'CH'),
  ('Syrian Arab Republic', 'SY'),
  ('Taiwan, Province of China', 'TW'),
  ('Tajikistan', 'TJ'),
  ('Tanzania, United Republic of', 'TZ'),
  ('Thailand', 'TH'),
  ('Timor-Leste', 'TL'),
  ('Togo', 'TG'),
  ('Tokelau', 'TK'),
  ('Tonga', 'TO'),
  ('Trinidad and Tobago', 'TT'),
  ('Tunisia', 'TN'),
  ('Turkey', 'TR'),
  ('Turkmenistan', 'TM'),
  ('Turks and Caicos Islands', 'TC'),
  ('Tuvalu', 'TV'),
  ('Uganda', 'UG'),
  ('Ukraine', 'UA'),
  ('United Arab Emirates', 'AE'),
  ('United Kingdom', 'GB'),
  ('United States', 'US'),
  ('United States Minor Outlying Islands', 'UM'),
  ('Uruguay', 'UY'),
  ('Uzbekistan', 'UZ'),
  ('Vanuatu', 'VU'),
  ('Venezuela', 'VE'),
  ('Viet Nam', 'VN'),
  ('Virgin Islands, British', 'VG'),
  ('Virgin Islands, U.S.', 'VI'),
  ('Wallis and Futuna', 'WF'),
  ('Western Sahara', 'EH'),
  ('Yemen', 'YE'),
  ('Zambia', 'ZM'),
  ('Zimbabwe', 'ZW'),
  ('Åland Islands', 'AX');

  --
  -- Indexes for dumped tables
  --

  --
  -- Indexes for table `".$wpdb->prefix."country`
  --
  ALTER TABLE `".$wpdb->prefix."country`
    ADD PRIMARY KEY (`name`);
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
