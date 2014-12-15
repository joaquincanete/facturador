(($)->

	#load a language
	numeral.language('es', {
		delimiters: {
			thousands: '.',
			decimal: ','
		},
		currency: {
			symbol: '$'
		}
	});
	#switch between languages
	numeral.language('es');


	#Enlazando eventos
	$("#cod-cliente").on( "blur", () ->
		getCliente($(@))
	)
	
	'''
	$( window ).on( "beforeunload", () ->
		return "Todos los datos actuales se perderan si continúa." 
	)
	'''

	$("#search-clientes").on( "click", (e) ->
		e.preventDefault()
		getClientes()
	)
	
	$("body").on( "click", ".list-cli-row", (e) ->
		e.preventDefault()
		$("#cod-cliente").val $(@).data("cid")
		$("#modal-clientes").modal('hide')
		$("#cod-cliente").blur()
	)

	$("body").on( "click", ".delete-row", (e) ->
		e.preventDefault()
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
	$("#clear-form").on( "click", (e) ->
		e.preventDefault()
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

					precio = obj.data.precio
					precioFormat = numeral(precio).format("$ 0,0.00")

					if obj.estado is "exito"
						$("#articulo-denominacion").html("#{obj.data.denominacion}")
						$("#articulo-precio").html("#{precio}")
						$("#articulo-precio").data("precio", "#{precio}")
						$("#articulo-importe").html("#{precioFormat}")

				type: 'POST'
				url: "ajax.php"
			return null
	


	setCantidad = (cantidad, evt) ->
		if $("#articulo-codigo").val() isnt ""
			cantidad = cantidad.val()
			if cantidad is ""
				cantidad = "1"

			cant = parseFloat(cantidad)
			precio = parseFloat( $("#articulo-precio").data("precio") )
			
			importe = cant * precio
			importeFormat = numeral(importe).format("$ 0,0.00")
			
			$("#articulo-importe").data("value", "#{importe}")
			$("#articulo-importe").html("#{importeFormat}")

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
						<td class='text-right importe' data-value='#{$("#articulo-importe").data("value")}'>#{$("#articulo-importe").html()}</td>
						<td class='text-right'><a class='btn btn-danger delete-row' href='#'><i class='fa fa-trash'></i></a></td>
					</tr>
				")

				evt.preventDefault()

				actualizaTotales()

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
		actualizaTotales()
		clearForm()


	actualizaTotales = () ->
		total = 0
		$(".articulos tbody tr").each((i) ->
			total += parseFloat( $(@).find("td.importe").data("value") )
		)
		totalFormat = numeral(total).format("$ 0,0.00")
		$("#total").html(totalFormat)

		$("#contar").html( $(".articulos tbody tr").length )


	##
	##
	##
	## Listas de precios
	## Imprimir
	##     Enviar datos al backend para descontar stock
	##     css print
	## Anular
	##
	##
	##

)(jQuery)