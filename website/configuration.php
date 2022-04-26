<?php
  // define configuration properties.

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

  // mysql connection account information.
  define ('CONF_MYSQL_HOST' , '');
  define ('CONF_MYSQL_USER' , '');
  define ('CONF_MYSQL_PASS' , '');
  define ('CONF_MYSQL_DB'   , '');

  // google maps usage properties.
  define ('CONF_GAPI_KEY' , 'ABQIAAAAc0oF9g6dQKs4zbuPHcf0uxQS_arwjv4RErq5SOuTegK3ZytKYRT5j7DxCp7j6x8Tbm15CgCJzzuWdQ');
  define ('CONF_GAPI_LNG' , 'en');

  // system address on google maps.
  define ('CONF_SYS_GMAP_ADDR' , '40.668825, 22.911566');

  // email address.
  define ('CONF_MAIL_ADDR' , 'info@oshackers.org');

  // random unique keys size.
  define ('CONF_SKEY_SIZE' , 128);

  // system web domain.
  define ('CONF_WEB_DOMA' , 'oshackers.org');

  // system web name.
  define ('CONF_WEB_NAME' , 'OSHACKERS');

  // system web version.
  define ('CONF_WEB_VERS' , 'V.2.0');

  // system web title.
  define ('CONF_WEB_TITL' , 'OSHACKERS - V.2.0');

  // system web description.
  define ('CONF_WEB_DESC' , 'Visualising the Free Software / Open Source operating system users around the world !');

  // system web keywords.
  define ('CONF_WEB_KEYS' , 'map, google, gis, oshackers, hackers, operating system, free software, open source');

  // statistics top types.
  define ('CONF_STAT_TOP' , 5);
?>
