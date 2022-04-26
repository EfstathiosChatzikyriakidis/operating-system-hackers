<?php
  // include main module.
  require_once ("vs-cms-fns.php");

  if (!defined ('CONF_WEB_DOMA'))
    define ('CONF_WEB_DOMA' , clean_for_display ($_SERVER['HTTP_HOST']));
  
  if (!defined ('CONF_WEB_TITL'))
    define ('CONF_WEB_TITL' , clean_for_display ($admin_install_init_webname));

  if (!defined ('CONF_WEB_DESC'))
    define ('CONF_WEB_DESC' , clean_for_display ($admin_install_init_webdesc));

  if (!defined ('CONF_WEB_KEYS'))
    define ('CONF_WEB_KEYS' , clean_for_display ($admin_install_init_webkeys));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<!--
  Copyright (C) 2011  Efstathios Chatzikyriakidis <stathis.chatzikyriakidis@gmail.com>

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program. If not, see <http://www.gnu.org/licenses/>.
-->

<html>
  <head>
    <title><?php echo clean_for_display (CONF_WEB_TITL); ?></title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="keywords" content="<?php echo clean_for_display (CONF_WEB_KEYS); ?>">
    <meta name="description" content="<?php echo clean_for_display (CONF_WEB_DESC); ?>">

    <link rel="icon" type="image/png" href="<?php echo '../'.DIR_GRAPHICS.'/'.FILE_FAVICON; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo '../'.DIR_CSS.'/'.FILE_CSS_MAIN; ?>">
  </head>

  <body>
    <table cellpadding="30" cellspacing="0" border="0" class="hundred">
      <tbody>
        <tr>
          <td class="side_box" valign="top">
            <table cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td style="padding-left: 12px;"><b><?php echo clean_for_display ($admin_install_title); ?></b></td>
                </tr>
                <tr>
                  <td><?php echo space (1, 15); ?></td>
                </tr>
                <?php
                  // init installation configuration variables.
                  $hostname = $username = $password = $database = $webname = $webvers = $webdesc = $webkeys = $webdoma = $webtitl = $gmapikey = $gmapilng = $mailaddr = $skeysize = $gmapaddr = $statstop = "";

                  // error flag for installation process.
                  $error = true;

                  // start installation process if it is necessary.
                  
                  // check for the form normal submission.
                  if (isset ($_POST['submit_check'])) {
                    echo "<tr><td style='padding-left: 12px; font-weight: bold;'>";

                    // get installation configuration variables.
                    $hostname = clean_user_data ($_POST["hostname"]);
                    $username = clean_user_data ($_POST["username"]);
                    $password = clean_user_data ($_POST["password"]);
                    $database = clean_user_data ($_POST["database"]);

                    $webdoma = clean_user_data ($_POST["webdoma"]);
                    $webname = clean_user_data ($_POST["webname"]);
                    $webtitl = clean_user_data ($_POST["webtitl"]);
                    $webvers = clean_user_data ($_POST["webvers"]);
                    $webdesc = clean_user_data ($_POST["webdesc"]);
                    $webkeys = clean_user_data ($_POST["webkeys"]);

                    $gmapikey = clean_user_data ($_POST["gmapikey"]);
                    $gmapilng = clean_user_data ($_POST["gmapilng"]);
                    $mailaddr = clean_user_data ($_POST["mailaddr"]);
                    $skeysize = clean_user_data ($_POST["skeysize"]);
                    $gmapaddr = clean_user_data ($_POST["gmapaddr"]);
                    $statstop = clean_user_data ($_POST["statstop"]);

                    // check if there any empty field in the form.
                    if (!filled_out ($_POST))
                      echo "<p>".clean_for_display ($fill_all_form_data)."</p>";
                    else {
                      // mysql server connection.
                      $link = mysql_pconnect ($hostname, $username, $password);
                      if ($link) {
                        // set encoding for mysql connection.
                        mysql_query ("SET NAMES utf8", $link);

                        // mysql database selection.
                        if (mysql_select_db ($database, $link)) {
                          // BEGIN a db transaction.
                          mysql_query ("BEGIN");

                          // execute sql queries (create schema & insert data).
                          $query = "DROP TABLE IF EXISTS `registrations`;";
                          $r0 = mysql_query ($query, $link);
                          $query = "DROP TABLE IF EXISTS `contents`;";
                          $r1 = mysql_query ($query, $link);
                          $query = "DROP TABLE IF EXISTS `markers`;";
                          $r2 = mysql_query ($query, $link);
                          $query = "DROP TABLE IF EXISTS `types`;";
                          $r3 = mysql_query ($query, $link);

                          $query = "CREATE TABLE IF NOT EXISTS `types` (
                                      `id`    int           UNSIGNED AUTO_INCREMENT NOT NULL,
                                      `name`  varchar (256) COLLATE utf8_unicode_ci NOT NULL,
                                      `image` varchar (256) COLLATE utf8_unicode_ci NOT NULL,
                                      PRIMARY KEY (`id`)
                                    ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;";

                          $r4 = mysql_query ($query, $link);
                          $query = "INSERT INTO `types` (`id`, `name`, `image`) VALUES (1, 'Debian', 'debian.png');";
                          $r5 = mysql_query ($query, $link);

                          $query = "CREATE TABLE IF NOT EXISTS `markers` (
                                      `id`      int            UNSIGNED AUTO_INCREMENT NOT NULL,
                                      `name`    varchar (256)  COLLATE utf8_unicode_ci NOT NULL,
                                      `address` varchar (256)  COLLATE utf8_unicode_ci NOT NULL,
                                      `lat`     decimal (10,6) NOT NULL,
                                      `lng`     decimal (10,6) NOT NULL,
                                      `type`    int            UNSIGNED NOT NULL,
                                      `active`  tinyint (1)    NOT NULL DEFAULT '0',
                                      PRIMARY KEY (`id`),
                                      FOREIGN KEY (`type`) REFERENCES `types` (`id`)
                                    ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;";

                          $r6 = mysql_query ($query, $link);
                          $query = "INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`, `active`) VALUES (1, 'Efstathios Chatzikyriakidis', 'Hellas', 42.032974, 14.062500, 1, 1);";
                          $r7 = mysql_query ($query, $link);

                          $query = "CREATE TABLE IF NOT EXISTS `contents` (
                                      `id`     int           UNSIGNED AUTO_INCREMENT NOT NULL,
                                      `email`  varchar (256) COLLATE utf8_unicode_ci NOT NULL,
                                      `url`    varchar (256) COLLATE utf8_unicode_ci DEFAULT NULL,
                                      `text`   longtext      COLLATE utf8_unicode_ci DEFAULT NULL,
                                      `marker` int           UNSIGNED NOT NULL,
                                      PRIMARY KEY (`id`),
                                      FOREIGN KEY (`marker`) REFERENCES `markers` (`id`)
                                    ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;";

                          $r8 = mysql_query ($query, $link);
                          $query = "INSERT INTO `contents` (`id`, `email`, `url`, `text`, `marker`) VALUES (1, 'stathis.chatzikyriakidis@gmail.com', 'efxa.org', 'To be or not to be.', 1);";
                          $r9 = mysql_query ($query, $link);

                          $query = "CREATE TABLE IF NOT EXISTS `registrations` (
                                      `id`     int           UNSIGNED AUTO_INCREMENT NOT NULL,
                                      `skey`   varchar (256) COLLATE utf8_unicode_ci NOT NULL,
                                      `active` tinyint (1)   NOT NULL DEFAULT '0',
                                      `date`   date          NOT NULL,
                                      `marker` int           UNSIGNED NOT NULL,
                                      PRIMARY KEY (`id`),
                                      FOREIGN KEY (`marker`) REFERENCES `markers` (`id`)
                                    ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;";

                          $r10 = mysql_query ($query, $link);

                          // check if any sql query failed.
                          if (!$r0 || !$r1 || !$r2 || !$r3 || !$r4 || !$r5 || !$r6 || !$r7 || !$r8 || !$r9 || !$r10) {
                            // ROLLBACK the db transaction.
                            mysql_query ("ROLLBACK");
                          }
                          else {
                            // create configuration file.
                            if ($handle = fopen ('../'.FILE_CONFIGURATION, 'w')) {
                              $file_content = "<?php\n"                                                                                         .
                                              "  // define configuration properties.\n"                                                         .
                                              "\n"                                                                                              .
                                              "  /*\n"                                                                                          .
                                              "   *  Copyright (C) 2011  Efstathios Chatzikyriakidis <stathis.chatzikyriakidis@gmail.com>\n"    .
                                              "   *\n"                                                                                          .
                                              "   *  This program is free software: you can redistribute it and/or modify\n"                    .
                                              "   *  it under the terms of the GNU General Public License as published by\n"                    .
                                              "   *  the Free Software Foundation, either version 3 of the License, or\n"                       .
                                              "   *  (at your option) any later version.\n"                                                     .
                                              "   *\n"                                                                                          .
                                              "   *  This program is distributed in the hope that it will be useful,\n"                         .
                                              "   *  but WITHOUT ANY WARRANTY; without even the implied warranty of\n"                          .
                                              "   *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the\n"                            .
                                              "   *  GNU General Public License for more details.\n"                                            .
                                              "   *\n"                                                                                          .
                                              "   *  You should have received a copy of the GNU General Public License\n"                       .
                                              "   *  along with this program. If not, see <http://www.gnu.org/licenses/>.\n"                    .
                                              "   */\n"                                                                                         .
                                              "\n"                                                                                              .
                                              "  // mysql connection account information.\n"                                                    .
                                              "  define ('CONF_MYSQL_HOST' , '$hostname');\n"                                                   .
                                              "  define ('CONF_MYSQL_USER' , '$username');\n"                                                   .
                                              "  define ('CONF_MYSQL_PASS' , '$password');\n"                                                   .
                                              "  define ('CONF_MYSQL_DB'   , '$database');\n"                                                   .
                                              "\n"                                                                                              .
                                              "  // google maps usage properties.\n"                                                            .
                                              "  define ('CONF_GAPI_KEY' , '$gmapikey');\n"                                                     .
                                              "  define ('CONF_GAPI_LNG' , '$gmapilng');\n"                                                     .
                                              "\n"                                                                                              .
                                              "  // system address on google maps.\n"                                                           .
                                              "  define ('CONF_SYS_GMAP_ADDR' , '$gmapaddr');\n"                                                .
                                              "\n"                                                                                              .
                                              "  // email address.\n"                                                                           .
                                              "  define ('CONF_MAIL_ADDR' , '$mailaddr');\n"                                                    .
                                              "\n"                                                                                              .
                                              "  // random unique keys size.\n"                                                                 .
                                              "  define ('CONF_SKEY_SIZE' , $skeysize);\n"                                                      .
                                              "\n"                                                                                              .
                                              "  // system web domain.\n"                                                                       .
                                              "  define ('CONF_WEB_DOMA' , '$webdoma');\n"                                                      .
                                              "\n"                                                                                              .
                                              "  // system web name.\n"                                                                         .
                                              "  define ('CONF_WEB_NAME' , '$webname');\n"                                                      .
                                              "\n"                                                                                              .
                                              "  // system web version.\n"                                                                      .
                                              "  define ('CONF_WEB_VERS' , '$webvers');\n"                                                      .
                                              "\n"                                                                                              .
                                              "  // system web title.\n"                                                                        .
                                              "  define ('CONF_WEB_TITL' , '$webtitl');\n"                                                      .
                                              "\n"                                                                                              .
                                              "  // system web description.\n"                                                                  .
                                              "  define ('CONF_WEB_DESC' , '$webdesc');\n"                                                      .
                                              "\n"                                                                                              .
                                              "  // system web keywords.\n"                                                                     .
                                              "  define ('CONF_WEB_KEYS' , '$webkeys');\n"                                                      .
                                              "\n"                                                                                              .
                                              "  // statistics top types.\n"                                                                    .
                                              "  define ('CONF_STAT_TOP' , $statstop);\n"                                                       .
                                              "?>";

                              // write configuration content.
                              if (fwrite ($handle, $file_content)) {
                                echo clean_for_display ($admin_install_success);

                                // COMMIT the db transaction.
                                mysql_query ("COMMIT");

                                // the installation completed without errors.
                                $error = false;
                              }
                            }
                          }
                        }
                      }
                    }

                    // check if an error happened in the installation process.
                    if ($error)
                      echo clean_for_display ($admin_install_failure);

                    echo "</td></tr><tr><td>".space (1, 15)."</td></tr>";
                  }
                ?>
                <tr>
                  <td>
                    <form method="post" name="install_form" action="<?php echo FILE_INSTALL_FORM; ?>">
                      <table cellpadding="0" cellspacing="0" class="fieldset" border="0">
                        <tbody>
                          <tr>
                            <td>
                              <table cellpadding="0" cellspacing="0" border="0">
                                <tbody>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_hostname); ?></td>
                                    <td><?php echo input_text ('hostname', 'width: 230px;', $hostname); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_username); ?></td>
                                    <td><?php echo input_text ('username', 'width: 230px;', $username); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_password); ?></td>
                                    <td><?php echo input_text ('password', 'width: 230px;', $password); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_database); ?></td>
                                    <td><?php echo input_text ('database', 'width: 230px;', $database); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_gmapikey); ?></td>
                                    <td><?php echo input_text ('gmapikey', 'width: 230px;', $gmapikey); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_gmapilng); ?></td>
                                    <td><?php echo input_text ('gmapilng', 'width: 230px;', $gmapilng); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_gmapaddr); ?></td>
                                    <td><?php echo input_text ('gmapaddr', 'width: 230px;', $gmapaddr); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_webdoma); ?></td>
                                    <td><?php echo input_text ('webdoma', 'width: 230px;', $webdoma); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_webname); ?></td>
                                    <td><?php echo input_text ('webname', 'width: 230px;', $webname); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_webvers); ?></td>
                                    <td><?php echo input_text ('webvers', 'width: 230px;', $webvers); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_webtitl); ?></td>
                                    <td><?php echo input_text ('webtitl', 'width: 230px;', $webtitl); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_webdesc); ?></td>
                                    <td><?php echo input_text ('webdesc', 'width: 230px;', $webdesc); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_webkeys); ?></td>
                                    <td><?php echo input_text ('webkeys', 'width: 230px;', $webkeys); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_mailaddr); ?></td>
                                    <td><?php echo input_text ('mailaddr', 'width: 230px;', $mailaddr); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_skeysize); ?></td>
                                    <td><?php echo input_text ('skeysize', 'width: 230px;', $skeysize); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_install_statstop); ?></td>
                                    <td><?php echo input_text ('statstop', 'width: 230px;', $statstop); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 15); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo space (); ?></td>
                                    <td align="right">
                                      <?php
                                        echo input_button ('image', 'submit', "../".DIR_GRAPHICS."/submit.png", 'border: 0px; background-color: transparent;');
                                        echo space (10, 1);
                                        echo do_html_link (FILE_INSTALL_FORM, do_html_img ('../'.DIR_GRAPHICS.'/clear.png'));
                                      ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <input type="hidden" name="submit_check" value="1"> 
                    </form>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>
