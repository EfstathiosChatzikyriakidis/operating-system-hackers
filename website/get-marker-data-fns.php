<?php
  // define fetching functions for markers' data.

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

  // try to fetch the data of a marker.
  function get_marker_data ($mid) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** get_marker_data () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create a sql query for getting marker's data.
    $query = "SELECT m.*, c.*, t.*,
                     m.name as name,
                     m.type as tid,
                     t.name as type
                FROM markers as m
          INNER JOIN contents as c ON m.id = c.marker
          INNER JOIN types as t ON m.type = t.id
               WHERE c.marker = '".clean_user_data ($mid)."'
               LIMIT 1";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** get_marker_data () : ".clean_for_display ($GLOBALS['sql_database_select_error'])."</p>";
      return false;
    }

    // check that at least one marker exists.
    $num = mysql_num_rows ($result);
    if (!$num) {
      echo "<p>*** get_marker_data () : ".clean_for_display ($GLOBALS['sql_database_empty_error'])."</p>";
      return false;
    }

    // get query result as an array.
    $result = mysql_fetch_array ($result);

    // return the result.
    return $result;
  }

  // try to check if the email exists in the system.
  function email_exists ($email) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** email_exists () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create a sql query for checking an email.
    $query = "SELECT COUNT(*) FROM contents WHERE email = '".clean_user_data ($email)."'";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** email_exists () : ".clean_for_display ($GLOBALS['sql_database_select_error'])."</p>";
      return false;
    }

    // check to see if the email exists.
    if (mysql_result ($result, 0, 0) > 0)
      return true;

    return false;
  }

  // try to retrieve markers data with multi-word searching.
  function search_markers ($search_value) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** search_markers () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // symbols that will be removed from the search value.
    $symbols = array ("!", "#", "$", "%", "`",
                      "(", ")", "*", "+", ",",
                      "-", ".", ":", ";", "<",
                      "=", ">", "?", "@", "[",
                      "]", "^", "_", "{", "/",
                      "}", "|", "~", "&", "\\");

    // clean search value.
    $search_value = clean_user_data ($search_value);

    // perform filtering in order to fetch a secure search value.
    $search_value = purge_inside_spaces (str_replace ($symbols, " ", $search_value));

    // remove any surplus white spaces from left and right.
    $search_value = trim ($search_value);

    // if the search value is empty return an empty array.
    if (empty ($search_value)) return array ();

    // split search value and get the keywords.
    $keywords = explode (" ", $search_value);

    // array of clauses for each keyword.
    $clauses = array ();

    // construct a clause for each keyword.
    foreach ($keywords as $keyword) {
      $clauses[] = "(m.name  LIKE '%$keyword%' OR
                     t.name  LIKE '%$keyword%' OR
                     c.email LIKE '%$keyword%' OR
                     c.url   LIKE '%$keyword%' OR
                     c.text  LIKE '%$keyword%')";
    }

    // unite the clauses with the 'AND' operator.
    $clause = implode (' AND ' , $clauses);

    // create a sql query for getting markers' data.
    $query = "SELECT m.*
                FROM markers as m
          INNER JOIN contents as c ON m.id = c.marker
          INNER JOIN types as t ON m.type = t.id
               WHERE m.active = '1'
                 AND ($clause)";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** search_markers () : ".clean_for_display ($GLOBALS['sql_database_select_error'])."</p>";
      return false;
    }

    // get query result as an array.
    $result = db_result_to_array ($result);

    // return the result.
    return $result;
  }

  // try to retrieve markers data by type.
  function get_markers_data_by_type ($tid) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** get_markers_data_by_type () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create a sql query for getting markers' data.
    $markers_query = "SELECT m.*
                        FROM markers as m
                  INNER JOIN types as t ON m.type = t.id
                       WHERE m.active = '1'";

    if (!empty ($tid)) {
      // get the type id.
      $type = clean_user_data ($tid);

      // create a sql query for checking the existence of the type id.
      $query = "SELECT id FROM types WHERE id = '$type' LIMIT 1";

      // execute and check the result of the query.
      $result = mysql_query ($query);
      if (!$result) {
        echo "<p>*** get_markers_data_by_type () : ".clean_for_display ($GLOBALS['sql_database_select_error'])."</p>";
        return false;
      }

      // check that a type with the specified id exists.
      $num = mysql_num_rows ($result);
      if ($num)
        // change the sql query for getting specific markers.
        $markers_query = "SELECT m.*
                            FROM markers as m
                      INNER JOIN types as t ON m.type = t.id
                           WHERE m.type = '$type'
                             AND m.active = '1'";
    }

    // execute and check the result of the query.
    $result = mysql_query ($markers_query);
    if (!$result) {
      echo "<p>*** get_markers_data_by_type () : ".clean_for_display ($GLOBALS['sql_database_select_error'])."</p>";
      return false;
    }

    // get query result as an array.
    $result = db_result_to_array ($result);

    // return the result.
    return $result;
  }
?>
