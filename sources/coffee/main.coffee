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

	$("body").on( "click", ".delete-row", () ->
		deleteRow($(@))
	)

	$("#articulo-codigo").on( "blur", () ->
		getArticulo($(@))
	)

	$("#articulo-cantidad").on( "keyup", (e) ->
		setCantidad($(@), e)
	)
	
	$("#articulo-cantidad").on( "keydown", (e) ->
		addArticulo(e)
	)
	$("#clear-form").on( "click", () ->
		clearForm()
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
				$.each( obj.data, ( key, value ) ->
					$("#modal-clientes .modal-body tbody").append("<tr class='list-cli-row' data-cid='#{key}'><td>#{key}</td><td>#{value.nombre}</td><td>#{value.direccion}</td></tr>")
				)
				
				$("#modal-clientes").modal('show')

			type: 'POST'
			url: "ajax.php"
		return null



	getArticulo = (elm) ->
		val = elm.val()
		data = {
			'accion': "obtener-articulo",
			'data': { }
		}

		data.data['articulo-id'] = val

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
						$("#articulo-denominacion").html("#{obj.data.denominacion}")
						$("#articulo-precio").html("$ #{obj.data.precio}")
						$("#articulo-importe").html("$ #{obj.data.precio}")

				type: 'POST'
				url: "ajax.php"
			return null
	


	setCantidad = (cantidad, evt) ->
		if $("#articulo-codigo").val() isnt ""
			cantidad = cantidad.val()
			if cantidad is ""
				cantidad = "0"

			importe = parseFloat(cantidad) * parseFloat($("#articulo-precio").html().replace("$ ", ""))
			$("#articulo-importe").html("$ #{importe}")




		return null

	addArticulo = (evt) ->
		# Es Tab (9) o Enter (13)
		if evt.keyCode is 9 or evt.keyCode is 13
			if $("#articulo-codigo").val() isnt ""
				if $("#articulo-cantidad").val() is ""
					$("#articulo-cantidad").val("1")
				
				$(".articulos tbody").append("
					<tr>
						<td>#{$("#articulo-codigo").val()}</td>
						<td class='text-center'>#{$("#articulo-cantidad").val()}</td>
						<td>#{$("#articulo-denominacion").html()}</td>
						<td class='text-right'>#{$("#articulo-precio").html()}</td>
						<td class='text-right'>#{$("#articulo-importe").html()}</td>
						<td class='text-right'><a class='btn btn-danger delete-row' href='#'><i class='fa fa-trash'></i></a></td>
					</tr>
				")

				evt.preventDefault()
				clearForm()
	
	clearForm = () ->
		$("#articulo-codigo").val("")
		$("#articulo-cantidad").val("")
		$("#articulo-denominacion").html("")
		$("#articulo-precio").html("$ 0.00")
		$("#articulo-importe").html("$ 0.00")
		$("#articulo-codigo").focus()




	deleteRow = (elm) ->
		elm.parents("tr").remove()
		clearForm()



	##
	##
	##
	## Formato del precio de los artículos
	## Listas de precios
	##
	##
	##

)(jQuery)