<?php
  // generate markers data XML representation (depending on search).

  /*
   *  Copyright (C) 2012  Demothenes Koptsis <demosthenesk@gmail.com>
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

  // assume searching for nothing.
  $search = '';

  // check for the existence of HTTP keywords.
  if (isset ($_GET['keywords']) && !empty ($_GET['keywords'])) {
    $search = clean_user_data ($_GET['keywords']);
  }

  // try to search markers data.
  $markers = search_markers ($search);
  if (!is_array ($markers))
    die("*** search-generate-markers-xml : ".clean_for_display ($GLOBALS['dao_generic_logic_error']));

  // send to the browser the type of the following data.
  header("Content-type: text/xml");

  // send to the browser the XML document.
  echo markers_xml_document ($markers);
?>
