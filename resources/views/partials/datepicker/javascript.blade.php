  <link rel="stylesheet" href="{{ asset('js/jquery-ui/jquery-ui.css') }}" />

      <script src="{{ asset('js/jquery-ui/jquery-ui.js') }}"></script>

  <script>
  $( function() {
    $(".datepicker").datepicker({
        changeMonth: true,
        chagneYear: true,
        dateFormat: 'yy-mm-dd'
    });
  } );
  </script>
