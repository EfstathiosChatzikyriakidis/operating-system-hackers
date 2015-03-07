<?php
  // define data manipulation functions.

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

  // try to check if there are any empty fields in a form.
  function filled_out ($form_vars) {
    // for each variable in the form.
    foreach ($form_vars as $key => $value) {
      // check if the variable does not exist or has empty value.
      if (!isset ($key) || empty ($value))
        return false;
    }
    return true;
  }

  /**
   * counts the number of characters of a string in UTF-8.
   * unit-tested by Kasper and works 100% like strlen() / mb_strlen().
   *
   * @param     string        UTF-8 multibyte character string.
   * @return    integer       The number of characters.
   *
   * @author    Martin Kutschker <martin.t.kutschker@blackbox.net>
   */
  function utf8_strlen ($str) {
    $n = 0;

    for ($i = 0; isset ($str{$i}) && strlen ($str{$i}) > 0; $i++) {
      $c = ord ($str{$i});

      if (!($c & 0x80)) // single-byte (0xxxxxx).
        $n++;
      elseif (($c & 0xC0) == 0xC0) // multi-byte starting byte (11xxxxxx).
        $n++;
    }

    return $n;
  }

  // try to check an email address (syntax validation / domain existence).
  function valid_email ($email) {
    // check regexp intelligence here: http://svn.php.net/viewvc/php/php-src/trunk/ext/filter/logical_filters.c

    // regular expression for a valid email address.
    $regexp = "/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD";

    // check if the email address is not valid syntactically.
    if (!preg_match ($regexp, $email))
      return false;

    // extract the user and the domain of the email.
    list ($user, $domain) = explode ("@", $email);

    // check if the domain of the email does not exist.
    if (!checkdnsrr ($domain, 'MX'))
      return false;

    // in any other case the email is valid.
    return true;
  }

  // try to strip extra white spaces inside a string.
  function purge_inside_spaces ($text) {
    while (preg_match ('/\s{2}/', $text)) {
      $text = preg_replace ('/\s{2}/', ' ', $text);
    }

    return $text;
  }
?>
