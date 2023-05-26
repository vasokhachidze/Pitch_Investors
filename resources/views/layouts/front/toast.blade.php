<script>
    $(document).ready(function() {
      var error_msg = $('#error_msg').val();
      var success_msg = $('#success_msg').val();
      var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000
      });
      if(error_msg)
      {
         Toast.fire({
         icon: 'error',
         title: error_msg
         })
      }
      if(success_msg)
      { 
         Toast.fire({
         icon: 'success',
         title: success_msg
         })
      }
   });
</script>