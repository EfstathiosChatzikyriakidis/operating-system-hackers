<?php
  // include main module.
  require_once ("vs-cms-fns.php");

  // start install process if configuration is empty.
  if (filesize ('../'.FILE_CONFIGURATION) == 0)
    header ("Location: ".FILE_INSTALL_FORM);
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

    <link rel="icon" type="image/png" href="<?php echo '../'.DIR_GRAPHICS.'/'.FILE_FAVICON; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo '../'.DIR_CSS.'/'.FILE_CSS_INDEX; ?>">
  </head>

  <body>
    <table cellpadding="0" cellspacing="30" border="0" class="hundred">
      <tbody>
        <tr>
          <td class="side_box" colspan="2" height="1">
            <table cellpadding="0" cellspacing="0" border="0" class="hundred">
              <tbody>
                <tr>
                  <td style="padding: 10px;">
                    <b><?php echo clean_for_display (CONF_WEB_DESC); ?></b>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <iframe class="hundred" src="<?php echo FILE_WELCOME; ?>" name="main_column" frameborder="0"></iframe>
          </td>
          <td width="1">
            <table cellpadding="0" cellspacing="0" border="0" class="hundred">
              <tbody>
                <tr>
                  <td class="side_box" height="1">
                    <table cellpadding="20" cellspacing="0" border="0" class="hundred">
                      <tbody>
                        <tr>
                          <td align="center">
                            <table cellpadding="0" cellspacing="0" border="0">
                              <tbody>
                                <tr>
                                  <td align="center" class="nowrap"><b><?php echo clean_for_display (CONF_WEB_NAME); ?></b></td>
                                </tr>
                                <tr>
                                  <td align="center" style="padding: 10px;"><?php echo do_html_img ('../'.DIR_GRAPHICS.'/logo-image-1.png'); ?></td>
                                </tr>
                                <tr>
                                  <td align="center" class="nowrap"><b><?php echo clean_for_display (CONF_WEB_VERS); ?></b></td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td height="1"><?php echo space (1, 15); ?></td>
                </tr>
                <tr>
                  <td class="side_box" height="1">
                    <table cellpadding="10" cellspacing="0" border="0" class="hundred">
                      <tbody>
                        <tr>
                          <td align="center">
                            <?php echo do_html_img ('../'.FILE_IMG_GEN_EMAIL); ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td height="1"><?php echo space (1, 15); ?></td>
                </tr>
                <tr>
                  <td class="side_box">
                    <table cellpadding="20" cellspacing="0" border="0" class="hundred">
                      <tbody>
                        <tr>
                          <td>
                            <table cellpadding="0" cellspacing="0" border="0" class="hundred">
                              <tbody valign="top">
                                <tr>
                                  <td align="center" class="nowrap" height="1">
                                    <strong>[ <?php echo clean_for_display ($admin_manage_text); ?> ]</strong>
                                  </td>
                                </tr>
                                <tr>
                                  <td height="1"><?php echo space (1, 16); ?></td>
                                </tr>
                                <tr>
                                  <td class="nowrap">
                                    <strong>
                                      - <?php echo do_html_link (DIR_TYPE_MARKER.'/'.FILE_ADD_TYPE_MARKER, clean_for_display ($admin_op_add_type_marker), 'main_column'); ?><br>
                                      - <?php echo do_html_link (DIR_TYPE_MARKER.'/'.FILE_MAN_TYPE_MARKER, clean_for_display ($admin_op_man_type_marker), 'main_column'); ?><br>
                                    </strong>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td class="side_box" colspan="2" height="1">
            <table cellpadding="0" cellspacing="0" border="0" class="hundred">
              <tbody>
                <tr>
                  <td style="padding: 10px;">
                    <b><?php echo $bottom_l_msg.' '.$bottom_r_msg; ?></b>
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
