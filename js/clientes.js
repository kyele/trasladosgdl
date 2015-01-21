var customers = {
	url:'',
	modal:function(rfc){

 		$.ajax({
				url:this.url+'ver_cliente.html',
				type:'POST',
				dataType:'json',
				data:{'cliente':rfc},
				success:function(data){
					if(data.status){
						$('#modal_cliente').modal({ 
				            backdrop:'static',
				            keyboard:true 
          				}).on('shown.bs.modal',function(e){
			                $.each(data.cliente,function(key,value){
            	    		$('#'+key).val(value);	
            	    		if(key == 'contribuyente'){
            	    			if(value != 'FISICA'){
									$('.tipo').css('display','none');
									$('.tipo1').css('display','block');
								}else{
									$('.tipo').css('display','block');
									$('.tipo1').css('display','none');
								}
							}
                		});
              
         				}).on('hidden.bs.modal',function(){
         					$('#myform_info_cliente [input]').val('');
         				});
					}
					
				},
				error:function(){
					$.bootstrapGrowl(
 					"El apartado al que intenta ingresar ha caducado o no existe, comuniquese con el administrador del sistema.",
	 					{
	 						type:'danger',	
	 						align:'center',
	 						width:'auto',
	 						delay:3000,
	 						allow_dismiss:false
	 					}
 					);

				}
 		});
 	
 	},
 	modal_adeudo:function(rfc){

 		$('#hidd_adeudo').val(rfc);
 		
						$('#modal_adeudos').modal({ 
				            backdrop:'static',
				            keyboard:true 
          				}).on('shown.bs.modal',function(e){
			               
             			}).on('hidden.bs.modal',function(){
         					$('#myform_adeudos [input]').val('');
         				});
					
 	
 	},
 	update_cliente:function(){
 		$('#myform_info_cliente').submit(function(e){
			e.preventDefault();
			$.ajax({
				url:$(this).attr('action'),
				type:'POST',
				dataType:'json',
				data:$(this).serialize(),
				success:function(data){
					(!data.status)?function(){
						$('#contError').html(data.msg);
					}
					():function(){
						$('#contError').empty().html(data.msg);
						setTimeout(function(){
							location.reload();
						},2000);
					}();
				},
				error:function(){
					$('#contError').html('<div class="alert alert-danger">Parece que su conexión a internet no va bien, intentelo más tarde.</div>');
				}
			});
 		});
 	},
 	update_solicitante:function(){
 		$('#myform_solicitantes').submit(function(e){
			e.preventDefault();
			$.ajax({
				url:$(this).attr('action'),
				type:'POST',
				dataType:'json',
				data:$(this).serialize(),
				success:function(data){
					(!data.status)?function(){
						$('#contErrorSolicitantes').html(data.msg);
					}
					():function(){
						$('#contErrorSolicitantes').empty().html(data.msg);
						setTimeout(function(){
							$('#myform_buscar_solicitantes').submit();
						},2000);
					}();
				},
				error:function(){
					$('#contErrorSolicitantes').html('<div class="alert alert-danger">Parece que su conexión a internet no va bien, intentelo más tarde.</div>');
				}
			});
 		});
 	}
};
$(document).ready(function($) {
	customers.update_cliente();	
	customers.update_solicitante();
	$('#table_solicitantes a').click(function(e){
			e.preventDefault();
			var solicitante = $(this).attr('id');
			$('#txt_solicitante').val(solicitante);
			$.ajax({
				url:customers.url+'info_solicitante.html',
				type:'POST',
				dataType:'json',
				data:{'solicitante':solicitante},
				success:function(data){
					if(data.status){
						$('#modal_modif_solicitante').modal({ 
				            backdrop:'static',
				            keyboard:true 
          				}).on('shown.bs.modal',function(e){
			                $.each(data.solicitante,function(key,value){
            	    		$('#'+key).val(value);	
                		});
              
         				}).on('hidden.bs.modal',function(){
         					$('#myform_solicitantes [input]').val('');
         				});
					}
					
				},
				error:function(){
					$.bootstrapGrowl(
 					"El apartado al que intenta ingresar ha caducado o no existe, comuniquese con el administrador del sistema.",
	 					{
	 						type:'danger',	
	 						align:'center',
	 						width:'auto',
	 						delay:3000,
	 						allow_dismiss:false
	 					}
 					);

				}
 		});


		});

	$('input[name="tipo_contribuyente"]').click(function(){
		var a = $(this).val();
		(a == 'FISICA')?function(){ $('.tipo').css('display','block'); $('.tipo1').css('display','none'); }():function(){  $('.tipo').css('display','none'); $('.tipo1').css('display','block'); }();
	});
	if($('input[name="tipo_contribuyente"]:checked').val() != 'FISICA'){
		$('.tipo').css('display','none');
		$('.tipo1').css('display','block');
	}
	else{
		$('.tipo1').css('display','none');
	}
});