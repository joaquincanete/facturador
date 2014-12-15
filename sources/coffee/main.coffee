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

	$(".cambiar-listas label").on( "click", (e) ->
		e.preventDefault()
		cambiarLista(e)
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
						$("#datos-cliente").html("
							#{obj.data.nombre}<br>
							<small>#{obj.data.direccion}</small>")

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
					$("#modal-clientes .modal-body tbody")
						.append("
							<tr class='list-cli-row' data-cid='#{key}'>
								<td>#{key}</td>
								<td>#{value.nombre}</td>
								<td>#{value.direccion}</td>
							</tr>")
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

					precio1 = obj.data.precio.lista1
					precio2 = obj.data.precio.lista2
					precio3 = obj.data.precio.lista3

					if $("#lista1").parent().hasClass("active")
						precioFormat = numeral(precio1).format("$ 0,0.00")
					
					else if $("#lista2").parent().hasClass("active")
						precioFormat = numeral(precio2).format("$ 0,0.00")
					
					else if $("#lista3").parent().hasClass("active")
						precioFormat = numeral(precio3).format("$ 0,0.00")

					
					if obj.estado is "exito"
						$("#articulo-denominacion").html("#{obj.data.denominacion}")
						$("#articulo-precio").html("#{precioFormat}")
						$("#articulo-precio").data("precio1", "#{precio1}")
						$("#articulo-precio").data("precio2", "#{precio2}")
						$("#articulo-precio").data("precio3", "#{precio3}")
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
			
			if $("#lista1").parent().hasClass("active")
				precio = parseFloat( $("#articulo-precio").data("precio1") )
			
			else if $("#lista2").parent().hasClass("active")
				precio = parseFloat( $("#articulo-precio").data("precio2") )
			
			else if $("#lista3").parent().hasClass("active")
				precio = parseFloat( $("#articulo-precio").data("precio3") )
			
			importe = cant * precio
			importeFormat = numeral(importe).format("$ 0,0.00")
			
			$("#articulo-importe").data("value", "#{importe}")
			$("#articulo-importe").html("#{importeFormat}")

		return null



	addArticulo = (evt) ->
		# Es Tab (9) o Enter (13)
		if evt.keyCode is 9 or evt.keyCode is 13

			codigo = $("#articulo-codigo").val()
			cantidad = $("#articulo-cantidad").val()
			denominacion = $("#articulo-denominacion").html()
			precio1 = $("#articulo-precio").data("precio1")
			precio2 = $("#articulo-precio").data("precio2")
			precio3 = $("#articulo-precio").data("precio3")
			precioFormat = $("#articulo-precio").html()
			importe = $("#articulo-importe").data("value")
			importeFormat = $("#articulo-importe").html()

			if codigo isnt ""
				if cantidad is ""
					$("#articulo-cantidad").val("1")
					cantidad = "1"

				
				$(".articulos tbody").append("
					<tr>
						<td>#{codigo}</td>
						<td 
							class='text-center cantidad'
							data-value='#{cantidad}'
						>#{cantidad}</td>
						<td>#{denominacion}</td>
						<td 
							class='text-right precio' 
							data-precio1='#{precio1}'
							data-precio2='#{precio2}'
							data-precio3='#{precio3}'

						>
							#{precioFormat}
						</td>
						<td 
							class='text-right importe' 
							data-value='#{importe}'
						>
							#{importeFormat}
						</td>
						<td class='text-right'>
							<a class='btn btn-danger delete-row' href='#'>
								<i class='fa fa-trash'></i>
							</a>
						</td>
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

	

	cambiarLista = (evt) ->
		lista = $(evt.target).find('input').attr('id').replace("lista", "precio")
		
		$(".articulos tbody tr").each((i) ->
			cantidad = $(@).find(".cantidad").data("value")
			precio = $(@).find(".precio").data(lista)
			precioFormat = numeral(precio).format("$ 0,0.00")
			importe = cantidad * precio
			importeFormat = numeral(importe).format("$ 0,0.00")

			$(@).find(".precio").html("#{precioFormat}")
			$(@).find(".importe").data("value", "#{importe}")
			$(@).find(".importe").html("#{importeFormat}")
		)

		actualizaTotales()
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