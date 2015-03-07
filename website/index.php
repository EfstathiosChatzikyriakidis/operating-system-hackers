<?php
  // include main module.
  require_once ("vs-cms-fns.php");

  // start install process if configuration is empty.
  if (filesize (FILE_CONFIGURATION) == 0)
    header ("Location: ".DIR_ADMIN.'/'.FILE_INSTALL_FORM);
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

    <!-- Javascripts -->

    <!-- jquery -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script>

    <!-- jquery ui -->
    <script type="text/javascript" src="http://code.jquery.com/ui/1.9.2/jquery-ui.min.js"></script>

    <!-- jqplot -->

    <!--[if IE]>
    <script type="text/javascript" src="http://cdn.jsdelivr.net/jqplot/1.0.0/excanvas.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="http://cdn.jsdelivr.net/jqplot/1.0.0/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="http://cdn.jsdelivr.net/jqplot/1.0.0/plugins/jqplot.pieRenderer.min.js"></script>
    <script type="text/javascript" src="http://cdn.jsdelivr.net/jqplot/1.0.0/plugins/jqplot.donutRenderer.min.js"></script>

    <!-- google maps -->
    <script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;hl=<?php echo clean_for_display (CONF_GAPI_LNG); ?>&amp;key=<?php echo clean_for_display (CONF_GAPI_KEY); ?>"></script>

    <!-- marker clusterer -->
    <script type="text/javascript" src="<?php echo DIR_JS.'/marker-clusterer.js'; ?>"></script>

    <!-- map application -->
    <script type="text/javascript" src="<?php echo DIR_JS.'/map-application.js'; ?>"></script>

    <!-- custom -->
    <script type="text/javascript" src="<?php echo DIR_JS.'/menu-operations.js'; ?>"></script>

    <!-- Stylesheets -->

    <!-- jquery ui -->
    <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.2/themes/redmond/jquery-ui.css">

    <!-- jqplot -->
    <link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/jqplot/1.0.0/jquery.jqplot.min.css">

    <!-- custom -->
    <link rel="stylesheet" type="text/css" href="<?php echo DIR_CSS.'/'.FILE_CSS_INDEX; ?>">
  </head>

  <body onload="maximize (); initializeMapApplication ();" onunload="GUnload ();">
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
          <td id="map_box">
            <div id="map_canvas"></div>
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
                                  <td align="center" style="padding: 10px;"><?php echo do_html_img (DIR_GRAPHICS.'/logo-image-1.png'); ?></td>
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
                            <?php echo do_html_img (FILE_IMG_GEN_EMAIL); ?>
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
                    <table cellpadding="0" cellspacing="20" border="0" class="hundred">
                      <tbody>
                        <tr>
                          <td height="1">
                            <p><b>[ <?php echo clean_for_display ($select_type_header_title); ?> ]</b></p>
                            <?php echo select_type ('', 'type_selection', clean_for_display ($select_type_default_showall), 'width: 140px;', 'id="type_selection"'); ?>
                          </td>
                        </tr>
                        <tr>
                          <td height="1">
                            <p><b>[ <?php echo clean_for_display ($search_anything_header_title); ?> ]</b></p>
                            <table cellpadding="0" cellspacing="0" border="0">
                              <tbody>
                                <tr>
                                  <td><?php echo input_text ('search_keywords', 'width: 138px;', '', 'id="search_keywords"'); ?></td>
                                  <td><?php echo space (10, 1); ?></td>
                                  <td><?php echo input_button ('image', 'search_button', DIR_GRAPHICS."/submit.png", 'border: 0px; width: 20px; height: 20px; background-color: transparent;', 'id="search_button"'); ?></td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td><?php echo space (1, 1); ?></td>
                        </tr>
                        <tr>
                          <td height="1">
                            <table border="0" cellpadding="4" cellspacing="0" class="hundred">
                              <tr>
                                <td class="nowrap" align="center" valign="middle">
                                  <strong>[ <?php echo do_html_link ('#', clean_for_display ($statistics_access_link), '',  '', 'id="statisticsDialogMenuItem"'); ?> ]</strong>
                                </td>
                              </tr>
                              <tr>
                                <td class="nowrap" align="center" valign="middle">
                                  <strong>[ <?php echo do_html_link ('#', clean_for_display ($locate_us_access_link), '', '', 'id="locateUsMenuItem"'); ?> ]</strong>
                                </td>
                              </tr>
                              <tr>
                                <td class="nowrap" align="center" valign="middle">
                                  <strong>[ <?php echo do_html_link (FILE_REGISTER_FORM, clean_for_display ($register_form_access_link), '_blank'); ?> ]</strong>
                               </td>
                              </tr>
                              <tr>
                                <td class="nowrap" align="center" valign="middle">
                                  <strong>[ <?php echo do_html_link ('#', clean_for_display ($information_access_link), '',  '', 'id="informationDialogMenuItem"'); ?> ]</strong>
                                </td>
                              </tr>
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

    <!-- Start Dialogs Layout -->

    <div id="informationDialogWidget" title="<?php echo clean_for_display (CONF_WEB_TITL); ?>">
      <div id="internalTabsWidget">
        <ul>
          <li><a href="#aboutUs"><?php echo clean_for_display ($about_us_tab_title); ?></a></li>
          <li><a href="#authors"><?php echo clean_for_display ($authors_tab_title); ?></a></li>
        </ul>
        <div id="aboutUs" style="text-align: justify;"><?php echo $about_us_tab_content ?></div>
        <div id="authors" style="text-align: justify;"><?php echo $authors_tab_content ?></div>
      </div>
    </div>

    <div id="statisticsDialogWidget" title="<?php echo clean_for_display (CONF_WEB_TITL); ?>">
      <div align="center">
        <?php echo $statistics_dialog_content; ?>
        <div id="statisticsDialogChart" style="height: 450px; width: 450px;"></div>
      </div>
    </div>

    <div id="markerDialogWidget" title="<?php echo clean_for_display (CONF_WEB_TITL); ?>"></div>

    <!-- End Dialogs Layout -->

    <?php echo do_html_div ('', 'loading_image', '', 'class="ui-corner-all"'); ?>

    <?php
      echo do_html_div (statistics_associative_array (get_top_types (CONF_STAT_TOP)), 'statisticsData', 'display: none;');
      echo do_html_div (types_associative_array (get_markers_types ()), 'typesData', 'display: none;');
      echo do_html_div (CONF_SYS_GMAP_ADDR, 'systemAddressData', 'display: none;');
    ?>
  </body>
</html>
