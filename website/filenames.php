<?php
  // define filenames constants.

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
   * directories.
   */

  /*
   * shared directories.
   */

  // stylesheets directory.
  define ('DIR_CSS' , 'stylesheets');

  // components directory.
  define ('DIR_COMPONENTS' , 'components');

  // graphics directory.
  define ('DIR_GRAPHICS' , 'graphics');

  // markers icons directory.
  define ('DIR_MARKERS_ICONS' , 'markers-icons');

  // javascripts directory.
  define ('DIR_JS' , 'javascripts');

  /*
   * admin directories.
   */

  // control panel directory.
  define ('DIR_ADMIN' , 'admin');

  // types, markers directory.
  define ('DIR_TYPE_MARKER' , 'type-marker');

  /*
   * files.
   */

  /*
   * shared files.
   */

  // core subsystems files (functions).
  define ('FILE_MANAGE_DATA_FNS'   , 'manage-data-fns.php');
  define ('FILE_DATABASE_FNS'      , 'db-fns.php');
  define ('FILE_OUTPUT_FNS'        , 'output-fns.php');
  define ('FILE_COMMUNICATION_FNS' , 'communication-fns.php');
  define ('FILE_GET_TYPES_FNS'     , 'get-marker-types-fns.php');
  define ('FILE_GET_MARKER_FNS'    , 'get-marker-data-fns.php');
  define ('FILE_GET_TYPE_FNS'      , 'get-type-data-fns.php');
  define ('FILE_REGISTER_FNS'      , 'register-fns.php');
  define ('FILE_SECURITY_FNS'      , 'security-fns.php');
  define ('FILE_JSON_FNS'          , 'json-fns.php');

  // core subsystems files (configuration).
  define ('FILE_WEB_MESSAGES'  , 'web-messages.php');
  define ('FILE_CONFIGURATION' , 'configuration.php');

  // css stylesheets files.
  define ('FILE_CSS_INDEX' , 'index-stylesheet.css');
  define ('FILE_CSS_MAIN'  , 'main-stylesheet.css');
  
  // index file.
  define ('FILE_INDEX' , 'index.php');

  // welcome file.
  define ('FILE_WELCOME' , 'welcome-page.php');
  
  // favicon image file.
  define ('FILE_FAVICON' , 'favicon.png');

  /*
   * normal files.
   */

  // core subsystems files (pages).
  define ('FILE_IMG_GEN_EMAIL' , 'generate-email-image.php');
  define ('FILE_SHOW_MARKER'   , 'show-marker-data.php');

  // marker registration files.
  define ('FILE_REGISTER_FORM'   , 'register-form.php');
  define ('FILE_REGISTER_PROC'   , 'register-proc.php');
  define ('FILE_REGISTER_VERIFY' , 'register-verify.php');

  /*
   * admin files.
   */

  // core subsystem file (functions).
  define ('FILE_ADMIN_FNS' , 'admin-fns.php');

  // types, markers files.
  define ('FILE_ADD_TYPE_MARKER' , 'add-type-marker.php');
  define ('FILE_MAN_TYPE_MARKER' , 'man-type-marker.php');

  define ('FILE_ADD_MARKER_FORM' , 'add-marker-form.php');
  define ('FILE_ADD_MARKER_PROC' , 'add-marker-proc.php');

  define ('FILE_ADD_TYPE_FORM' , 'add-type-form.php');
  define ('FILE_ADD_TYPE_PROC' , 'add-type-proc.php');

  define ('FILE_UPD_MARKER_FORM' , 'upd-marker-form.php');
  define ('FILE_UPD_MARKER_PROC' , 'upd-marker-proc.php');
  
  define ('FILE_UPD_TYPE_FORM' , 'upd-type-form.php');
  define ('FILE_UPD_TYPE_PROC' , 'upd-type-proc.php');

  define ('FILE_DEL_MARKER_PROC' , 'del-marker-proc.php');
  define ('FILE_DEL_TYPE_PROC'   , 'del-type-proc.php');

  define ('FILE_WARN_MARKER_PROC' , 'warn-marker-proc.php');

  define ('FILE_MAN_MARKER_LIST' , 'man-marker-list.php');
  define ('FILE_MAN_TYPE_LIST'   , 'man-type-list.php');

  // installation file.
  define ('FILE_INSTALL_FORM' , 'installation.php');
?>
