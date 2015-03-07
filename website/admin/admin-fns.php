<?php
  // define administration functions.

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

  // try to create a new type.
  function add_new_type ($_POST) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** add_new_type () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create short variable names.
    $type_name  = clean_user_data ($_POST['type_name']);
    $type_image = clean_user_data ($_POST['type_image']);

    // check if any field of the form is empty.
    if (!filled_out ($_POST)) {
      echo "<p>".clean_for_display ($GLOBALS['fill_all_form_data'])."</p>";
      echo "<p>".clean_for_display ($GLOBALS['fill_repeat_form'])."</p>";
      return false;
    }

    // check if the type already exists.
    if (type_exists ($type_name)) {
      echo "<p>".clean_for_display ($GLOBALS['the_type_exists'])."</p>";
      return false;
    }

    // create a sql query for adding the new type.
    $query = "INSERT INTO types VALUES (NULL, '$type_name', '$type_image')";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** add_new_type () : ".clean_for_display ($GLOBALS['sql_database_insert_error'])."</p>";
      return false;
    }

    // the new type is created.
    echo "<p>".clean_for_display ($GLOBALS['admin_add_type_created'])."</p>";
    return true;
  }

  // try to create a new marker.
  function add_new_marker ($_POST) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** add_new_marker () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create short variable names.
    $marker_name   = clean_user_data ($_POST['marker_name']);
    $marker_type   = clean_user_data ($_POST['marker_type']);
    $marker_email  = clean_user_data ($_POST['marker_email']);
    $marker_url    = clean_user_data ($_POST['marker_url']);
    $marker_addr   = clean_user_data ($_POST['marker_addr']);
    $marker_lat    = clean_user_data ($_POST['marker_lat']);
    $marker_lng    = clean_user_data ($_POST['marker_lng']);
    $marker_active = clean_user_data ($_POST['marker_active']);
    $marker_text   = pretty_user_data ($_POST['marker_text']);

    // check if any of the necessary fields is empty.
    if ((!isset ($marker_name)   || empty ($marker_name))    ||
        (!isset ($marker_type)   || empty ($marker_type))    ||
        (!isset ($marker_addr)   || empty ($marker_addr))    ||
        (!isset ($marker_lat)    || empty ($marker_lat))     ||
        (!isset ($marker_lng)    || empty ($marker_lng))     ||
        (!isset ($marker_email)  || empty ($marker_email))   ||
        (!isset ($marker_active) || $marker_active == "")) {
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
    $query = "INSERT INTO markers VALUES (NULL,
                                          '$marker_name',
                                          '$marker_addr',
                                          '$marker_lat',
                                          '$marker_lng',
                                          '$marker_type',
                                          '$marker_active')";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** add_new_marker (1) : ".clean_for_display ($GLOBALS['sql_database_insert_error'])."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }

    // create a sql query for adding the content of the new marker.
    $query = "INSERT INTO contents VALUES (NULL,
                                          '$marker_email',
                                          '$marker_url',
                                          '$marker_text',
                                          '".mysql_insert_id ()."')";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** add_new_marker (2) : ".clean_for_display ($GLOBALS['sql_database_insert_error'])."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }

    // COMMIT the db transaction.
    mysql_query ("COMMIT");

    // the new marker is created.
    echo "<p>".clean_for_display ($GLOBALS['admin_add_marker_created'])."</p>";
    return true;
  }
  
  // try to check if a type exists.
  function type_exists ($type_name) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** type_exists () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create a sql query for checking a type.
    $query = "SELECT COUNT(*) FROM types WHERE name = '".clean_user_data ($type_name)."'";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** type_exists () : ".clean_for_display ($GLOBALS['sql_database_select_error'])."</p>";
      return false;
    }

    // check to see if the type exists.
    if (mysql_result ($result, 0, 0) > 0)
      return true;

    return false;
  }

  // try to display markers types.
  function display_types ($types) {
    // check if there are no types.
    if (!is_array ($types)) {
      echo "<p>".clean_for_display ($GLOBALS['there_are_no_types'])."</p>";
      return false;
    }

    $value  = '<table class="tlist" cellpadding="5" cellspacing="0" border="1">';
    $value .= ' <tbody style="font-weight: bold;">';
    $value .= '  <tr>';
    $value .= '   <td align="center">'.clean_for_display ($GLOBALS['increasing_number']).'</td><td>'.clean_for_display ($GLOBALS['admin_man_type_list_name']).'</td><td align="center">X</td>';
    $value .= '  </tr>';

    // the following var is used for looping.
    $i = '';

    $del_target = $upd_target = "main_column";

    $del_text   = "[ <b>x</b> ]";

    // create each url link for each type.
    foreach ($types as $row) {
      // update link.
      $upd_url  = 'http://'.clean_for_display (CONF_WEB_DOMA).'/'.DIR_ADMIN.'/'.DIR_TYPE_MARKER.'/'.FILE_UPD_TYPE_FORM.'?tid='.clean_for_display ($row['id']);
      $upd_text = clean_for_display ($row['name']);

      // remove link.
      $del_url = 'http://'.clean_for_display (CONF_WEB_DOMA).'/'.DIR_ADMIN.'/'.DIR_TYPE_MARKER.'/'.FILE_DEL_TYPE_PROC.'?tid='.clean_for_display ($row['id']);

      // store table rows for types.
      $value .= ' <tr>';
      $value .= '  <td align="center" width="40">'. ++$i.'</td>';
      $value .= '  <td class="nowrap">'.do_html_link ($upd_url, $upd_text, $upd_target).'</td>';
      $value .= '  <td align="center" class="nowrap">'.do_html_link ($del_url, $del_text, $del_target, '', 'onclick="return confirm ('."'".clean_for_display ($GLOBALS['continue_asking'])."'".');"').'</td>';
      $value .= ' </tr>';
    }

    $value .= ' </tbody>';
    $value .= '</table>';

    return $value;
  }

  // try to delete a marker type.
  function delete_type ($tid) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** delete_type () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create a sql query for checking the existence of the type id.
    $query = "SELECT id FROM types WHERE id = '".clean_user_data ($tid)."' LIMIT 1";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** delete_type (1) : ".clean_for_display ($GLOBALS['sql_database_select_error'])."</p>";
      return false;
    }

    // check for a type with the given id.
    $num = mysql_num_rows ($result);
    if (!$num) {
      echo "<p>".clean_for_display ($GLOBALS['admin_del_type_missing'])."</p>";
      return false;
    }

    // create a sql query for checking for markers.
    $query = "SELECT COUNT(*) FROM markers WHERE type = '".clean_user_data ($tid)."'"; 

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** delete_type (2) : ".clean_for_display ($GLOBALS['sql_database_select_error'])."</p>";
      return false;
    }

    // check to see there are any marker in the type.
    if (mysql_result ($result, 0, 0) > 0) {
      echo "<p>".clean_for_display ($GLOBALS['admin_del_type_contain'])."</p>";
      return false;
    }

    // create a sql query for deleting the type.
    $query = "DELETE FROM types WHERE id = '".clean_user_data ($tid)."' LIMIT 1";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** delete_type () : ".clean_for_display ($GLOBALS['sql_database_delete_error'])."</p>";
      return false;
    }

    // the marker is deleted.
    echo "<p>".clean_for_display ($GLOBALS['admin_del_type_deleted'])."</p>";
    return true;
  }

  // try to update a marker type.
  function update_type ($_POST) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** update_type () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create short variable names.
    $type_id    = clean_user_data ($_POST['type_id']);
    $type_name  = clean_user_data ($_POST['type_name']);
    $type_iname = clean_user_data ($_POST['type_iname']);
    $type_image = clean_user_data ($_POST['type_image']);

    // check if any field of the form is empty.
    if (!filled_out ($_POST)) {
      echo "<p>".clean_for_display ($GLOBALS['fill_all_form_data'])."</p>";
      echo "<p>".clean_for_display ($GLOBALS['fill_repeat_form'])."</p>";
      return false;
    }

    // check if there was a change in the type name.
    if (strcasecmp ($type_name, $type_iname) != 0) {
      // check if the type exists.
      if (type_exists ($type_name)) {
        echo "<p>".clean_for_display ($GLOBALS['the_type_exists'])."</p>";
        return false;
      }
    }

    // create a sql query for updating a type.
    $query = "UPDATE types SET name = '$type_name', image = '$type_image' WHERE id = '$type_id' LIMIT 1";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** update_type () : ".clean_for_display ($GLOBALS['sql_database_update_error'])."</p>";
      return false;
    }

    // the type is update.
    echo "<p>".clean_for_display ($GLOBALS['admin_upd_type_updated'])."</p>";
    return true;
  }

  // try to update a marker.
  function update_marker ($_POST) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** update_marker () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create short variable names.
    $marker_id     = clean_user_data ($_POST['marker_id']);
    $marker_name   = clean_user_data ($_POST['marker_name']);
    $marker_type   = clean_user_data ($_POST['marker_type']);
    $marker_email  = clean_user_data ($_POST['marker_email']);
    $marker_iemail = clean_user_data ($_POST['marker_iemail']);
    $marker_url    = clean_user_data ($_POST['marker_url']);
    $marker_addr   = clean_user_data ($_POST['marker_addr']);
    $marker_lat    = clean_user_data ($_POST['marker_lat']);
    $marker_active = clean_user_data ($_POST['marker_active']);
    $marker_lng    = clean_user_data ($_POST['marker_lng']);
    $marker_text   = pretty_user_data ($_POST['marker_text']);

    // check if any of the necessary fields is empty.
    if ((!isset ($marker_id)     || empty ($marker_id))      ||
        (!isset ($marker_type)   || empty ($marker_type))    ||
        (!isset ($marker_addr)   || empty ($marker_addr))    ||
        (!isset ($marker_lat)    || empty ($marker_lat))     ||
        (!isset ($marker_lng)    || empty ($marker_lng))     ||
        (!isset ($marker_email)  || empty ($marker_email))   ||
        (!isset ($marker_iemail) || empty ($marker_iemail))  ||
        (!isset ($marker_active) || $marker_active == "")) {
      echo "<p>".clean_for_display ($GLOBALS['fill_fields_form'])."</p>";
      echo "<p>".clean_for_display ($GLOBALS['fill_repeat_form'])."</p>";
      return false;
    }

    // check if there was a change in the marker email.
    if (strcasecmp ($marker_email, $marker_iemail)) {
      // check if the email exists.
      if (email_exists ($marker_email)) {
        echo "<p>".clean_for_display ($GLOBALS['error_email_addr'])."</p>";
        return false;
      }
    }

    // try to validate the email address.
    if (!valid_email ($marker_email)) {
      echo "<p>".clean_for_display ($GLOBALS['error_email_addr'])."</p>";
      return false;
    }

    // BEGIN a db transaction.
    mysql_query ("BEGIN");

    // create a sql query for updating the marker.
    $query = "UPDATE markers
                 SET name = '$marker_name',
                     address = '$marker_addr',
                     lat = '$marker_lat',
                     lng = '$marker_lng',
                     type = '$marker_type',
                     active = '$marker_active'
               WHERE id = '$marker_id'
               LIMIT 1";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** update_marker (1) : ".clean_for_display ($GLOBALS['sql_database_update_error'])."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }

    // create a sql query for updating marker's content.
    $query = "UPDATE contents
                 SET email = '$marker_email',
                     url = '$marker_url',
                     text = '$marker_text'
               WHERE marker = '$marker_id'
               LIMIT 1";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** update_marker (2) : ".clean_for_display ($GLOBALS['sql_database_update_error'])."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }

    // COMMIT the db transaction.
    mysql_query ("COMMIT");

    // the marker is updated.
    echo "<p>".clean_for_display ($GLOBALS['admin_upd_marker_updated'])."</p>";
    return true;
  }
  
  // try to fetch the markers' data.
  function get_markers_data () {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** get_markers_data () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create a sql query for getting markers' data.
    $query = "SELECT m.id as id,
                     m.active as active,
                     m.name as name,
                     t.name as type,
                     m.address as address,
                     r.active as verified
                FROM registrations as r
          RIGHT JOIN markers as m ON m.id = r.marker
          INNER JOIN types as t ON m.type = t.id
            ORDER BY t.name, m.name";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** get_markers_data () : ".clean_for_display ($GLOBALS['sql_database_select_error'])."</p>";
      return false;
    }

    // check that at least one marker exists.
    $num = mysql_num_rows ($result);
    if (!$num) {
      echo "<p>*** get_markers_data () : ".clean_for_display ($GLOBALS['sql_database_empty_error'])."</p>";
      return false;
    }

    // get query result as an array.
    $result = db_result_to_array ($result);

    // return the result.
    return $result;
  }

  // try to display markers.
  function display_markers ($markers) {
    // check if there are no markers.
    if (!is_array ($markers)) {
      echo "<p>".clean_for_display ($GLOBALS['there_are_no_markers'])."</p>";
      return false;
    }

    $del_target = $upd_target = $warn_target = "main_column";
    $warn_text   = "<b>&#10003</b>";
    $del_text   = "<b>x</b>";
    $old_type   = '';

    $value  = '<table class="tlist" cellpadding="5" cellspacing="0" border="1">';
    $value .= ' <tbody style="font-weight: bold;">';
    $value .= '  <tr>';
    $value .= '   <td align="center">'.clean_for_display ($GLOBALS['increasing_number']).'</td><td>'.clean_for_display ($GLOBALS['admin_man_marker_list_name']).'</td><td>'.clean_for_display ($GLOBALS['admin_man_marker_list_delete']).'</td><td>'.clean_for_display ($GLOBALS['admin_man_marker_list_warn']).'</td><td>'.clean_for_display ($GLOBALS['admin_man_marker_list_active']).'</td><td>'.clean_for_display ($GLOBALS['admin_man_marker_list_verify']).'</td>';
    $value .= '  </tr>';

    // create each url link for each type.
    foreach ($markers as $row) {
      // store table row for current type.
      if (clean_for_display ($row['type']) != $old_type) {
        $value .= '  <tr>';
        $value .= '   <td style="padding: 10px;" class="nowrap" valign="middle" colspan="6">'.clean_for_display ($row['type']).'</td>';
        $value .= '  </tr>';

        $i = '';
      }

      // get the type and the visibility status.
      $old_type = clean_for_display ($row['type']);
      $active   = clean_for_display ($row['active']);

      // get data for the update link.
      $upd_url   = 'http://'.clean_for_display (CONF_WEB_DOMA).'/'.DIR_ADMIN.'/'.DIR_TYPE_MARKER.'/'.FILE_UPD_MARKER_FORM.'?mid='.clean_for_display ($row['id']);
      $upd_title = clean_for_display ($row['address']);
      $upd_text  = clean_for_display ($row['name']);

      // get data for the remove link.
      $del_url = 'http://'.clean_for_display (CONF_WEB_DOMA).'/'.DIR_ADMIN.'/'.DIR_TYPE_MARKER.'/'.FILE_DEL_MARKER_PROC.'?mid='.clean_for_display ($row['id']);

      // get data for the warning link.
      $warn_url = 'http://'.clean_for_display (CONF_WEB_DOMA).'/'.DIR_ADMIN.'/'.DIR_TYPE_MARKER.'/'.FILE_WARN_MARKER_PROC.'?mid='.clean_for_display ($row['id']);

      // store table rows for markers.
      $value .= ' <tr>';
      $value .= '  <td align="center" width="40">'. ++$i.'</td>';
      $value .= '  <td class="nowrap">'.do_html_link ($upd_url, $upd_text, $upd_target, $upd_title).'</td>';
      $value .= '  <td align="center" class="nowrap">'.do_html_link ($del_url, $del_text, $del_target, '', 'onclick="return confirm ('."'".clean_for_display ($GLOBALS['continue_asking'])."'".');"').'</td>';
      $value .= '  <td align="center" class="nowrap">'.do_html_link ($warn_url, $warn_text, $warn_target, '', 'onclick="return confirm ('."'".clean_for_display ($GLOBALS['continue_asking'])."'".');"').'</td>';
      $value .= '  <td align="center">'.($active ? get_active_icon () : get_inactive_icon ()).'</td>';
      $value .= '  <td align="center">';

      // try to get the registration verification status.
      $verify = $row['verified'];

      // check if the marker is added from the admin panel (no registration exists).
      if (is_null ($verify)) {
        $value .= get_active_icon ();
      } else {
        $value .= ($verify ? get_inactive_icon () : get_active_icon ());
      }

      $value .= '  </td>';
      $value .= ' </tr>';
    }

    $value .= ' </tbody>';
    $value .= '</table>';

    return $value;
  }

  // try to delete a marker.
  function delete_marker ($mid) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** delete_marker () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create a sql query for checking the existence of the marker id.
    $query = "SELECT id FROM markers WHERE id = '".clean_user_data ($mid)."' LIMIT 1";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** delete_marker () : ".clean_for_display ($GLOBALS['sql_database_select_error'])."</p>";
      return false;
    }

    // check for a marker with the given id.
    $num = mysql_num_rows ($result);
    if (!$num) {
      echo "<p>".clean_for_display ($GLOBALS['admin_del_marker_missing'])."</p>";
      return false;
    }

    // BEGIN a db transaction.
    mysql_query ("BEGIN");

    // create a sql query for deleting any content of the marker.
    $query = "DELETE FROM contents WHERE marker = '".clean_user_data ($mid)."' LIMIT 1";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** delete_marker (1) : ".clean_for_display ($GLOBALS['sql_database_delete_error'])."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }

    // create a sql query for deleting possible registration of the marker.
    $query = "DELETE FROM registrations WHERE marker = '".clean_user_data ($mid)."' LIMIT 1";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** delete_marker (2) : ".clean_for_display ($GLOBALS['sql_database_delete_error'])."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }

    // create a sql query for deleting the marker.
    $query = "DELETE FROM markers WHERE id = '".clean_user_data ($mid)."' LIMIT 1";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** delete_marker (3) : ".clean_for_display ($GLOBALS['sql_database_delete_error'])."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }

    // COMMIT the db transaction.
    mysql_query ("COMMIT");

    // the marker is deleted.
    echo "<p>".clean_for_display ($GLOBALS['admin_del_marker_deleted'])."</p>";
    return true;
  }

  // try to get a select box with files from a directory.
  function select_file ($path, $selected, $select_name, $style) {
    // check if the directory exists and is also readable.
    if (!is_dir ("$path") || !is_readable ("$path")) {
      echo "<p>*** select_file () : ".clean_for_display ($GLOBALS['dir_access_error'])."</p>";
      return false;
    }

    // try to open the directory.
    if ($dir = opendir ($path)) {
      // start reading its files.
      while ($file = readdir ($dir))
        // do not accept directories.
        if (!is_dir ($path.'/'.$file))
          // ignore parent and current directory.     
          if ($file != ".." && $file != ".")
            // ignore hidden files.
            if (!($file[0] == '.'))
              // store the file.
              $filelist[] = $file;
    }

    // close directory.
    closedir ($dir);

    // create the open select box tag.
    $stype = '<select style="'.$style.'" name="'.$select_name.'">';

    // sort all files.
    asort ($filelist);

    // check if there are any files in the directory.
    if (count ($filelist) != 0) {
      // for each file create an option tag.
      while (list ($key, $val) = each ($filelist)) {
        // add the current option tag.
        $stype .= '<option value="'.$val.'"';
        if ($val == $selected)
          $stype .= ' selected';
        $stype .= '>'.$val.'</option>';
      }
    }

    // add the close select box tag.
    $stype .= '</select>';

    return $stype;
  }
?>
