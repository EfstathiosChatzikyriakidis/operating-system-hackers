<?php
  // define communication functions.

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

  // try to send an html email.
  function send_html_email ($html, $from, $to, $subject) {
    // try to validate both source & destination email addresses.
    if (!valid_email ($from) || !valid_email ($to))
      return false;

    // create the headers of the email.
    $headers  = "From: " . $from                         . "\r\n";
    $headers .= "MIME-Version: 1.0"                      . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

    // try to send the email by using the PHP mail facility.
    if (mail ($to, $subject, $html, $headers))
      return true;
    else
      return false;
  }
?>
