<?php
  // include main module.
  require_once ("vs-cms-fns.php");

  // check for the existence of a HTTP marker id.
  if (isset ($_GET['mid']) && !empty ($_GET['mid'])) {
    // get the HTTP marker id.
    $mid = clean_user_data ($_GET['mid']);

    // try to get the marker's data.
    $mdata = get_marker_data ($mid);
    
    // check if there was an error while getting marker's data.
    if (!$mdata) die ();

    // get some values of the marker's data.
    $marker_name  = clean_for_display ($mdata['name']);
    $marker_email = clean_for_display ($mdata['email']);
  }
  else
    die (clean_for_display ($security_file_insuff_params_error));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<!--
  Copyright (C) 2011  Efstathios Chatzikyriakidis <contact@efxa.org>

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

    <link rel="icon" type="image/png" href="<?php echo '../../'.DIR_GRAPHICS.'/'.FILE_FAVICON; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo '../../'.DIR_CSS.'/'.FILE_CSS_MAIN; ?>">
  </head>

  <body>
    <table cellpadding="30" cellspacing="0" border="0" class="hundred">
      <tbody>
        <tr>
          <td class="side_box" valign="top">
            <table cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td><b><?php echo clean_for_display ($admin_warn_marker_process); ?></b></td>
                </tr>
                <tr>
                  <td height="1"><?php echo space (1, 10); ?></td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">
                    <?php
                      // try to send to the user an email to warn him/her.
                      if (send_html_email (
                              '<p>'.$marker_name.', </p><p>'.clean_for_display ($GLOBALS['warn_sending_mail_body']).'</p>',
                              clean_for_display (CONF_MAIL_ADDR),
                              $marker_email,
                              clean_for_display (CONF_WEB_NAME).' - '.clean_for_display ($GLOBALS['warn_sending_mail_subj']))) {
                        echo "<p>".clean_for_display ($GLOBALS['warn_sending_mail_done'])."</p>";
                      }
                      else {
                        echo "<p>".clean_for_display ($GLOBALS['warn_sending_mail_fail'])."</p>";
                      }
                    ?>
                  </td>
                </tr>
                <tr>
                  <td height="1"><?php echo space (1, 10); ?></td>
                </tr>
                <tr>
                  <td><b><?php echo clean_for_display ($navigate_goto_text); ?>&nbsp;[ <?php echo do_html_link (FILE_MAN_MARKER_LIST, clean_for_display ($navigate_list_text)); ?> ]</b></td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>
