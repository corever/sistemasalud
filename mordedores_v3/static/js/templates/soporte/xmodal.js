/**
 * xModaljs
 */


var xModal = {
	backIndex : 1040,
	modalIndex : 1041,
	progress_bar : '<div class="progress"><div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="45" aria-valuemin="100" aria-valuemax="100" style="width: 100%"><strong style="color:#fff">Cargando...</strong></div></div>',

	/**
	 * Abrir un modal simple
	 * @param  {[type]} _item         Puede ser un contenedor o una url a cargar
	 * @param  {[type]} _title        Titulo del modal
	 * @param  {[type]} _size         Ancho del modal, en porcentaje o lg,sm
	 * @param  {[type]} _isIframe     Indica si el contenido a cargar en el modal corresponde a un iframe. Valor debe ser true
	 * @param  {[type]} _iframeHeight Altura para el iframe
	 * @return {[type]}               [description]
	 */
	open : function(_item,_title,_size,_isIframe,_iframeHeight,_footer){
		var content = '';
		var size = '';
		var footer = '';
		var widthModal = '';
		
		if(typeof _item === "object"){
			content = $(_item).html();
		}


		if(_size !== undefined){
			if(isNaN(_size)){
				if(_size == 'lg'){
					var size = ' modal-lg';
				}else if(_size == 'sm'){
					var size = ' modal-sm';
				}
			}else{
				if(_size > 0){
					widthModal = 'width:'+_size + '%';
				}
			}

		}

		var titulo = '<h4 class="modal-title text-left">&nbsp;</h4>';
		if(_title !== undefined){
			titulo = '<h4 class="modal-title text-left">'+_title+'</h4>';
		}

		if(_isIframe !== undefined && _isIframe === true){
			var heightIframe = $(window).height();
			if(_iframeHeight !== undefined && !isNaN(_iframeHeight)){
				heightIframe = _iframeHeight;
			}
			content = '<iframe src="'+_item+'" height="'+heightIframe+'" width="100%" style="border:none"></iframe>';
		}

		if(_footer !== undefined){
			footer = '<div class="modal-footer">'+_footer+'</div>';
		}

		var innerModal = '<div class="modal fade modal-page" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow-y:scroll;">'+
							  '<div class="modal-dialog '+size+' modal-lg-xs" style="margin-top:10px; '+widthModal+'">'+
							    '<div class="modal-content panel-primary" >'+
							      '<div class="modal-header panel-heading">'+
								     '<button type="button" class="close" onclick="xModal.close();"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+
								     titulo+
	      							'</div>'+
							      '<div class="modal-body" style="overflow:hidden;"><div id="content-modal">'+
							      content+
							    '</div></div>'+
							    footer+
							    '</div>'+
							  '</div>'+
							'</div>';
		$('body').append(innerModal);

		

		if(_isIframe !== true){
			if(typeof _item === "object"){
				var modalFooter = '<div class="modal-footer"><button type="button" class="btn btn-default" onclick="xModal.close();">Cerrar</button></div>';
				$('.modal .modal-content').last().append(modalFooter);
				$('.modal #content-modal').last().css({height:"auto"});
				$('.modal').last().modal({backdrop:'static',keyboard:false});
			}else{
				$('.modal #content-modal').last().load(_item,function(){
					$('.modal #content-modal').last().css({height:"auto"});
					$('.modal').last().modal({backdrop:'static',keyboard:false});	
					/*$('.modal #content-cargando').last().fadeOut(function(){

						$('.modal #content-modal').last().animate({height:"toggle"},function(){
							$('.modal #content-modal').last().fadeIn();
						});

					});*/
				});
			}

			/*
			$('#modal_'+Modal.item_modal+' #content-modal').load(_url,function(){
				$(".progress").fadeOut();
			});
			*/
		}else{
			$('.modal #content-modal').last().css({height:"auto"});
			$('.modal').last().modal({backdrop:'static',keyboard:false});
			/*$('.modal #content-cargando').last().fadeOut(function(){
				$('.modal #content-modal').last().animate({height:"toggle"},function(){
					$('.modal #content-modal').last().fadeIn();
				});

			});*/
		}
		/*$('.modal').last().modal({backdrop:'static',keyboard:false});*/
	},

	/**
	 * Cerrar modal activo
	 * @return {[type]} [description]
	 */
	close : function(modalIndex){
        $('body').removeClass('modal-open').css('padding-right','0');
		$(".modal").last().modal('hide').fadeOut(function(){
			$(this).remove();
			$('.modal-backdrop').last().fadeOut('fast',function(){
				$(this).remove();
			});

		});
		/* parent.location.reload(); */
		/*if(modalIndex === undefined){
			$(".modal").last().modal('hide').fadeOut(function(){
				$(this).remove();
				$('.modal-backdrop').last().fadeOut('fast',function(){
					$(this).remove();
				});
			});	
		}else{
			$("#"+modalIndex).last().modal('hide').fadeOut(function(){
				$(this).remove();
				$('.modal-backdrop').last().fadeOut('fast',function(){
					$(this).remove();
				});
			});
		}*/

	},

	/**
	 * Cerrar todas los modales abiertos
	 * @return {[type]} [description]
	 */
	closeAll : function(){
        $('body').removeClass('modal-open').css('padding-right','0');;
		$(".modal").modal('hide').fadeOut(function(){
			$(this).remove();
			$('.modal-backdrop').fadeOut(function(){
				$(this).remove();
			});
		});
	},


	/**
	 * Alerta para mensajes exitosos
	 * @return {[type]} [description]
	 */
	success : function(_msg,_callback){
		var backLast = $(".modal-backdrop").last().css('z-index');
		var modalLast = $(".modal").last().css('z-index');
		if(backLast !== undefined){
			backLast = parseInt(modalLast) + 1;
			modalLast = parseInt(backLast) + 1;
		}else{
			backLast = this.backIndex;
			modalLast = this.modalIndex;
		}
		var innerModal = '<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-success">'+
							  '<div class="modal-dialog modal-sm" style="margin-top:16px;">'+
							    '<div class="modal-content panel-success">'+
							      '<div class="modal-header panel-heading" >'+

								     '<h5 class="modal-title"><span class="glyphicon glyphicon-ok-sign"></span> <strong>Exito</strong></h5>'+
	      							'</div>'+
							      	'<div class="modal-body" style="overflow:hidden" id="content-modal">'+_msg+'</div>'+
							      	'<div class="modal-footer"><button type="button" class="btn btn-success" onclick="xModal.close(\'modal-success\')" id="btn-aceptarAlerta">Aceptar</button></div>'+
							    '</div>'+
							  '</div>'+
							'</div>';

		$('body').append(innerModal);
		$("#modal-success").css('z-index',modalLast,'important')
		.on('hide.bs.modal',function(e){
			$("#modal-success").fadeOut(function(){
				$(this).remove();
				$(".modal-backdrop").last().remove();
			});
			/*if(_callback && (typeof _callback === "function")){
				_callback();
				
			}
			*/
		}).on('click','#btn-aceptarAlerta',function(e){
			if(_callback && (typeof _callback === "function")){
				_callback();
			}
		}).modal({backdrop:'static'});
		$(".modal-backdrop").last().css('z-index',backLast,'important');
	},

	/**
	 * Alerta de mensajes de confirmaci??n
	 * @return {[type]} [description]
	 */
	confirm : function(_msg,_callback, _callback2){
		var backLast = $(".modal-backdrop").last().css('z-index');
		var modalLast = $(".modal").last().css('z-index');
		if(backLast !== undefined){
			backLast = parseInt(modalLast) + 1;
			modalLast = parseInt(backLast) + 1;
		}else{
			backLast = this.backIndex;
			modalLast = this.modalIndex;
		}
		var innerModal = '<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-confirm">'+
							  '<div class="modal-dialog modal-sm" style="margin-top:16px;">'+
							    '<div class="modal-content panel-primary" >'+
							      '<div class="modal-header panel-heading" >'+

								     '<h5 class="modal-title"><span class="glyphicon glyphicon-question-sign"></span> <strong>Confirmaci??n</strong></h5>'+
	      							'</div>'+
							      	'<div class="modal-body" style="overflow:hidden" id="content-modal">'+_msg+'</div>'+
							      	'<div class="modal-footer">'+
							      	'<button type="button" class="btn btn-default" onclick="xModal.close();" id="btn-noConfirm">No</button>'+
							      	'<button type="button" class="btn btn-primary" onclick="xModal.close();" id="btn-siConfirm">Si</button></div>'+
							    '</div>'+
							  '</div>'+
							'</div>';


		$('body').append(innerModal);
		$("#modal-confirm").css('z-index',modalLast,'important')
		.on('hide.bs.modal',function(e){
			$("#modal-confirm").fadeOut(function(){
				$(this).remove();
				$(".modal-backdrop").last().remove();
			});
			/*if(_callback && (typeof _callback === "function")){
				_callback();
				
			}
			*/
		}).on('click','#btn-siConfirm',function(e){
			if(_callback && (typeof _callback === "function")){
				_callback();
			}
		}).on('click','#btn-noConfirm',function(e){
			if(_callback2 && (typeof _callback2 === "function")){
				_callback2();
			}
		}).modal({backdrop:'static'});
		$(".modal-backdrop").last().css('z-index',backLast,'important');
	},

	/**
	 * Alerta para informacion
	 * @return {[type]} [description]
	 */
	info : function(_msg,_callback){
		var backLast = $(".modal-backdrop").last().css('z-index');
		var modalLast = $(".modal").last().css('z-index');
		if(backLast !== undefined){
			backLast = parseInt(modalLast) + 1;
			modalLast = parseInt(backLast) + 1;
		}else{
			backLast = this.backIndex;
			modalLast = this.modalIndex;
		}
		var innerModal = '<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-info">'+
							  '<div class="modal-dialog modal-sm" style="margin-top:16px; ">'+
							    '<div class="modal-content panel-info" style="width:586px">'+
							      '<div class="modal-header panel-heading" >'+

								     '<h5 class="modal-title"><span class="glyphicon glyphicon-info-sign"></span> <strong>Informaci??n</strong></h5>'+
	      							'</div>'+
							      	'<div class="modal-body" style="overflow:hidden" id="content-modal">'+_msg+'</div>'+
							      	'<div class="modal-footer"><button type="button" class="btn btn-default" onclick="xModal.close()" id="btn-aceptarAlerta">Aceptar</button></div>'+
							    '</div>'+
							  '</div>'+
							'</div>';

		$('body').append(innerModal);
		$("#modal-info").css('z-index',modalLast,'important')
		.on('hide.bs.info',function(e){
			$("#modal-success").fadeOut(function(){
				$(this).remove();
				$(".modal-backdrop").last().remove();
			});
			/*if(_callback && (typeof _callback === "function")){
				_callback();
				
			}
			*/
		}).on('click','#btn-aceptarAlerta',function(e){
			if(_callback && (typeof _callback === "function")){
				_callback();
			}
		}).modal({backdrop:'static'});
		$(".modal-backdrop").last().css('z-index',backLast,'important');
	},

	/**
	 * Alerta para mensajes de errores
	 * @return {[type]} [description]
	 */
	danger : function(_msg,_callback){
		var backLast = $(".modal-backdrop").last().css('z-index');
		var modalLast = $(".modal").last().css('z-index');
		if(backLast !== undefined){
			backLast = parseInt(modalLast) + 1;
			modalLast = parseInt(backLast) + 1;
		}else{
			backLast = this.backIndex;
			modalLast = this.modalIndex;
		}
		var innerModal = '<div class="modal fade" id="modal-error" aria-labelledby="myLargeModalLabel2" aria-hidden="true">'+
							  '<div class="modal-dialog modal-sm" style="margin-top:16px;">'+
							    '<div class="modal-content panel-danger">'+
							      '<div class="modal-header panel-heading" >'+
								     '<h5 class="modal-title"><span class="glyphicon glyphicon-remove-sign"></span> <strong>Error</strong></h5>'+
	      							'</div>'+
							      	'<div class="modal-body small" style="overflow:hidden" id="content-modal">'+_msg+'</div>'+
							      	'<div class="modal-footer"><button type="button" class="btn btn-danger" onclick="xModal.close(\'modal-error\')" id="btn-aceptarAlerta"><strong>Aceptar</strong></button></div>'+
							    '</div>'+
							  '</div>'+
							'</div>';

		$('body').append(innerModal);
		
		$("#modal-error").css('z-index',modalLast,'important')
		.on('hide.bs.modal',function(e){
			$("#modal-error").fadeOut(function(){
				$(this).remove();
				$(".modal-backdrop").last().remove();

			});
			/*if(_callback && (typeof _callback === "function")){
				_callback();
				
			}
			*/
		}).on('click','#btn-aceptarAlerta',function(e){
			if(_callback && (typeof _callback === "function")){
				_callback();
			}
		}).modal({backdrop:'static'});
		$(".modal-backdrop").last().css('z-index',backLast,'important');
		
	},


	/**
	 * Alerta para mensajes de errores
	 * Copia de danger
	 * @return {[type]} [description]
	 */
	error : function(_msg,_callback){
		var backLast = $(".modal-backdrop").last().css('z-index');
		var modalLast = $(".modal").last().css('z-index');
		if(backLast !== undefined){
			backLast = parseInt(modalLast) + 1;
			modalLast = parseInt(backLast) + 1;
		}else{
			backLast = this.backIndex;
			modalLast = this.modalIndex;
		}
		var innerModal = '<div class="modal fade" id="modal-error" aria-labelledby="myLargeModalLabel2" aria-hidden="true">'+
							  '<div class="modal-dialog modal-sm" style="margin-top:16px;">'+
							    '<div class="modal-content panel-danger">'+
							      '<div class="modal-header panel-heading" >'+
								     '<h5 class="modal-title"><span class="glyphicon glyphicon-remove-sign"></span> <strong>Error</strong></h5>'+
	      							'</div>'+
							      	'<div class="modal-body small" style="overflow:hidden" id="content-modal">'+_msg+'</div>'+
							      	'<div class="modal-footer"><button type="button" class="btn btn-danger" onclick="xModal.close(\'modal-error\')" id="btn-aceptarAlerta"><strong>Aceptar</strong></button></div>'+
							    '</div>'+
							  '</div>'+
							'</div>';

		$('body').append(innerModal);
		
		$("#modal-error").css('z-index',modalLast,'important')
		.on('hide.bs.modal',function(e){
			$("#modal-error").fadeOut(function(){
				$(this).remove();
				$(".modal-backdrop").last().remove();

			});
			/*if(_callback && (typeof _callback === "function")){
				_callback();
				
			}
			*/
		}).on('click','#btn-aceptarAlerta',function(e){
			if(_callback && (typeof _callback === "function")){
				_callback();
			}
		}).modal({backdrop:'static'});
		$(".modal-backdrop").last().css('z-index',backLast,'important');
		
	},

	warning : function(_msg, _callback){
		var backLast = $(".modal-backdrop").last().css('z-index');
		var modalLast = $(".modal").last().css('z-index');
		if(backLast !== undefined){
			backLast = parseInt(modalLast) + 1;
			modalLast = parseInt(backLast) + 1;
		}else{
			backLast = this.backIndex;
			modalLast = this.modalIndex;
		}
		var innerModal = '<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-warning">'+
							  '<div class="modal-dialog modal-sm" style="margin-top:16px;">'+
							    '<div class="modal-content panel-warning">'+
							      '<div class="modal-header panel-heading" >'+
								     '<h5 class="modal-title"><span class="glyphicon glyphicon-warning-sign"></span> <strong>Atenci??n</strong></h5>'+
	      							'</div>'+
							      	'<div class="modal-body" style="overflow:hidden" id="content-modal">'+_msg+'</div>'+
							      	'<div class="modal-footer"><button type="button" class="btn btn-warning" onclick="xModal.close(\'modal-warning\')" id="btn-aceptarAlerta">Aceptar</button></div>'+
							    '</div>'+
							  '</div>'+
							'</div>';

		$('body').append(innerModal);
		$("#modal-warning").css('z-index',modalLast,'important')
		.on('hide.bs.modal',function(e){
			$("#modal-warning").fadeOut(function(){
				$(this).remove();
				$(".modal-backdrop").last().remove();
			});
			/*if(_callback && (typeof _callback === "function")){
				_callback();
				
			}
			*/
		}).on('click','#btn-aceptarAlerta',function(e){
			if(_callback && (typeof _callback === "function")){
				_callback();
			}
		}).modal({backdrop:'static'});
		$(".modal-backdrop").last().css('z-index',backLast,'important');
	}
}
