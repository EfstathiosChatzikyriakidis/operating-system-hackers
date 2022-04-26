<?php
  // define security functions.

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

  // try to prepare a one-line string for displaying.
  function clean_for_display ($string) {
    return stripslashes (strip_tags (trim ($string)));
  }

  // try to ensure that a one-line string can be used in secure.
  function clean_user_data ($string) {
    return addslashes (strip_tags (trim ($string)));
  }

  // try to prepare a multi-line string for displaying.
  function pretty_for_display ($string) {
    return nl2br (stripslashes (trim ($string)));
  }

  // try to ensure that a multi-line string can be used in secure.
  function pretty_user_data ($string) {
    return addslashes (trim ($string));
  }

  // try to get a random unique key.
  function get_unique_id ($id = NULL, $salt = NULL, $size = NULL) {
    $id = ($id == NULL) ? uniqid (hash ("sha512", rand ()), TRUE) : $id;
    $code = hash ("sha512", $id.$salt);
    return $size == NULL ? $code : substr ($code, 0, $size);
  }
?>
