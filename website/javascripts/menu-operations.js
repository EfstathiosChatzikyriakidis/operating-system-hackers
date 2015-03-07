/*
 *  Copyright (C) 2012  Demothenes Koptsis <demosthenesk@gmail.com>
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

$(document).ready (function () {

  // UI Widgets Configuration Options //

  var dialogOptions = {
    autoOpen  : false,
    resizable : false,
    draggable : false,
    width     : 560,
    show      : "fade",
    hide      : "fade",
    height    : 'auto',
    modal     : true
  };

  var plotOptions = {
    seriesDefaults : {
      // make this a pie chart.
      renderer : jQuery.jqplot.PieRenderer,
      rendererOptions : {
        // put data labels on the pie slices.
        // by default, labels show the percentage of the slice.
        showDataLabels : true
      }
    },

    legend : {
      show : true,
      location : 'e'
    }
  };

  // UI Widgets Initialization //

  $("#informationDialogWidget").dialog (dialogOptions);
  $("#statisticsDialogWidget").dialog (dialogOptions);

  $("#internalTabsWidget").tabs ();

  // UI Widgets Events Registration //

  $('#informationDialogMenuItem').click (function (event) {
    event.preventDefault ();
    $("#informationDialogWidget").dialog ("open");
  });

  $('#locateUsMenuItem').click (function (event) {
    event.preventDefault ();

    var coordinates = $('#systemAddressData').text ();

    if (coordinates != '') {
      locateUs (coordinates, locateZoomLevel);
    }
  });

  $('#statisticsDialogMenuItem').click (function (event) {
    event.preventDefault ();
    $("#statisticsDialogWidget").dialog ("open");

    var statisticsString = $('#statisticsData').text ();

    if (statisticsString != '[]') {
      var statisticsArray = eval ('(' + statisticsString + ')');

      jQuery.jqplot ('statisticsDialogChart', [statisticsArray], plotOptions);
    }
  });
});
