$(document).ready(function() {
            var csrf_token = $("meta[name='csrf-token']").attr('content');
			$('#category').change(function(){
	                    var cat = $('#category').val();
	                    $.ajax({
	                        url: "/order/sosmed/ajax/get_service",
	                        type: 'POST',
	                        data: {
	                            "_token": csrf_token,
	                            "cat_id": cat
	                        },
	                        success:function(result){
	                            $('#service').html(result)
	                        }
	                    }) 
	        });
	        $('#service').change(function(){
	            var service = $('#service').val();
	            $.ajax({
	                url: "/order/sosmed/ajax/get_service_data",
	                type: 'POST',
	                data: {
	                    "_token": csrf_token,
	                    "sid": service
	                },
	                success:function(result){
	                    $('#information').html(result)
	                }
	            })
	            $.ajax({
	                url: "/order/sosmed/ajax/get_price",
	                type: 'POST',
	                data: {
	                    "_token": csrf_token,
	                    "sid": service
	                },
	                success:function(result){
	                    $('#price').val(result)
	                }
	            })

	            $.ajax({
	              url: "/order/sosmed/ajax/check_sosmed",
	              type: 'POST',
	              data: {
	                "_token": csrf_token,
	                "sid": service
	              },
	              success: function(result) {
	                if(result == 'custom_comment') {
	                  $('#custom_comment').css('display','block');
	                  $('#quantity').attr('readonly','true');
	                  $('#t_custom_comment').keyup(function() {
	                    var text = $("#t_custom_comment").val();   
	                    var lines = text.split(/\r|\r\n|\n/);
	                    var count = lines.length;
	                    $('#quantity').val(count);
	                    var total = $('#price').val() / 1000 * count
	                    $('#total').val(total);
	                  });
	                }else if(result == 'likes_comment') {
	                  $('#comment_likes').css('display','block');
	                }else{
	                  $('#comment_likes').css('display','none');
	                  $('#custom_comment').css('display','none');
	                  $('#quantity').removeAttr('readonly');
	                }
	              }
	            });
	        })
	        $('#quantity').keyup(function(){
	            var qty = $('#quantity').val();
	            var price = $('#price').val();

	            var total = price/1000 * qty;

	            $('#total').val(total)
	        })
		});	