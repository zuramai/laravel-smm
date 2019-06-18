
$(document).ready(function() {
    var csrf_token = $("meta[name='csrf-token']").attr('content');
    $('#type').change(function() {

      var type = $('#type').val();
      var method = $('#method');
      var newType = "AUTO";
      if(type == "Otomatis") 
        newType = "AUTO"
      else if(type == "Manual")
        newType = "MANUAL"

      $.ajax({
        type: "POST",
        url: "/deposit/get_method",
        data: {
          "_token": csrf_token,
          "type": newType
        },
        success:function(result) {
          console.log(result);
          method.html(result);
        }
      });
    });
    $('#method').change(function() {
          var method = $('#method').val();
          $.ajax({
            url: "/deposit/get_rate",
            method: 'POST',
            data: {
              "_token": csrf_token,
              "method": method
            },
            success:function(result) {
              $('#rate_deposit').val(result);
            }

          })
    });

    $('#quantity_deposit').keyup(function() {
          var quantity = $('#quantity_deposit').val();
          var rate = $('#rate_deposit').val();
          var get_balance = $('#get_balance'); 

          var final = quantity * rate;
          get_balance.val(final)
    }); 
});
