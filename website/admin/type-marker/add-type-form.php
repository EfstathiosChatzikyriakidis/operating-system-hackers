<?php
  // include main module.
  require_once ("vs-cms-fns.php");

  // start install process if configuration is empty.
  if (filesize ('../../'.FILE_CONFIGURATION) == 0)
    header ("Location: ".'../'.FILE_INSTALL_FORM);
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
                  <td style="padding-left: 12px;"><b><?php echo clean_for_display ($admin_add_type_form_title); ?></b></td>
                </tr>
                <tr>
                  <td><?php echo space (1, 15); ?></td>
                </tr>
                <tr>
                  <td>
                    <form method="post" name="add_type_form" action="<?php echo FILE_ADD_TYPE_PROC; ?>">
                      <table cellpadding="0" cellspacing="0" class="fieldset" border="0">
                        <tbody>
                          <tr>
                            <td>
                              <table cellpadding="0" cellspacing="0" border="0">
                                <tbody>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_add_type_form_name); ?></td>
                                    <td><?php echo input_text ('type_name', 'width: 230px;'); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_add_type_form_image); ?></td>
                                    <td><?php echo select_file ('../../'.DIR_GRAPHICS.'/markers-icons', '', "type_image", 'width: 230px;'); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 15); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo space (); ?></td>
                                    <td align="right">
                                      <?php
                                        echo input_button ('image', 'submit', "../../".DIR_GRAPHICS."/submit.png", 'border: 0px; background-color: transparent;');
                                        echo space (10, 1);
                                        echo do_html_link (FILE_ADD_TYPE_FORM, do_html_img ('../../'.DIR_GRAPHICS.'/clear.png'));
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
