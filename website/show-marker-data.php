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

    // get each value of the marker's data.
    $marker_name_value    = clean_for_display ($mdata['name']);
    $marker_lat_value     = clean_for_display ($mdata['lat']);
    $marker_lng_value     = clean_for_display ($mdata['lng']);
    $marker_address_value = clean_for_display ($mdata['address']);
    $marker_type_value    = clean_for_display ($mdata['type']);
    $marker_email_value   = clean_for_display ($mdata['email']);
    $marker_url_value     = clean_for_display ($mdata['url']);
    $marker_text_value    = pretty_for_display ($mdata['text']);
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

    <link rel="icon" type="image/png" href="<?php echo DIR_GRAPHICS.'/'.FILE_FAVICON; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo DIR_CSS.'/'.FILE_CSS_MAIN; ?>">
  </head>

  <body>
    <table cellpadding="10" cellspacing="0" border="0" class="hundred">
      <tbody>
        <tr>
          <td>
            <table cellspacing="5" cellpadding="0" border="0" class="hundred">
              <tbody valign="top">

                <?php if (utf8_strlen ($marker_name_value) > 0) { ?>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_name); ?></td>
                  <td style="text-align: justify;" class="width_hundred"><b><?php echo $marker_name_value; ?></b></td>
                </tr>
                <?php } ?>

                <?php if (utf8_strlen ($marker_address_value) > 0) { ?>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_address); ?></td>
                  <td style="text-align: justify;"><b><?php echo $marker_address_value; ?></b></td>
                </tr>
                <?php } ?>

                <?php if (utf8_strlen ($marker_lat_value) > 0) { ?>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_lat); ?></td>
                  <td><?php echo $marker_lat_value; ?></td>
                </tr>
                <?php } ?>

                <?php if (utf8_strlen ($marker_lng_value) > 0) { ?>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_lng); ?></td>
                  <td><?php echo $marker_lng_value; ?></td>
                </tr>
                <?php } ?>

                <?php if (utf8_strlen ($marker_type_value) > 0) { ?>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_type); ?></td>
                  <td><?php echo $marker_type_value; ?></td>
                </tr>
                <?php } ?>

                <?php if (utf8_strlen ($marker_email_value) > 0) { ?>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_email); ?></td>
                  <td><b><?php echo do_html_link ("mailto:".$marker_email_value, $marker_email_value); ?></b></td>
                </tr>
                <?php } ?>

                <?php if (utf8_strlen ($marker_url_value) > 0) { ?>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_url); ?></td>
                  <td><b><?php echo do_html_link ("http://".$marker_url_value, "http://".$marker_url_value, "_blank"); ?></b></td>
                </tr>
                <?php } ?>

                <?php $text_length = utf8_strlen ($marker_text_value); ?>

                <?php if ($text_length > 0) { ?>
                <tr>
                  <td colspan="2"><?php echo space (); ?></td>
                </tr>
                <?php } ?>

                <tr>
                  <td class="height_hundred" colspan="2" style="text-align: justify;">
                    <?php
                      if ($text_length > 0) {
                        echo '<p>'.clean_for_display ($marker_text).'</p>';
                        echo $marker_text_value;
                      }
                    ?>
                  </td>
                </tr>

                <?php if ($text_length > 0) { ?>
                <tr>
                  <td colspan="2"><?php echo space (1, 5); ?></td>
                </tr>
                <tr>
                  <td colspan="2"><b><?php echo do_html_link ("#top", clean_for_display ($general_toplink)); ?></b></td>
                </tr>
                <?php } ?>

              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>
