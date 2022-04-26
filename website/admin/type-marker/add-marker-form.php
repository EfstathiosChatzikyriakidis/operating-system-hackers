<?php
  // include main module.
  require_once ("vs-cms-fns.php");

  // start install process if configuration is empty.
  if (filesize ('../../'.FILE_CONFIGURATION) == 0)
    header ("Location: ".'../'.FILE_INSTALL_FORM);
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

    <link rel="icon" type="image/png" href="<?php echo '../../'.DIR_GRAPHICS.'/'.FILE_FAVICON; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo '../../'.DIR_CSS.'/'.FILE_CSS_MAIN; ?>">

    <script type="text/javascript" src="<?php echo '../../'.DIR_COMPONENTS."/tinymce/tiny_mce.js"; ?>"></script>
    <script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;hl=<?php echo clean_for_display (CONF_GAPI_LNG); ?>&amp;key=<?php echo clean_for_display (CONF_GAPI_KEY); ?>"></script>

    <script type="text/javascript">
      //<![CDATA[
      var map = null;
      var geocoder = null;

      var centerLat = 40.668178;
      var centerLng = 22.911115;

      var searchZoomLevel = 15;

      function init_google_map () {
        if (GBrowserIsCompatible ()) {
          map = new GMap2 (document.getElementById ("map_canvas"));

          map.setCenter (new GLatLng (centerLat, centerLng), 2);
          map.setUIToDefault ();
          map.enableContinuousZoom();
          map.enableRotation();

          G_PHYSICAL_MAP.getMinimumResolution = function () { return 2 };
          G_NORMAL_MAP.getMinimumResolution = function () { return 2 };
          G_SATELLITE_MAP.getMinimumResolution = function () { return 2 };
          G_HYBRID_MAP.getMinimumResolution = function () { return 2 };
          
          geocoder = new GClientGeocoder ();

          GEvent.addListener (map, "singlerightclick", function (point) {
            if (point) {
              var latlng = map.fromContainerPixelToLatLng (point);
              var marker = new GMarker (latlng, {draggable: true});

              GEvent.addListener (marker, "dragend", function () {
                var point = marker.getPoint ();
                geocoder.getLocations (point, handleLocation);
              });

              map.clearOverlays ();
              map.addOverlay (marker);

              geocoder.getLocations (latlng, handleLocation);
            }
          });
        }
        else
          alert ("<?php echo clean_for_display ($gmap_browser_err); ?>");
      }

      function handleLocation (response) {
        if (!response || response.Status.code != 200) {
          document.add_marker_form.marker_lat.value  = "";
          document.add_marker_form.marker_lng.value  = "";

          alert ("<?php echo clean_for_display ($gmap_error_place); ?>");
        }
        else {
          var location = response.name.split (",");
          document.add_marker_form.marker_lat.value  = location[0];
          document.add_marker_form.marker_lng.value  = location[1];
        }
      }

      function showAddress (address) {
        if (geocoder)
          geocoder.getLatLng (address, function (point) {
                                         if (point) {
                                           map.setCenter (point, searchZoomLevel);
                                           var marker = new GMarker (point, {draggable: true});

                                           GEvent.addListener (marker, "dragend", function () {
                                             var point = marker.getPoint ();
                                             geocoder.getLocations (point, handleLocation);
                                           });

                                           map.clearOverlays ();
                                           map.addOverlay (marker);

                                           geocoder.getLocations (point, handleLocation);
                                         }
                                       });
      }

      tinyMCE.init({
        mode: "textareas",
        theme : "advanced",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align    : "left",
        entity_encoding                 : "raw",
        nonbreaking_force_tab           : true,

        theme_advanced_buttons1 : "bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,outdent,indent,separator,undo,redo",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : ""
      });
      //]]>
    </script>
  </head>

  <body onload="init_google_map ();" onunload="GUnload ();">
    <table cellpadding="30" cellspacing="0" border="0" class="hundred">
      <tbody>
        <tr>
          <td class="side_box" valign="top">
            <table cellspacing="0" cellpadding="0" border="0" class="hundred">
              <tbody>
                <tr>
                  <td><b><?php echo clean_for_display ($privacy_policy_title); ?></b></td>
                </tr>
                <tr>
                  <td><?php echo space (1, 15); ?></td>
                </tr>
                <tr>
                  <td><?php echo clean_for_display ($privacy_policy_rules); ?></td>
                </tr>
                <tr>
                  <td><?php echo space (1, 15); ?></td>
                </tr>
                <tr>
                  <td><b><?php echo clean_for_display ($account_restrictions_title); ?></b></td>
                </tr>
                <tr>
                  <td><?php echo space (1, 15); ?></td>
                </tr>
                <tr>
                  <td><?php echo $account_restrictions_rules; ?></td>
                </tr>
                <tr>
                  <td><b><?php echo clean_for_display ($admin_add_marker_form_title); ?></b></td>
                </tr>
                <tr>
                  <td><?php echo space (1, 15); ?></td>
                </tr>
                <tr>
                  <td>
                    <form method="post" name="add_marker_form" action="<?php echo FILE_ADD_MARKER_PROC; ?>">
                      <table cellpadding="0" cellspacing="0" class="hundred" border="0">
                        <tbody>
                          <tr>
                            <td class="fieldset">
                              <table cellpadding="0" cellspacing="0" border="0" class="hundred">
                                <tbody>
                                  <tr>
                                    <td>
                                      <table cellpadding="0" cellspacing="0" border="0" class="hundred">
                                        <tbody>
                                          <tr>
                                            <td width="1" valign="top">
                                              <table cellpadding="0" cellspacing="0" border="0">
                                                <tbody>
                                                  <tr>
                                                    <td class="nowrap"><?php echo clean_for_display ($admin_add_marker_form_name); ?></td>
                                                    <td><?php echo input_text ('marker_name', 'width: 200px;'); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td class="nowrap"><?php echo clean_for_display ($admin_add_marker_form_type); ?></td>
                                                    <td><?php echo select_type ('', "marker_type", clean_for_display ($select_type_default_choose), 'width: 200px;'); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td class="nowrap"><?php echo clean_for_display ($admin_add_marker_form_url); ?></td>
                                                    <td>
                                                      <table cellpadding="0" cellspacing="0" border="0">
                                                        <tbody>
                                                          <tr>
                                                            <td align="right" width="50">http://</td>
                                                            <td><?php echo input_text ('marker_url', 'width: 150px;'); ?></td>
                                                          </tr>
                                                        </tbody>
                                                      </table>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td class="nowrap"><?php echo clean_for_display ($admin_add_marker_form_email); ?></td>
                                                    <td><?php echo input_text ('marker_email', 'width: 200px;'); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td class="nowrap"><?php echo clean_for_display ($admin_add_marker_form_active); ?></td>
                                                    <td><?php echo select_boolean ('marker_active', 'width: 200px;'); ?></td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td width="1" valign="top">
                                              <table cellpadding="0" cellspacing="0" border="0">
                                                <tbody>
                                                  <tr>
                                                    <td class="nowrap"><?php echo clean_for_display ($admin_add_marker_form_addr); ?></td>
                                                    <td><?php echo input_text ('marker_addr', 'width: 200px;', ''); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td class="nowrap"><?php echo clean_for_display ($admin_add_marker_form_lat); ?></td>
                                                    <td><?php echo input_text ('marker_lat', 'width: 200px;', '', 'readonly'); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td class="nowrap"><?php echo clean_for_display ($admin_add_marker_form_lng); ?></td>
                                                    <td><?php echo input_text ('marker_lng', 'width: 200px;', '', 'readonly'); ?></td>
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
                                    <td><?php echo space (1, 8); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_add_marker_form_loc); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo space (1, 8); ?></td>
                                  </tr>
                                  <tr>
                                    <td align="center"><i><?php echo clean_for_display ($admin_add_marker_form_map); ?></i></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo space (1, 10); ?></td>
                                  </tr>
                                  <tr>
                                    <td align="center">
                                      <table cellpadding="0" cellspacing="0" border="0">
                                        <tbody>
                                          <tr>
                                            <td><?php echo clean_for_display ($search_anything_header_title); ?></td>
                                            <td><?php echo input_text ('search_address', 'width: 180px;'); ?></td>
                                            <td style="padding-left: 15px;"><?php echo do_html_link ("#", do_html_img ('../../'.DIR_GRAPHICS.'/submit.png'), '', '', 'onclick="showAddress(document.add_marker_form.search_address.value);"'); ?></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td><?php echo space (1, 12); ?></td>
                                  </tr>
                                  <tr>
                                    <td><div id="map_canvas" style="width: 100%; height: 400px; border: 1px #000000 solid;"></div></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo space (1, 8); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($admin_add_marker_form_text); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo space (1, 8); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo input_textarea ('marker_text', 'width: 100%; height: 400px;'); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo space (1, 15); ?></td>
                                  </tr>
                                  <tr>
                                    <td align="right">
                                      <?php
                                        echo input_button ('image', 'submit', "../../".DIR_GRAPHICS."/submit.png", 'border: 0px; background-color: transparent;');
                                        echo space (10, 1);
                                        echo do_html_link (FILE_ADD_MARKER_FORM, do_html_img ('../../'.DIR_GRAPHICS.'/clear.png'));
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
