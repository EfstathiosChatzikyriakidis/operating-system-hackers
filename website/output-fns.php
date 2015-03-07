<?php
  // define output functions.

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

  // try to get a single-line text box.
  function input_text ($name, $style = '', $value = '', $extra = '') {
    $element = '<input type="text" name="'.$name.'" value="'.$value.'"';

    if ($style != '')
      $element .= ' style="'.$style.'"';

    if ($extra != '')
      $element .= ' '.$extra;

    $element .= '>';
    return $element;
  }

  // try to get a textarea box.
  function input_textarea ($name, $style = '', $value = '', $extra = '') {
    $element = '<textarea name="'.$name.'" cols="0" rows="0"';

    if ($style != '')
      $element .= ' style="'.$style.'"';

    if ($extra != '')
      $element .= ' '.$extra;

    $element .= '>'.$value.'</textarea>';
    return $element;
  }

  // try to get a form submit button.
  function input_button ($type, $name, $value = '', $style = '', $extra = '') {
    $element = '<input type="'.$type.'" name="'.$name.'"';

    $element .= ' '. ($type != "image" ? 'value' : 'src') .'="'.$value.'"';

    if ($style != '')
      $element .= ' style="'.$style.'"';

    if ($extra != '')
      $element .= ' '.$extra;

    $element .= '>';
    return $element;
  }

  // try to get markers' types select box.
  function select_type ($selected, $select_name, $default, $style = '', $extra = '') {
    // fetch the markers' types.
    $types = get_markers_types ();

    // return immediately if there are no markers' types.
    if (!$types) return false;

    // create the open select box tag.
    $stype = '<select name="'.$select_name.'"';

    // add any style tag properties.
    if ($style != '')
      $stype .= ' style="'.$style.'"';

    // add any extra tag properties.
    if ($extra != '')
      $stype .= ' '.$extra;

    // complete the open select box tag.
    $stype .= '>';

    // add the appropriate default option tag.
    $stype .= '<option value="">'.clean_for_display ($default).'</option>';

    // iterate through the rows and add more option tags.
    foreach ($types as $row) {
      // get current appropriate values from the row.
      $name = clean_for_display ($row['name']);
      $id   = clean_for_display ($row['id']);

      // add the current option tag.
      $stype .= '<option value="'.$id.'"';
      if ($id == $selected)
        $stype .= ' selected';
      $stype .= '>'.$name.'</option>';
    }

    // add the close select box tag.
    $stype .= '</select>';

    return $stype;
  }

  // try to get a select box with positive / negative select options.
  function select_boolean ($select_name, $style = '', $selected = '0', $extra = '') {
    // create the open select box tag.
    $stype = '<select name="'.$select_name.'"';

    // add any style tag properties.
    if ($style != '')
      $stype .= ' style="'.$style.'"';

    // add any extra tag properties.
    if ($extra != '')
      $stype .= ' '.$extra;

    // complete the open select box tag.
    $stype .= '>';

    // add negative option.
    $stype .= '<option value="0"';
    if ('0' == $selected)
      $stype .= ' selected';
    $stype .= '>False</option>';

    // add positive option.
    $stype .= '<option value="1"';
    if ('1' == $selected)
      $stype .= ' selected';
    $stype .= '>True</option>';

    // add the close select box tag.
    $stype .= '</select>';

    return $stype;
  }

  // try to get a html link.
  function do_html_link ($url, $text, $target = '', $title = '', $extra = '', $style = '') {
    $element = '<a href="'.$url.'"';

    if ($title != '')
      $element .= ' title="'.$title.'"';

    if ($target != '')
      $element .= ' target="'.$target.'"';

    if ($style != '')
      $element .= ' style="'.$style.'"';

    if ($extra != '')
      $element .= ' '.$extra;

    $element .= '>'.$text.'</a>';
    return $element;
  }

  // try to get a html div.
  function do_html_div ($text, $id, $style = '', $extra = '') {
    $element = '<div';

    if ($id != '')
      $element .= ' id="'.$id.'"';

    if ($style != '')
      $element .= ' style="'.$style.'"';

    if ($extra != '')
      $element .= ' '.$extra;

    $element .= '>'.$text.'</div>';
    return $element;
  }

  // try to get an html image.
  function do_html_img ($src, $title  = '',
                              $width  = '',
                              $height = '',
                              $style  = '',
                              $extra  = '') {

    $element = '<img src="'.$src.'" alt="'.$title.'"';

    if ($title != '')
      $element .= ' title="'.$title.'"';

    if ($width != '')
      $element .= ' width="'.$width.'"';

    if ($height != '')
      $element .= ' height="'.$height.'"';

    if ($style != '')
      $element .= ' style="'.$style.'"';

    if ($extra != '')
      $element .= ' '.$extra;

    $element .= '>';
    return $element;
  }

  // try to get a transparent graphical blank space.
  function space ($width = 1, $height = 1) {
    return do_html_img ('http://'.clean_for_display (CONF_WEB_DOMA).'/'.DIR_GRAPHICS.'/pixel.png', '', $width, $height);
  }

  // try to get an inactive icon.
  function get_inactive_icon () {
    return do_html_img ('http://'.clean_for_display (CONF_WEB_DOMA).'/'.DIR_GRAPHICS.'/disabled.png');
  }

  // try to get an active icon.
  function get_active_icon () {
    return do_html_img ('http://'.clean_for_display (CONF_WEB_DOMA).'/'.DIR_GRAPHICS.'/enabled.png');
  }

  // try to get statistics associative array according to the php given.
  function statistics_associative_array ($statistics) {
    $array = array();

    if (!empty ($statistics)) {
      foreach ($statistics as $item) {
        array_push ($array, array($item['name'], intval($item['count'])));
      }
    }

    return str_replace ('"', "'", object2json ($array));
  }

  // try to get types associative array according to the php given.
  function types_associative_array ($types) {
    $array = array();

    if (!empty ($types)) {
      foreach ($types as $type) {
        $array[$type['id']] = $type['image'];
      }
    }

    return object2json ($array);
  }

  // try to transform a text message to an image.
  function text2image ($text, $font = 3, $red = 0, $green = 0, $blue = 0) {
    // calculate the image size (width, height).
    $width  = 2 + utf8_strlen ($text) * imagefontwidth ($font);
    $height = 2 + imagefontheight ($font);

    // create the image with the specified size.
    $im = imagecreate ($width, $height);

    // set up the background and text color.
    $white = imagecolorallocate ($im, 255, 255, 255);
    $color = imagecolorallocate ($im, $red, $green, $blue);

    // adjust the image to be transparent.
    imagecolortransparent ($im, $white);

    // write the text to the image.
    imagestring ($im, $font, 1, 1, $text, $color);

    // return the image.
    return $im;
  }

  // try to transform an object from PHP to JSON object.
  function object2json ($object) {
    if (function_exists ('json_encode')) {
      return json_encode ($object);
    }

    $json = new Services_JSON ();

    return $json->encode ($object);
  }

  // try to create an XML document with provided markers' data.
  function markers_xml_document ($markers) {
    // start a XML document, create parent node.
    $dom = new DOMDocument ("1.0", "UTF-8");
    $node = $dom->createElement ("markers");
    $parnode = $dom->appendChild ($node);

    // iterate through the rows, adding XML nodes for each row.
    foreach ($markers as $row) {
      // create and add to the XML document a new node.
      $node = $dom->createElement ("marker");
      $newnode = $parnode->appendChild ($node);

      // add attributes to the new node.
      $newnode->setAttribute ("mid"     , clean_for_display ($row['id']));
      $newnode->setAttribute ("name"    , clean_for_display ($row['name']));
      $newnode->setAttribute ("address" , clean_for_display ($row['address']));
      $newnode->setAttribute ("lat"     , clean_for_display ($row['lat']));
      $newnode->setAttribute ("lng"     , clean_for_display ($row['lng']));
      $newnode->setAttribute ("tid"     , clean_for_display ($row['type']));
    }

    // save and return the XML document.
    return $dom->saveXML ();
  }
?>
