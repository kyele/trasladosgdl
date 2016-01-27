var tbl_traslados;
var rides = {
    data: Array(),
    pos:0,
    id_chk:'',
    id_traslado:'',
    cerrar:false,
    url:'',
    solicintantes:Array(),
    checkPay :[],
    pay_mod :false,
    load_info:function(id){
        this.id_chk = id;
        this.pos = $('#txt_cliente').prop('selectedIndex');

        if($('#'+this.id_chk).is(':checked') === true){

            $.each(rides.data[rides.pos], function(index, val) {
                $('#'+index).val(val);
            });
            $("#txt_Direccion_sol").attr('disabled',true)
            $("#data_solicitante").attr('disabled',true)
        }else{
            $.each(rides.data[rides.pos], function(index, val) {
                $('#'+index).val('');
            });
            $("#txt_Direccion_sol").attr('disabled',false)
            $("#data_solicitante").attr('disabled',false)
        }

    },
    update_ride:function(id,status){
        id_tmp = id.split('_');
        $.ajax({
            url:this.url+'estatus_traslado.html',
            type:'POST',
            dataType:'json',
            data: {'ride':id_tmp[1],'stat':status},
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
                    if(!status){
                        $('#'+id).parent().parent().removeClass('success');
                        $('#estado_t_'+id_tmp[1]).text('PENDIENTE');
                        //$('chk_'+id_tmp[1]);
                    }
                    else
                    {
                        $('#field_ride_'+id_tmp[1]).removeClass('danger').addClass('success');
                        $('#estado_t_'+id_tmp[1]).text('REALIZADO').removeClass('text-danger text-warning').addClass('text-success');
                        $('#chk_'+id_tmp[1]).attr('disabled','disabled');
                        $('#chk_'+id_tmp[1]).prop( "checked", true );
                        $('#linkstatus_'+id_tmp[1]).removeClass('text-danger').addClass('text-warning').text('Restaurar');
                        $('#linkstatus_'+id_tmp[1]).data('status','EC');
                        //$('#'+id_tmp[1]+' .ver_detalle_traslado').parent().html('N/A');
                        //$('#'+id_tmp[1]).parent().html('N/A');
                        rides.cerrar=true;
                    }
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
    //detalle del traslado
    payments:function(id,status){
        id_tmp = id;
        $.ajax({
            url:this.url+'detalle_traslado.html',
            type:'POST',
            dataType:'json',
            data: {'mytraslado':id_tmp},
            success:function(data){

                if(data.status) {
                    $('#modal_detalle_traslado').modal({
                        backdrop:'static',
                        keyboard:true
                    }).on('shown.bs.modal',function(e){
                        var flag = false;
                        var patron = ",";
                        /*if(status != 'EC') {
                            flag = true;
                            $(":submit").attr('disabled','disabled');
                        }else {
                            $(":submit").attr('disabled',false);
                        }*/
                        $.each(data.traslado,function(key,value) {
                            if(key == "txt_monto_traslado"){
                                value = value.replace(patron,'');
                                //console.log(value);
                            }

                            $('#'+key).val(value);
                            /*if(flag){
                                $('#'+key).attr('disabled','disabled');
                            }else{*/
                                $('#'+key).attr('disabled',false);
                            //}
                        });
                    }).on('hidden.bs.modal',function(){

                    });
                }



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
     payments_mod:function(id,status){
        id_tmp = id;

        $.ajax({
            url:this.url+'detalle_traslado.html',
            type:'POST',
            dataType:'json',
            data: {'mytraslado':id_tmp},
            success:function(data){
                rides.pay_mod = true;
                var valor  = '';
                if(data.status) {
                    $('#modal_detalle_traslado').modal({
                        backdrop:'static',
                        keyboard:true
                    }).on('shown.bs.modal',function(e){
                        var flag = false;
                        var patron = ",";

                        $.each(data.traslado,function(key,value) {
                            if(key == "txt_monto_traslado"){
                                value = value.replace(patron,'');

                            }
                            if(key == 'txt_cliente'){
                                valor = value;
                            }
                            $('#'+key+'_mod').val(value);

                        });
                       $('#txt_cliente_mod').attr('readonly',true);
                    }).on('hidden.bs.modal',function(){

                    });
                }



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
    pay_ride:function(id){
        id_tmp = id.split('_');
        $.ajax({
            url:this.url+'pago_traslado.html',
            type:'POST',
            dataType:'json',
            data: {'payment':id_tmp[1]},
            success:function(data){

                (data.status)?function(){
                    $('#fecha_pago_'+id_tmp[1]).html(data.fecha);
                    $('#field_payment_'+id_tmp[1]).addClass('text-success').html('Realizado <span class="fa fa-check"></span>');
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
    modal:function(id,checked){
        id_tmp = id.split('_');
        this.id_traslado = id_tmp[1];
        $('#myTraslado').val(this.id_traslado);
        $('#modal_servicio').modal({
            backdrop:'static',
            keyboard:true
        }).on('shown.bs.modal',function(e){
            rides.cerrar = false;
        }).on('hidden.bs.modal',function(){
            $('#myform_info_servicio [input]').val('');
            if(rides.cerrar == false){
                $('#chk_'+rides.id_traslado).attr('checked',!checked);
            }

        });


    },
    modal_solicitante:function()
    {
        $("#modal_solicitante").modal({
            backdrop:'static',
            keyboard:true
        }).on('shown.bs.modal',function(e){

            var text = $("#txt_cliente option:selected").html();
            var valor = $("#txt_cliente").val();
            $("#txt_nvoCliente").val(text);
            $("#txt_nvo_cliente").val(valor);

            $("#txt_nuevo_solicitante").val('');
            $("#txt_nuevo_dir").val('')

        }).on('hidden.bs.modal',function(){
            $("#txt_nuevo_solicitante").val('');
            $("#txt_nuevo_dir").val('')
            $("#txt_nvo_cliente").val('');
        });
    },
    catalago_solicitantes:function(cliente,url){
        $("#txt_nombre_sol").empty();
        rides.solicitantes=Array();
        rides.url=url;
        $.ajax({
            url:url+'informe_solicitante.html',
            type:'POST',
            dataType:'json',
            data:{"cliente":cliente},
            beforeSend:function(data){

            },
            success:function(data){

                if(data.status){

                    options="";
                    rides.solicitantes=data.solicitantes;
                    $.each(data.solicitantes,function(key,value){
                        options+="<option value="+value["ID"]+">"+value.NOMBRE+"</option>";
                    });

                    $("#txt_nombre_sol").append(options);
                    valor=$("#txt_nombre_sol :selected").text();
                    $("#txt_nombre_solicitante").val(valor);


                }
                else{
                    $('#contError').html(data.msg);
                    // vehi.modal_Modelo();
                }
            },
            error:function(){
                //alert("valio dick 2");
            }
        });

    },
    load_solicitante:function(id){
        this.id_chk = id;
        pos = $('#txt_nombre_sol').val();

        if($('#'+this.id_chk).is(':checked') === true){

            $.each(rides.solicitantes, function(index, val) {

                if(val.ID==pos)
                {

                    $("#txt_Direccion_sol").val(val.DOMICILIO);
                    $.each(rides.data[rides.pos], function(index, val) {
                        $('#'+index).attr('disabled',true);
                        $("#data_client").attr('disabled',true)
                    });
                }
            });
        }else{
            $.each(rides.data[rides.pos], function(index, val) {
                $('#'+index).attr('disabled',false);
                $("#data_client").attr('disabled',false)
            });
            $("#txt_Direccion_sol").val('');
        }

    },
    modal_comprobante:function(id){
        id_tmp = id.split('_');
        this.id_traslado = id_tmp[1];
        $('#myTraslado').val(this.id_traslado);
        $('#modal_comprobante').modal({
            backdrop:'static',
            keyboard:true
        }).on('shown.bs.modal',function(e){
            $('#txt_folio').val($('#comprobante_'+id_tmp[1]).html());
            $('#txt_fecha_pago').val($('#fecha_pago_'+id_tmp[1]).html());
        }).on('hidden.bs.modal',function(){
            $('#txt_folio').val('');
        });
    },
    cancellation:function(id,status){
        var id = id;
        var status = status;
        $.ajax({
            url:rides.url+'cancel.html',
            type:'POST',
            dataType:'json',
            data:{'id':id,'status':status},
            success:function(data){

                (data.status)?function(){
                  var clase;var removeClase;
                  var texto,texto1;
                  if(status =='EC'){
                    clase  = 'text-warning';
                    removeClase ='text-danger';
                    texto = 'PENDIENTE';
                    texto1='Cancelar';
                    status = 'C';

                  }else{
                    removeClase="text-warning";
                    clase = 'text-danger';
                    texto = 'CANCELADO';
                    texto1='Restaurar';
                    status = 'EC';
                  }
                    //$('#field_ride_'+id).removeClass('success').addClass('danger')
                    $('#estado_t_'+id).removeClass(removeClase).addClass(clase).html(texto);
                    $('#linkstatus_'+id).removeClass(clase).addClass(removeClase).text(texto1);
                    $('#chk_'+id).removeAttr('disabled');
                    $('#chk_'+id).prop( "checked", false );
                    $('#linkstatus_'+id).data('status',status);
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
    changeColor:function(id,color){
        $.ajax({
            url:rides.url+'color.html',
            type:'POST',
            dataType:'json',
            data:{'id':id,'color':color},
            success:function(data){

                (data.status)?function(){

                    $('.'+id+' > td').css('background',color);
                    $('[data-id="'+id+'"]').val(color);
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
        })
    },
    addSelection:function(input){
        var id = input.data('id');
        var checked = (input.is(':checked'));
        (rides.checkPay.length == 0) ?function(){
            rides.checkPay[0]  = {'id':id}
        }():
        function(){
            var ban  = false;
            if(checked){
                var data = {'id':id};
                for(var x = 0; x< rides.checkPay.length;x++){
                    if(rides.checkPay[x].id == id){
                        ban = true;
                    }
                }
                if(!ban){
                    rides.checkPay.push(data);
                }
            }
             else{
                for(var x = 0; x< rides.checkPay.length;x++){
                    if(rides.checkPay[x].id == id){
                        rides.checkPay.splice(x,1);
                    }
                }
            }

        }();
    },
    payFacInPackage:function(){
         //alert(rides.checkPay.length)
         var size = rides.checkPay.length;
        if(size== 0){
            $.bootstrapGrowl("No ha seleccionado traslados para pagar!",
                            {
                                type:'warning',
                                align:'center',
                                width:'auto',
                                delay:2000,
                                allow_dismiss:false
                            });
        }else{
              $('#modal_comprobante_lote').modal({
                backdrop:'static',
                keyboard:true
            }).on('shown.bs.modal',function(e){
                $('#contTraslados').html('Ha seleccionado '+size+' traslados para pagar!')
            }).on('hidden.bs.modal',function(){
                $('#contTraslados').empty();
            });
        }
    },
    payInPackage:function(){
         //alert(rides.checkPay.length)
         var size = rides.checkPay.length;
        if(size== 0){
            $.bootstrapGrowl("No ha seleccionado traslados para pagar!",
                            {
                                type:'warning',
                                align:'center',
                                width:'auto',
                                delay:2000,
                                allow_dismiss:false
                            });
        }else{
              $('#modal_paga_lote').modal({
                backdrop:'static',
                keyboard:true
            }).on('shown.bs.modal',function(e){
                $('#contTraslados').html('Ha seleccionado '+size+' traslados para pagar!')
            }).on('hidden.bs.modal',function(){
                $('#contTraslados').empty();
            });
        }
    },
    factInPackage:function(){
         //alert(rides.checkPay.length)
         var size = rides.checkPay.length;
        if(size== 0){
            $.bootstrapGrowl("No ha seleccionado traslados para pagar!",
                            {
                                type:'warning',
                                align:'center',
                                width:'auto',
                                delay:2000,
                                allow_dismiss:false
                            });
        }else{
              $('#modal_fact_lote').modal({
                backdrop:'static',
                keyboard:true
            }).on('shown.bs.modal',function(e){
                $('#contTraslados').html('Ha seleccionado '+size+' traslados para pagar!')
            }).on('hidden.bs.modal',function(){
                $('#contTraslados').empty();
            });
        }
    },
    init_components:function(){


        $('#table_traslados').on('click',':checkbox',function(e){
            e.preventDefault();
            //rides.modal($(this).attr('id'),$(this).is(':checked')); esta funcion pedi ael kilometraje
            rides.update_ride($(this).attr('id'),'true');
        });

        $('#table_traslados').on('click','a.ver_detalle_traslado',function(e){
            e.preventDefault();
            rides.payments($(this).attr('id'),$(this).data('status'));
        });



        $('#table_traslados').on('click','a.cancelar_traslado',function(e){
            e.preventDefault();

            rides.cancellation($(this).data('traslado'),$(this).data('status'));
        });
        $('#table_traslados').on('change',":input[type='color']",function(){
            var id = $(this).data('id');
            var color = $(this).val();
            rides.changeColor(id,color);

        });
        $('#btnPayFactSelection').on('click',function(){
            rides.payFacInPackage();
        });
        $('#btnPaySelection').on('click',function(){
            rides.payInPackage();
        });
        $('#btnFactSelection').on('click',function(){
            rides.factInPackage();
        });
        $('#table_traslados_pagos').on('click',":checkbox",function(){
            rides.addSelection($(this));

        });


        $('#table_traslados_pagos').on('click','a',function(e){
            e.preventDefault();
            //abrir un modal
            rides.modal_comprobante($(this).attr('id'));
            //rides.pay_ride($(this).attr('id'));
        });

        $('#myform_info_pay_lote').submit(function(e){
            e.preventDefault();
            var  fecha =$('#txt_fecha_pago_lote').val();
            $.ajax({
                url:$(this).attr('action'),
                type:'POST',
                dataType:'json',
                data:{
                    'datos':rides.checkPay,                    
                    'fecha':fecha
                },
                success:function(data){

                    (data.status)?function(){
                        setTimeout(function(){
                           location.reload()
                        },3000);
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

        });

        $('#myform_info_fact_lote').submit(function(e){
            e.preventDefault();
            var tipo = $('#txt_tipo_lote').val();
            var folio =  $('#txt_folios_lote').val();
            $.ajax({
                url:$(this).attr('action'),
                type:'POST',
                dataType:'json',
                data:{
                    'datos':rides.checkPay,
                    'tipo':tipo,
                    'folio':folio
                },
                success:function(data){

                    (data.status)?function(){
                        setTimeout(function(){
                           location.reload()
                        },3000);
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

        });

        $('#myform_info_comprobante_lote').submit(function(e){
            e.preventDefault();
            var tipo = $('#txt_tipo_lote').val();
            var folio =  $('#txt_folio_lote').val();
            var  fecha =$('#txt_fecha_pago_lote').val();
            $.ajax({
                url:$(this).attr('action'),
                type:'POST',
                dataType:'json',
                data:{
                    'datos':rides.checkPay,
                    'tipo':tipo,
                    'folio':folio,
                    'fecha':fecha
                },
                success:function(data){

                    (data.status)?function(){
                        setTimeout(function(){
                           location.reload()
                        },3000);
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

        });

        $('#myform_info_comprobante').submit(function(e){
            e.preventDefault();
            $.ajax({
                url:$(this).attr('action'),
                type:'POST',
                dataType:'json',
                data:$(this).serialize(),
                success:function(data){

                    (data.status)?function(){
                        setTimeout(function(){
                            $("#modal_comprobante").modal('hide');
                        },1000);
                        $('#fecha_pago_'+id_tmp[1]).html(data.fecha);
                        $('#comprobante_'+id_tmp[1]).html(data.folio);
                        $('#payment_'+id_tmp[1]).removeClass('btn-info').addClass('btn-success').html('<strong>Realizado</strong> <span class="fa fa-check"></span>');
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

        });
        $('#myform_info_servicio').submit(function(e){
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
                        //rides.update_ride('chk_'+rides.id_traslado,'true');
                    }();
                },
                error:function(){
                    $('#contError').html('Parece que su conexión a internet no va bien, intentelo más tarde.');
                }
            });
        });

        $('#myform_solicitante').submit(function(e){
            // alert($(this).attr('action'));
            e.preventDefault();
            $.ajax({
                url:$(this).attr('action'),
                type:'POST',
                dataType:'json',
                data:$(this).serialize(),
                success:function(data){
                    if(! data.status){
                        $('#contErrorSolicitante').html(data.msg);
                    }else{

                        $('#contErrorSolicitante').empty().html(data.msg);
                        rides.catalago_solicitantes($("#txt_cliente").val(),rides.url);
                        setTimeout(function(){
                            $("#modal_solicitante").modal('hide');
                            $('#contErrorSolicitante').empty();

                        },3000);
                    }
                },
                error:function(){
                    $('#contErrorSolicitante').html('Parece que su conexión a internet no va bien, intentelo más tarde.');
                }
            });
        });

        $('#myform_detalle_traslado').submit(function(e){

            e.preventDefault();

            $.ajax({
                url:$(this).attr('action'),
                type:'POST',
                dataType:'json',
                data:$(this).serialize(),
                success:function(data){
                    if(! data.status){
                        $('#contErrorDetalle').html(data.msg);
                    }else{

                        $('#contErrorDetalle').empty().html(data.msg);
                        if(rides.pay_mod){
                             rides.showRidesToday();
                             rides.pay_mod = false;
                        }

                        setTimeout(function(){
                            $("#modal_detalle_traslado").modal('hide');
                            $('#contErrorDetalle').empty();

                        },2000);
                    }
                },
                error:function(){
                    $('#contErrorDetalle').html('Parece que su conexión a internet no va bien, intentelo más tarde.');
                }
            });
        });

        $("#btn_nuevo_solicitante").click(function() {
            rides.modal_solicitante();
        });

    },
    showRidesToday:function(){

        var fecha  = $('#txt_traslado').val();
        if($.trim(fecha) === ''){alert('No ha seleccionado una fecha para el traslado');return false;}
        $.ajax({
            url:rides.url+'traslados_hoy.html',
            type:'GET',
            dataType:'json',
            data:{'fecha':fecha},
            success:function(data){
                //console.log(data);

                (!data.status)?
                    function(){
                        alert(data.mensaje);
                    }()
                    :function(){
                    tbl_traslados.fnClearTable();
                    $.each(data.catalogo,function(index){
                        var nombre =  ($(this).attr('CLIENTE') == '') ? $(this).attr('NOMBRE') : $(this).attr('CLIENTE');
                        var estado  = ($(this).attr('ESTATUS') == 'EC') ? 'PENDIENTE' : 'REALIZADO';
                        /*var fecha  = ($(this).attr('FECHA'));
                         var fecha  = fecha + ' ' + ($(this).attr('HORA'));
                         console.log(fecha);*/
                        var add_data = [];
                        add_data.push($(this).attr('ID'));
                        add_data.push(nombre);
                        add_data.push($(this).attr('N_PASAJERO'));
                        add_data.push($(this).attr('RUTA'));
                        add_data.push($(this).attr('MODELO'));
                        add_data.push($(this).attr('NOMBRECH'));
                        //add_data.push(fecha);
                        add_data.push($(this).attr('FECHA'));
                        add_data.push($(this).attr('HORA'));
                        add_data.push('<a href="#" class="btn btn-link btn-xs ver_detalle_traslado" id="'+$(this).attr('ID')+'" data-status="'+$(this).attr('ESTATUS')+'">Ver</a>');
                        //add_data.push(estado);
                        tbl_traslados.fnAddData(add_data);
                    });
                }();
            }

        });

    }
};
$(document).ready(function(){
    tbl_traslados =  $('#resumenTraslados').dataTable({
        "lengthMenu": [[40], [40]],
        "bLengthChange": false,
        "bFilter":false
    });

    rides.init_components();
    $('#btnTrasladosHoy').click(function(){
        rides.showRidesToday();
    })
    $("#myform_traslado").on('submit',function(e){

        var nombre          = $('#txt_nombre').val();
        var num_pasajeros   = $('#txt_num_pasajeros').val();
        var ceco            = $('#txt_ceco').val();
        var monto           = $('#txt_monto').val();

        if ( nombre == '' ) {
            $('#msj_nombre').text('Este campo es obligatorio');
        } else {
            $('#msj_nombre').text('');
        }

        if ( num_pasajeros == '' ) {
            $('#msj_numero_pasajeros').text('Este campo es obligatorio');
        } else {
            $('#msj_numero_pasajeros').text('');
        }

        if ( ceco == '' ) {
            $('#msj_ceco').text('Este campo es obligatorio');
        } else {
            $('#msj_ceco').text('');
        }

        if ( monto == '' ) {
            $('#msj_monto').text('Este campo es obligatorio');
        } else {
            $('#msj_monto').text('');
        }

        console.log(nombre.length);
        if( ( nombre.length * num_pasajeros.length * ceco.length * monto.length ) > 0 ) {

            ( !$('#data_client').is(':checked') && !$('#data_client').is(':checked'))?function(){
                $.bootstrapGrowl(
                    "Debe seleccionar el checkbox de cliente o el de solicitante",
                    {
                        type:'danger',
                        align:'center',
                        width:'auto',
                        delay:3000,
                        allow_dismiss:false
                    }
                );
                e.preventDefault();

            }()
                :function(){
                return true;
            }();
        } else {
            $.bootstrapGrowl(
                "Uno o mas campos obligatorios estan vacios!.",
                {
                    type:'warning',
                    align:'center',
                    width:'auto',
                    delay:3000,
                    allow_dismiss:false
                }
            );
            e.preventDefault();
        }
    });


});
