$("input[name='_method'][value='delete']").parent('form').find("button[type='button']").click(function(e){
	var thisform = $(this).parent('form');
	alertify.confirm("Anda yakin ingin menghapus?", function (ev) {
    	thisform.submit()
    	console.log(thisform)
    }, function(ev) {
        ev.preventDefault();
        alertify.error("Sukses membatalkan");
    });
});

$('.detailSosmed').click(function(){
	var csrf_token = $("meta[name='csrf-token']").attr('content');
	var service_id = $(this).parent('td').parent('tr').find('#service_id').text();
	console.log(service_id);
	$.ajax({
		url: '/price/sosmed/detail',
		type: 'POST',
		data: {"_token": csrf_token, "service_id":service_id},
		success:function(res) {
			console.log(res)
			$('#priceSosmed').modal('show');
			$('#detailModalTitle').text(res.name);
			$('#detailModalBody').html("<p><b>Nama layanan: </b>"+res.name+"</p>   <p><b>Min: </b>"+res.min+"</p> <p><b>Max: </b> "+res.max+"</p> <p><b>Harga via web: </b> Rp "+res.price+"</p>    <p><b>Harga via API: </b>Rp "+res.price_oper+"</p>     <p><b>Tipe layanan: </b> "+res.type+"</p>   <p><b>Catatan: </b>"+res.note+"</p>") ;
		}
	});
})