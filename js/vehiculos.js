vehi={

	marca:Array(),
	modelo:Array(),
	valor_marca:'',
	valor_modelo:'',
	url:'',
	catalogoModelos:function(url,marca)
	{
		$("#cmb_modelo").empty();	
		$.ajax({
				url:url+'informe_modelo.html',
				type:'POST',
				dataType:'json',
				data:{"marca":marca},
				beforeSend:function(data){
					
				},
				success:function(data){
								
					if(data.status){		
					
						options="";
						 $.each(data.modelos,function(key,value){
            	    		options+="<option value="+value["IDMODELO"]+">"+value.MODELO+"</option>";
                		});
						 $("#cmb_modelo").append(options);
						 	if(vehi.valor_modelo != '' && vehi.valor_modelo != false){
						 		$('#cmb_modelo').val(vehi.valor_modelo);
						 		vehi.valor_modelo = false;
						 	}
						 
						 
					}
					else{
                       vehi.modal_Modelo();
					}
				},
				error:function(){
					
				}
 		});	
	},
	catalagoMarca:function(url)
	{
		vehi.url=url;
		$("#cmb_marca").empty();
		$.ajax({
				url:url+'informe_marca.html',
				type:'POST',
				dataType:'json',
				beforeSend:function(data){
					
				},
				success:function(data){
					
					if(data.status){
						options="";
						 $.each(data.marcas,function(key,value){
            	    		options+="<option value="+value["IDMARCA"]+">"+value.MARCA+"</option>";
                		});
						 $("#cmb_marca").append(options);
						 
						 	if(vehi.valor_marca != '' && vehi.valor_marca != false){
						 		$('#cmb_marca').val(vehi.valor_marca);
						 	}
						 
						 vehi.catalogoModelos(url,$("#cmb_marca").val());


						 // alert("llego")
					}
					else{
						//$('#contError').html(data.msg);
                        vehi.modal_Marca();
					}
				},
				error:function(){
					//alert("valio dick 2");
				}
 		});
	},
        modal_Modelo:function()
        {
             $("#modal_modelo").modal({ 
                    backdrop:'static',
                    keyboard:true 
                }).on('shown.bs.modal',function(e){
                    var text = $("#cmb_marca option:selected").html();
                    var valor = $("#cmb_marca").val();
                    $("#txtMarca").val(text);
                    $("#txtMarcaValor").val(valor);
                    $("#txtNuevoModelo").val('')
                    
                }).on('hidden.bs.modal',function(){
                    $("#txtMarca").val('');
                    $("#txtMarcaValor").val('');
                });
        },
        modal_Marca:function()
        {
                 $("#modal_marca").modal({ 
                    backdrop:'static',
                    keyboard:true 
                }).on('shown.bs.modal',function(e){
                
                    $("#txtNuevaMarca").val('');
                }).on('hidden.bs.modal',function(){
                        $("#txtNuevaMarca").val('');
                });
        },
        inicio:function(url)
        {
        	vehi.catalagoMarca(url);
	        $("#cmb_marca").change(function()
	         {
	         	
	            vehi.catalogoModelos(url,$("#cmb_marca").val());
	         });
	        setTimeout(function(){
	            $("#contError").empty();

	        },3000);
	        $("#btn_agregarMarca").click(function(){
	            vehi.modal_Marca();
	        })
	        $("#btn_agregarModelo").click(function(){
	           vehi.modal_Modelo();
	        })
        	$('#myform_marca').submit(function(e){
				e.preventDefault();
				$.ajax({
					url:$(this).attr('action'),
					type:'POST',
					dataType:'json',
					data:$(this).serialize(),
					success:function(data){
						if(! data.status){
							$('#contErrorMarca').html(data.msg);
						}else{
							
							$('#contErrorMarca').empty().html(data.msg);
							setTimeout(function(){
								$("#modal_marca").modal('hide');
								$('#contErrorMarca').empty()
								vehi.catalagoMarca(vehi.url);
							},3000);
						}
					},
					error:function(){
						$('#contError').html('Parece que su conexión a internet no va bien, intentelo más tarde.');
					}
				});
	 		});



	 		$('#myform_modelo').submit(function(e){
				e.preventDefault();
				$.ajax({
					url:$(this).attr('action'),
					type:'POST',
					dataType:'json',
					data:$(this).serialize(),
					success:function(data){
						if(! data.status){
							$('#contErrorModelo').html(data.msg);
						}else{
							
							$('#contErrorModelo').empty().html(data.msg);
							setTimeout(function(){
								$("#modal_modelo").modal('hide');
								$('#contErrorModelo').empty();
								vehi.catalogoModelos(vehi.url,$("#cmb_marca").val());
							},3000);
						}
					},
					error:function(){
						$('#contError').html('Parece que su conexión a internet no va bien, intentelo más tarde.');
					}
				});
	 		});

	 		$('#myform_info_vehiculo').submit(function(e){
				e.preventDefault();
				var form = new FormData(document.getElementById('myform_info_vehiculo'));
			   	var file = document.getElementById('btn_file').files[0];
                                if (file) {
                                   form.append('btn_file', file);
                                }

				$.ajax({
					url:$(this).attr('action'),
					type:'POST',
					dataType:'json',
					processData: false, 
  					contentType: false, 
					data:form,
					success:function(data){
						if(! data.status){
							$('#contErrorActualiza').html(data.msg);
						}else{
							
							$('#contErrorActualiza').empty().html(data.msg);
							setTimeout(function(){
								$("#modal_actualiza_vehiculo").modal('hide');
								$('#contErrorActualiza').empty();
								location.reload();
							},3000);
						}
					},
					error:function(){
						$('#contErrorActualiza').html('<div class="alert alert-danger">Parece que su conexión a internet no va bien, intentelo más tarde.</div>');
					}
				});
	 		});

	 		$('#table_vehiculos :checkbox').click(function(e){
        	
        	vehi.update_status($(this).attr('id'),$(this).is(':checked'));
        });

	 		
        },
        file_selected:function(event) {
		var selectedFile = event.target.files[0];
    	var reader = new FileReader();
		var imgtag = document.getElementById("img_src");
        imgtag.title = selectedFile.name;
        reader.onload = function(event) {
            imgtag.src = event.target.result;
    	};
 		reader.readAsDataURL(selectedFile);
 	},
 	modal_actualiza:function(url,vehiculo){
 		vehi.url=url;
 		marca='';
 		modelo='';
 		$.ajax({
				url:vehi.url+'ver_vehiculo.html',
				type:'POST',
				dataType:'json',
				data:{'vehiculo':vehiculo},
				beforeSend:function(data){
					
				},
				success:function(data){
					
					if(data.status){
						// vehi.inicio(vehi.url);
						$('#modal_actualiza_vehiculo').modal({ 
				            backdrop:'static',
				            keyboard:true 
          				}).on('shown.bs.modal',function(e){
			                $.each(data.vehiculos[0],function(key,value){
			                	$('#'+key).val(value);	
			                	if(key=="cmb_marca")
			                	{
			 						vehi.catalogoModelos(url,$("#cmb_marca").val());
		                    	}
		                    	else if(key=="img_src")
		                    	{
		                    		$("#"+key).attr("src",vehi.url+"img/vehiculos/"+value.toLowerCase()+".jpg")
		                    	}

						 });
			                

              
         				}).on('hidden.bs.modal',function(){

         				});
					}
					else{
						
					}
				},
				error:function(){
					
				}
 		});
 	
 	},
 	update_status:function(id,status){
 		id_tmp = id.split('_');
 		$.ajax({
 			url:this.url+'estatus_vehiculo.html',
 			type:'POST',
 			dataType:'json',
 			data: {'vehiculo':id_tmp[1],'stat':status},
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