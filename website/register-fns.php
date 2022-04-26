<?php
  // define marker registration / verification functions.

  /*
   *  Copyright (C) 2011  Efstathios Chatzikyriakidis <stathis.chatzikyriakidis@gmail.com>
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

  // try to create a new marker registration.
  function create_registration ($_POST) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** create_registration () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create short variable names.
    $marker_name  = clean_user_data ($_POST['marker_name']);
    $marker_type  = clean_user_data ($_POST['marker_type']);
    $marker_email = clean_user_data ($_POST['marker_email']);
    $marker_url   = clean_user_data ($_POST['marker_url']);
    $marker_addr  = clean_user_data ($_POST['marker_addr']);
    $marker_lat   = clean_user_data ($_POST['marker_lat']);
    $marker_lng   = clean_user_data ($_POST['marker_lng']);
    $marker_text  = pretty_user_data ($_POST['marker_text']);

    // check if any of the necessary fields is empty.
    if ((!isset ($marker_name)  || empty ($marker_name)) ||
        (!isset ($marker_type)  || empty ($marker_type)) ||
        (!isset ($marker_addr)  || empty ($marker_addr)) ||
        (!isset ($marker_lat)   || empty ($marker_lat))  ||
        (!isset ($marker_lng)   || empty ($marker_lng))  ||
        (!isset ($marker_email) || empty ($marker_email))) {
      echo "<p>".clean_for_display ($GLOBALS['fill_fields_form'])."</p>";
      echo "<p>".clean_for_display ($GLOBALS['fill_repeat_form'])."</p>";
      return false;
    }

    // try to check if the email exists in the system.
    if (email_exists ($marker_email)) {
      echo "<p>".clean_for_display ($GLOBALS['error_email_addr'])."</p>";
      return false;
    }

    // try to validate the email address.
    if (!valid_email ($marker_email)) {
      echo "<p>".clean_for_display ($GLOBALS['error_email_addr'])."</p>";
      return false;
    }

    // BEGIN a db transaction.
    mysql_query ("BEGIN");

    // create a sql query for adding the new marker.
    $query = "INSERT INTO markers VALUES (NULL, '$marker_name', '$marker_addr', '$marker_lat', '$marker_lng', '$marker_type', 0)";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** create_registration (1) : ".clean_for_display ($GLOBALS['sql_database_insert_error'])."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }

    // fetch marker's primary key value.
    $marker_pkey = mysql_insert_id ();

    // create a sql query for adding the content of the new marker.
    $query = "INSERT INTO contents VALUES (NULL, '$marker_email', '$marker_url', '$marker_text', '$marker_pkey')";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** create_registration (2) : ".clean_for_display ($GLOBALS['sql_database_insert_error'])."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }

    // generate a random / secret unique key.
    $secret_key = get_unique_id (null, null, clean_for_display (CONF_SKEY_SIZE));

    // create a sql query for adding a new registration.
    $query = "INSERT INTO registrations VALUES (NULL, '$secret_key', 1, CURDATE(), '$marker_pkey')";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** create_registration (3) : ".clean_for_display ($GLOBALS['sql_database_insert_error'])."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }

    // try to send to the user an email to verify his/her registration.
    if (send_html_email (
          '<p>'.$marker_name.', </p><p>'.clean_for_display ($GLOBALS['register_sending_mail_body']).'</p><p>('.do_html_link (
             'http://'.clean_for_display (CONF_WEB_DOMA).'/'.FILE_REGISTER_VERIFY.'?skey='.$secret_key,
             'http://'.clean_for_display (CONF_WEB_DOMA).'/'.FILE_REGISTER_VERIFY.'?skey='.$secret_key, '_blank').')</p>',
          clean_for_display (CONF_MAIL_ADDR),
          $marker_email,
          clean_for_display (CONF_WEB_NAME).' - '.clean_for_display ($GLOBALS['register_sending_mail_subj']))) {
      echo "<p>".clean_for_display ($GLOBALS['register_sending_mail_done'])."</p>";
    }
    else {
      echo "<p>".clean_for_display ($GLOBALS['register_sending_mail_fail'])."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }

    // COMMIT the db transaction.
    mysql_query ("COMMIT");

    // the new marker is created.
    echo "<p>".clean_for_display ($GLOBALS['register_add_marker_created'])."</p>";
    return true;
  }

  // try to verify a new marker registration.
  function verify_registration ($skey) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** verify_registration () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create a sql query for getting marker registration's data.
    $query = "SELECT *
                FROM registrations
               WHERE skey = '".clean_user_data ($skey)."'
                 AND active = '1'
               LIMIT 1";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** verify_registration () : ".clean_for_display ($GLOBALS['sql_database_select_error'])."</p>";
      return false;
    }

    // check that at least one marker registration exists.
    $num = mysql_num_rows ($result);
    if (!$num) {
      echo "<p>".clean_for_display ($GLOBALS['register_marker_verify_missing'])."</p>";
      return false;
    }

    // get query result as an array.
    $result = mysql_fetch_array ($result);

    // get the marker registration identifier.
    $rid = clean_user_data ($result['id']);

    // create a sql query for updating the marker registration.
    $query = "UPDATE registrations SET active = '0' WHERE id = '$rid' LIMIT 1";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** verify_registration () : ".clean_for_display ($GLOBALS['sql_database_update_error'])."</p>";
      return false;
    }

    // the marker registration is verified.
    echo "<p>".clean_for_display ($GLOBALS['register_marker_verify_success'])."</p>";
    return true;
  }
?>
