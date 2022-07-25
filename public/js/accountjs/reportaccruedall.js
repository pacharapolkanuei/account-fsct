$( document ).ready(function() {

  $('.datepicker').daterangepicker();
  var fixNewLine = {
          exportOptions: {
              format: {
                  body: function ( data, column, row ) {
                      return column === 0 ?
                          data.replace( /<br\s*\/?>/gmi, '\n' ) :
                          data;
                  }
              }
          }
      };


    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons:[
            $.extend( true, {}, fixNewLine, {
                extend: 'copyHtml5'
            } ),
            $.extend( true, {}, fixNewLine, {
                extend: 'excelHtml5'
            } )

        ]

    });
});
