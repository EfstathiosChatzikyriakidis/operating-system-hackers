<?php
  // define fetching functions for markers' types.

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

  // try to fetch the markers' types.
  function get_markers_types () {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** get_markers_types () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create a sql query for getting markers' types.
    $query = "SELECT * FROM types ORDER BY name";

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** get_markers_types () : ".clean_for_display ($GLOBALS['sql_database_select_error'])."</p>";
      return false;
    }

    // check that at least one type exists.
    $num = mysql_num_rows ($result);
    if (!$num) {
      echo "<p>*** get_markers_types () : ".clean_for_display ($GLOBALS['sql_database_empty_error'])."</p>";
      return false;
    }

    // get query result as an array.
    $result = db_result_to_array ($result);

    // return the result.
    return $result;
  }

  // try to fetch top types.
  function get_top_types ($top) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo "<p>*** get_top_types () : ".clean_for_display ($GLOBALS['sql_database_connect_error'])."</p>";
      return false;
    }

    // create a sql query for getting top types.
    $query = "SELECT t.name,
                     COUNT(t.id) as count
                FROM markers as m
          INNER JOIN types as t ON m.type = t.id
               WHERE m.active = '1'
            GROUP BY t.name
            ORDER BY COUNT(t.id) DESC
               LIMIT ".clean_user_data ($top);

    // execute and check the result of the query.
    $result = mysql_query ($query);
    if (!$result) {
      echo "<p>*** get_top_types () : ".clean_for_display ($GLOBALS['sql_database_select_error'])."</p>";
      return false;
    }

    // get query result as an array.
    $result = db_result_to_array ($result);

    // return the result.
    return $result;
  }
?>
