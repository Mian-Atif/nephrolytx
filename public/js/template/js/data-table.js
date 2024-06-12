// (function($) {
/*
(function initFilterDataTable() {
  'use strict';
  $(function() {
      var table =   $('#order-listing').DataTable({
      "aLengthMenu": [
        [5, 10, 15, -1],
        [5, 10, 15, "All"]
      ],
      "iDisplayLength": 10,
      "language": {
        search: ""
      },
        "ordering": false
    });
    $('#order-listing').each(function() {
      var datatable = $(this);
      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr('placeholder', 'Search');
      search_input.removeClass('form-control-sm');
      // LENGTH - Inline-Form control
      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
      length_sel.removeClass('form-control-sm');
    });

      var buttons = new $.fn.dataTable.Buttons(table, {
          buttons:
              [
                  {extend: 'copy', className: 'copyButton', exportOptions: {columns: [0, 1,3,4,5]}},
                  {extend: 'csv', className: 'csvButton', exportOptions: {columns: [0, 1,2,3,4,5]}},
                  {extend: 'excel', className: 'excelButton', exportOptions: {columns: [0, 1,2,3,4,5]}},
                  {extend: 'pdf', className: 'pdfButton', exportOptions: {columns: [0, 1,2,3,4,5]}},
                  {extend: 'print', className: 'printButton', exportOptions: {columns: [0, 1,2,3,4,5]}}
              ]
          /!* [
           'copyHtml5',
           'excelHtml5',
           'csvHtml5',
           'pdfHtml5'
           ]*!/
      }).container().appendTo($('#buttons'));
      (function (table) {


          //Copy button
          $('#copyButton').click(function () {
              $('.copyButton').trigger('click');
          });
          //Download csv
          $('#csvButton').click(function () {
              $('.csvButton').trigger('click');
          });
          //Download excelButton
          $('#excelButton').click(function () {
              $('.excelButton').trigger('click');
          });
          //Download pdf
          $('#pdfButton').click(function () {
              $('.pdfButton').trigger('click');
          });
          //Download printButton
          $('#printButton').click(function () {
              $('.printButton').trigger('click');
          });


      }(table));
  });
}*/
// )(jQuery);