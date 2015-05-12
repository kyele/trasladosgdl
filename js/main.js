var obj = {
	url:'',
	initialize:function(){
		$('#sidebar-toggle').click(function(e){
			e.preventDefault();
			$(".navbar-side").toggleClass("collapsed");
    		$("#page-wrapper").toggleClass("collapsed");
		});
		$('.page-content').css('opacity','1');
	},
	alta_usuarios:function(){
		$('#myform').submit(function(e){
			e.preventDefault();
			// var form = new FormData(document.getElementById('my form'));
		 //   	var file = document.getElementById('userfile').files[0];
		 //    if (file) {   
		 //        form.append('userfile', file);
		 //    }
			$.ajax({
				url:$(this).attr('action'),
				type:'POST',
				dataType:'json', 
				data:$(this).serialize(),
				// processData: false, 
  		// 		contentType: false, 
				success:function(data){
					if(data.statusError){
						$('#contError').html(data.errors);
					}else{
						$('#myform input').val('');
						$('#contError').empty().addClass('alert alert-success').html( data.usuario);
						
					}
				}
			});	
		});
	},
	file_selected:function(event) {
		var selectedFile = event.target.files[0];
    	var reader = new FileReader();
		var imgtag = document.getElementById("img_src");
        imgtag.title = selectedFile.name;
        reader.onload =function(event) {
            imgtag.src = event.target.result;
    	};
 		reader.readAsDataURL(selectedFile);
 	},
 	init_components:function(){
 		
        $('#table_choferes :checkbox').click(function(e){
        	
        	obj.update_status($(this).attr('id'),$(this).is(':checked'));
        });
        $('#table_usuarios :checkbox').click(function(e){
        	
        	obj.update_user($(this).attr('id'),$(this).is(':checked'));
        });
        $('#txt_fecha_nac,#txt_fecha_ing').datepicker();
        
        var dI = new Date();
        var monthI = (dI.getMonth()+1) ;
        var dayI = (dI.getDate());
        dayI = (dayI<10) ? '0'+dayI:dayI;
        monthI = (monthI < 10) ? '0'+monthI : monthI;
        $('#txt_fecha_ini').datepicker('setValue', dI.getFullYear()+'/'+  monthI+'/01');
		$('#txt_fecha_fin').datepicker('setValue', dI.getFullYear()+'/'+  monthI+'/'+dayI);
        $('#txt_traslado').datepicker('setValue', dI.getFullYear()+'/'+  monthI+'/'+dayI);
        
        $('#catalogo').dataTable({
           "lengthMenu": [[20, 30, 40, -1], [20, 30, 40, "Todos"]]

        });
        $('#myform_info_chofer').submit(function(e){
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
					$('#contError').html('Parece que su conexión a internet no va bien, intentelo más tarde.');
				}
			});
 		});
 	},
 	modal:function(rfc){
 		url_img = this.url;
 		$.ajax({
				url:this.url+'ver_chofer.html',
				type:'POST',
				dataType:'json',
				data:{'chofer':rfc},
				beforeSend:function(data){
					
				},
				success:function(data){
					if(data.status){
						$('#modal_chofer').modal({ 
				            backdrop:'static',
				            keyboard:true 
          				}).on('shown.bs.modal',function(e){
			                $.each(data.chofer,function(key,value){
            	    		$('#'+key).val(value);	
                		});
              
         				}).on('hidden.bs.modal',function(){
         					$('#myform_info_chofer [input]').val('');
         				});
         				$('#img_chofer').attr('src',url_img+'img/choferes/'+rfc.toLowerCase()+'.jpg');	
					}
					
				},
				error:function(){
					
				}
 		});
 	},
 	modalMyRides:function(rfc,nombre){
 		$('#hidd_myride').val(rfc);
 			$('#modal_my_rides').modal({ 
	            backdrop:'static',
	            keyboard:true 
				}).on('shown.bs.modal',function(e){
               		$('#nombre_chofer_tr').html(nombre);
 				}).on('hidden.bs.modal',function(){
					$('#myform_my_rides [input]').val('');
					$('#nombre_chofer_tr').html('');
				});
 	},
 	
 	update_status:function(id,status){
 		id_tmp = id.split('_');
 		$.ajax({
 			url:this.url+'estatus_chofer.html',
 			type:'POST',
 			dataType:'json',
 			data: {'chofer':id_tmp[1],'stat':status},
 			success:function(data){
 				(data.status)?function(){
 					$.bootstrapGrowl(
 					data.msg,
	 					{
	 						type:'success',	
	 						align:'center',
	 						width:'auto',
	 						delay:2000,
	 						allow_dismiss:false
	 					}
 					);
 					if(!status){$('#'+id).parent().parent().addClass('danger');}else{$('#'+id).parent().parent().removeClass('danger');}
 				}()
 				:function(){
						$.bootstrapGrowl(
 					data.msg,
	 					{
	 						type:'error',	
	 						align:'center',
	 						width:'auto',
	 						delay:2000,
	 						allow_dismiss:false
	 					}
 					);
 				}();
 			},
 			error:function(){
 				$.bootstrapGrowl(
 					"Parece que su conexión a internet no va bien!!!",
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
 	update_user:function(id,status){
 		id_tmp = id.split('_');
 		$.ajax({
 			url:this.url+'estatus_usuario.html',
 			type:'POST',
 			dataType:'json',
 			data: {'usuario':id_tmp[1],'stat':status},
 			success:function(data){
 				(data.status)?function(){
 					$.bootstrapGrowl(
 					data.msg,
	 					{
	 						type:'success',	
	 						align:'center',
	 						width:'auto',
	 						delay:2000,
	 						allow_dismiss:false
	 					}
 					);
 					if(!status){$('#'+id).parent().parent().addClass('danger');}else{$('#'+id).parent().parent().removeClass('danger');}
 				}()
 				:function(){
						$.bootstrapGrowl(
 					data.msg,
	 					{
	 						type:'error',	
	 						align:'center',
	 						width:'auto',
	 						delay:2000,
	 						allow_dismiss:false
	 					}
 					);
 				}();
 			},
 			error:function(){
 				$.bootstrapGrowl(
 					"Parece que su conexión a internet no va bien!!!",
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
 		
 		
 	}
};

$(document).ready(function(){
	obj.initialize();
	obj.alta_usuarios();
	obj.init_components();
	
});