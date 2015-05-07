var tbl_traslados;
var rides = {
    data: Array(),
    pos:0,
    id_chk:'',
    id_traslado:'',
    cerrar:false,
    url:'',
    solicintantes:Array(),
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
                        $('#'+id).parent().parent().addClass('success');
                        $('#estado_t_'+id_tmp[1]).text('REALIZADO');
                        $('#chk_'+id_tmp[1]).attr('disabled','disabled');
                        $('#chk_'+id_tmp[1]).prop( "checked", true );
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

        $('#table_traslados_pagos').on('click','a',function(e){
            e.preventDefault();
            //abrir un modal
            rides.modal_comprobante($(this).attr('id'));
            //rides.pay_ride($(this).attr('id'));
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
    });


});
