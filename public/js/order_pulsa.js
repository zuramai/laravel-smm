$('#category_pulsa').change(function() {
            var csrf_token = $("meta[name='csrf-token']").attr('content');
          var category = $('#category_pulsa').val();
          var service = $('#service_pulsa');
          var operator = $('#operator_pulsa');
            // console.log("success");
          $.ajax({
            url: "/order/pulsa/ajax/get_service_pulsa",
            type: 'POST',
            data: {
                "_token": csrf_token,
                "id": category
            },
            success: function(result) {
              operator.html(result)
            }
          });
        });

        $('#operator_pulsa').change(function() {
          var category = $('#category_pulsa').val();
          var operator = $('#operator_pulsa').val();
          var service = $('#service_pulsa');

          $.ajax({
            url: "/order/pulsa/ajax/get_type_pulsa",
            type: 'POST',
            data: {
                "_token": csrf_token,
                "id": operator
            },
            success: function(result) {
              service.html(result)
            }
          });
        });

        $('#service_pulsa').change(function() {
          var service_pulsa = $('#service_pulsa').val();
          var price = $('#total');
          $.ajax({
            url: "/order/pulsa/ajax/get_price_pulsa",
            type: 'POST',
            data: {
                "_token": csrf_token,
                "id": service_pulsa
            },

            success: function(result) {
              price.val(result)
            }

          });
        });