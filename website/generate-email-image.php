<?php
  // generate dynamically email as image for spamming purposes.

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

  // include main module.
  require_once ("vs-cms-fns.php");

  // start install process if configuration is empty.
  if (filesize (FILE_CONFIGURATION) == 0)
    header ("Location: ".DIR_ADMIN.'/'.FILE_INSTALL_FORM);

  // send to the browser the type of the following data.
  header ("Content-type: image/png");

  // send to the browser the system's email as an image.
  imagepng (text2image (CONF_MAIL_ADDR));
?>
