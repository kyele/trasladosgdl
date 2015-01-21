var gdl = {
	url:'',
	cliente:'',
	info:function(){
		this.cliente = $('#txt_num_cliente').val();
		if(this.cliente.length == 13){
			$.ajax({
			url:this.url+'ver_cliente.html',
 			type:'POST',
 			dataType:'json',
 			data: {'cliente':gdl.cliente},
 			beforeSend:function(data){

				$('#contError').empty();
				$('#myform_traslado').css('display','none');
				$("#myform_traslado input[type!='submit']").val('');
 			},
 			success:function(data){
 				if(data.status){
 					$('#myform_traslado').css('display','block');
 				$.each(data.cliente,function(key,value){
            	    		$('#'+key).val(value);	
            	    })
 				}
 				else{
 					$('#contError').html(data.msg);
 				}
 			},
 			 error:function(data){
 			 	$('#contError').html(data.msg);	
 			}
		});
		}
	}
}
$(document).ready(function(){
	$('#txt_num_cliente').keyup(function(){
		gdl.info();
	})
})