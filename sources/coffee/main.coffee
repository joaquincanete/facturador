(($)->
	#Enlazando eventos
	$("#cod-cliente").on( "blur", () ->
		getCliente($(@))
	)
	
	'''
	$( window ).on( "beforeunload", () ->
		return "Todos los datos actuales se perderan si continúa." 
	)
	'''

	$("#search-clientes").on( "click", () ->
		getClientes()
	)
	
	$("body").on( "click", ".list-cli-row", () ->
		$("#cod-cliente").val $(@).data("cid")
		$("#modal-clientes").modal('hide')
		$("#cod-cliente").blur()
	)

	#funciones
	getCliente = (elm) ->
		val = elm.val()
		data = {
			'accion': "obtener-cliente",
			'data': { }
		}

		data.data['cliente-id'] = val

		if val isnt ''
			$.ajax
				beforeSend: (xhr, settings) ->
					return null

				complete: (xhr, status)->
					return null

				data: '&json='+ JSON.stringify(data)
				success: (data, status, xhr) ->
					obj = $.parseJSON(data);

					if obj.estado is "exito"
						$("#datos-cliente").html("#{obj.data.nombre}<br><small>#{obj.data.direccion}</small>")

				type: 'POST'
				url: "ajax.php"
			return null
	


	getClientes = () ->
		data = {
			'accion': "obtener-clientes",
			'data': { }
		}

		$.ajax
			beforeSend: (xhr, settings) ->
				return null

			complete: (xhr, status)->
				return null

			data: '&json='+ JSON.stringify(data)
			success: (data, status, xhr) ->
				obj = $.parseJSON(data);
				#console.log obj
				$.each( obj.data, ( key, value ) ->
					$("#modal-clientes .modal-body tbody").append("<tr class='list-cli-row' data-cid='#{key}'><td>#{key}</td><td>#{value.nombre}</td><td>#{value.direccion}</td></tr>")
				)
				
				$("#modal-clientes").modal('show')

			type: 'POST'
			url: "ajax.php"
		return null

)(jQuery)