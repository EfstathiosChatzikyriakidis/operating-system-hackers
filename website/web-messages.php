<?php
  // define web text messages.

  /*
   *  Copyright (C) 2011  Efstathios Chatzikyriakidis <contact@efxa.org>
   *
   *  This program is free software: you can redistribute it and/or modify
   *  it under the terms of the GNU General Public License as published by
   *  the Free Software Foundation, either version 3 of the License, or
   *  (at your option) any later version.
   *
   *  This program is distributed in the hope that it will be useful,
   *  but WITHOUT ANY WARRANTY; without even the implied warranty of
   *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   *  GNU General Public License for more details.
   *
   *  You should have received a copy of the GNU General Public License
   *  along with this program. If not, see <http://www.gnu.org/licenses/>.
   */

  /*
   * shared messages.
   */

  // home page bottom messages.
  $bottom_l_msg = "This project is licensed under the GNU <a href='http://www.gnu.org/licenses/gpl-3.0.txt' target='_blank'>GPLv3</a>";
  $bottom_r_msg = "(Web hosting by <a href='http://www.dtek.gr/' target='_blank'>D-TEK :: NET.working</a>)";

  // sql error messages.
  $sql_database_connect_error = "An error occurred while the application tried to connect to a database.";
  $sql_database_select_error  = "An error occurred while the application tried to execute a select query.";
  $sql_database_insert_error  = "An error occurred while the application tried to execute an insert query.";
  $sql_database_update_error  = "An error occurred while the application tried to execute an update query.";
  $sql_database_delete_error  = "An error occurred while the application tried to execute a delete query.";
  $sql_database_create_error  = "An error occurred while the application tried to execute a create query.";
  $sql_database_empty_error   = "An empty data set is returned after the execution of a query.";

  // dao error message.
  $dao_generic_logic_error = "An error occurred while the application tried to execute a DAO query.";

  // security messages.
  $security_file_insuff_params_error = "An error occurred while the file called with insufficient parameters.";

  // marker messages.
  $marker_name    = "Name:";
  $marker_email   = "Email:";
  $marker_url     = "URL:";
  $marker_type    = "System:";
  $marker_address = "Address:";
  $marker_lat     = "Latitude:";
  $marker_lng     = "Longitude:";
  $marker_active  = "Active:";
  $marker_text    = "Text:";

  // general messages.
  $navigate_goto_text = "Move :";
  $navigate_home_text = "Home";
  $navigate_back_text = "Back";
  $navigate_list_text = "List";

  $fill_all_form_data = "Please fill all the fields of the form.";
  $fill_fields_form   = "Please fill the necessary fields (those with the asterisk) of the form.";
  $fill_repeat_form   = "Try again.";

  $search_anything_header_title = "Search Anything";

  $there_are_no_types   = "There are no systems.";
  $there_are_no_markers = "There are no users.";
  $the_type_exists      = "The system already exists.";

  $increasing_number = "A/A";
  $general_toplink   = "^ Top";
  $continue_asking   = "Do you want to continue?";

  $error_email_addr = "The email address cannot be used!";
  $dir_access_error = "System cannot access the directory.";

  $privacy_policy_title = "Privacy Policy.";
  $privacy_policy_rules = "The personal data that each user introduced to this website are not transferred to third parties and are used exclusively for their appearance on the map.";

  $account_restrictions_title = "Registration Ιnstructions.";
  $account_restrictions_rules = "<ol>"
                               ."  <li>Use only English!</li>"
                               ."  <li>Type your real name, e.g: 'John Malkovich' unless you are own a community, e.g: 'OSHackers'.</li>"
                               ."  <li>Type the URL from your personal website / blog. Otherwise, leave it empty.</li>"
                               ."  <li>Type a valid email where other people can communicate with you. Later on you will need to verify your registration.</li>"
                               ."  <li>Type a valid address, e.g: 'Huancayo, Junin, Peru'.</li>"
                               ."  <li>Latitude and Longitude must be correct in relation with the address you typed.</li>"
                               ."</ol>";

  // google map messages.
  $gmap_error_place  = "Not correct place!";
  $gmap_browser_err  = "Sorry, the Google Maps API is not compatible with this browser.";

  /*
   * normal messages.
   */

  // select type box messages.
  $select_type_header_title    = "Select System";
  $select_type_default_showall = "Show Everything";
  $select_type_default_choose  = "Select System";

  // menu (sub) operations.
  $register_form_access_link = "Register Yourself";
  $locate_us_access_link     = "Locate Us";
  $information_access_link   = "Information";
  $statistics_access_link    = "Top Systems";

  // marker registration / verification messages.
  $register_add_marker_form_title = "Register Yourself.";
  $register_add_marker_form_name  = "* Name";
  $register_add_marker_form_email = "* Email";
  $register_add_marker_form_url   = "- URL";
  $register_add_marker_form_type  = "* System";
  $register_add_marker_form_addr  = "* Address";
  $register_add_marker_form_lat   = "* Latitude";
  $register_add_marker_form_lng   = "* Longitude";
  $register_add_marker_form_text  = "- Text";
  $register_add_marker_form_loc   = "* Location";

  $register_add_marker_form_map   = "Specify your location either by Searching or by Right Click / Drag & Drop in the map!";

  $register_add_marker_process = "Trying to create a new user.";
  $register_add_marker_created = "The user is created.";

  $register_sending_mail_done = "A message has been sent to your email account with a verification key.";
  $register_sending_mail_fail = "The system is not able to send to your email account a verification key.";

  $register_sending_mail_subj = "Registration Verification";
  $register_sending_mail_body = "Press the following link to verify the registration:";

  $register_marker_verify_process = "Trying to verify the registration of the new user.";
  $register_marker_verify_missing = "The verification key is not acceptable.";
  $register_marker_verify_success = "Please, now wait the administrator to approve your registration.";

  // marker warning messages.
  $warn_sending_mail_done = "A warning message has been sent to the specified email account.";
  $warn_sending_mail_fail = "The system is not able to send to the email account a warning message.";

  $warn_sending_mail_subj = "Registration Warning";
  $warn_sending_mail_body = "Your registration request was canceled by the administrator since some rules were overlooked. Try to register again, this time by following the instructions.";

  // information dialog and tabs.
  $about_us_tab_title = "About Us";
  $authors_tab_title  = "Authors";

  $about_us_tab_content = "<p>OSHackers is a web-based geographical system.</p>"
                         ."<p>It uses Google Maps for visualising the Free Software OS users around the world.</p>"
                         ."<p>Every POSIX OS has a place on our map.</p>"
                         ."<p>Users can view on Google Maps the spread of POSIX OS around the world.</p>"
                         ."<p>You can find friends and other famous or not hackers in every country.</p>";

  $authors_tab_content  = "<b>Authors:</b>"
                         ."<ul>"
                         ."  <li>Efstathios Chatzikyriakidis</li>"
                         ."  <li>Demosthenes Koptsis</li>"
                         ."</ul>";

  // statistics dialog content.
  $statistics_dialog_content = "<p>Top operating systems that users like most.</p>";

  /*
   * admin messages.
   */

  // admin panel message.
  $admin_manage_text = "Administration";

  // installation messages.
  $admin_install_title = "Try to install the system.";

  $admin_install_hostname = "- DB Hostname";
  $admin_install_username = "- DB Username";
  $admin_install_password = "- DB Password";
  $admin_install_database = "- DB Name";
  $admin_install_gmapikey = "- GMap Key";
  $admin_install_gmapilng = "- GMap Language";
  $admin_install_gmapaddr = "- System Address";
  $admin_install_mailaddr = "- Email Address";
  $admin_install_skeysize = "- Secret Key Size";
  $admin_install_statstop = "- Stats Top Types";

  $admin_install_webdoma = "- Web Domain Name";
  $admin_install_webname = "- Web Name";
  $admin_install_webtitl = "- Web Title";
  $admin_install_webvers = "- Web Version";
  $admin_install_webdesc = "- Web Description";
  $admin_install_webkeys = "- Web Keywords";

  $admin_install_init_webname = "Map Places";
  $admin_install_init_webdesc = "Earth Exploring Via Web-Based Geographical Information System!";
  $admin_install_init_webkeys = "map, places, google, gis";

  $admin_install_success = "Installation Completed.";
  $admin_install_failure = "Installation Failed.";

  // menu (sub) operations.
  $admin_op_add_type_marker = "Create systems / users";
  $admin_op_man_type_marker = "Manage systems / users";

  $admin_op_man_type_text   = "Manage systems";
  $admin_op_man_marker_text = "Manage users";

  $admin_op_add_marker_text = "Create a new user";
  $admin_op_add_type_text   = "Create a new system";

  // type / marker management messages.
  $admin_add_marker_form_title  = "Create a new user.";
  $admin_add_marker_form_name   = "* Name";
  $admin_add_marker_form_active = "* Active";
  $admin_add_marker_form_email  = "* Email";
  $admin_add_marker_form_url    = "- URL";
  $admin_add_marker_form_type   = "* System";
  $admin_add_marker_form_addr   = "* Address";
  $admin_add_marker_form_lat    = "* Latitude";
  $admin_add_marker_form_lng    = "* Longitude";
  $admin_add_marker_form_text   = "- Text";
  $admin_add_marker_form_loc    = "* Location";

  $admin_add_marker_form_map   = "Specify the location either by Searching or by Right Click / Drag & Drop in the map!";

  $admin_upd_marker_form_title  = "Try to update the user.";
  $admin_upd_marker_form_name   = "* Name";
  $admin_upd_marker_form_active = "* Active";
  $admin_upd_marker_form_email  = "* Email";
  $admin_upd_marker_form_url    = "- URL";
  $admin_upd_marker_form_type   = "* System";
  $admin_upd_marker_form_addr   = "* Address";
  $admin_upd_marker_form_lat    = "* Latitude";
  $admin_upd_marker_form_lng    = "* Longitude";
  $admin_upd_marker_form_text   = "- Text";
  $admin_upd_marker_form_loc    = "* Location";

  $admin_upd_marker_form_map    = "Specify the location either by Searching or by Right Click / Drag & Drop in the map!";

  $admin_add_type_form_title = "Create a new system.";
  $admin_add_type_form_name  = "* Name";
  $admin_add_type_form_image = "* Image";

  $admin_upd_type_form_title = "Try to update the system.";
  $admin_upd_type_form_name  = "* Name";
  $admin_upd_type_form_image = "* Image";

  $admin_man_marker_list_title  = "Users";
  $admin_man_marker_list_name   = "Name";
  $admin_man_marker_list_active = "Active?";
  $admin_man_marker_list_verify = "Verified?";
  $admin_man_marker_list_type   = "System";
  $admin_man_marker_list_warn   = "Warn";
  $admin_man_marker_list_delete = "Delete";

  $admin_man_type_list_title = "Systems";
  $admin_man_type_list_name  = "Name";
  $admin_man_type_list_image = "Image";

  $admin_upd_type_process = "Trying to update the system.";
  $admin_upd_type_updated = "The system is updated.";

  $admin_add_type_process = "Trying to create a new system.";
  $admin_add_type_created = "The system is created.";

  $admin_upd_marker_process = "Trying to update the user.";
  $admin_upd_marker_updated = "The user is updated.";
  
  $admin_add_marker_process = "Trying to create a new user.";
  $admin_add_marker_created = "The user is created.";

  $admin_del_type_process = "Trying to delete the system.";
  $admin_del_type_contain = "The system contains some users.";
  $admin_del_type_deleted = "The system is deleted.";
  $admin_del_type_missing = "The system does not exist.";

  $admin_del_marker_process = "Trying to delete the user.";
  $admin_del_marker_missing = "The user does not exist.";
  $admin_del_marker_deleted = "The user is deleted.";

  $admin_warn_marker_process = "Trying to warn the user.";
?>
