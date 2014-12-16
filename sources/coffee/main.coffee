###
 * El script esta encapsulado en una funcion anónima autoejecutable
 * para evitar conflictos con otras librerias.
###

# Ejecutamos jQuery en mono no confictos
jQuery.noConflict()
(($)->
	###
  ************************************************************************
  *****************************  $Contenido  *****************************
  * + Contenido
  *
  * + enlazarEventos
  * + 
  * + clientesEstablecer
  * + clientesGeneraLista
  * + clientesObtenerLista
  * + clientesObtenerUno
  * + clientesSeleccionar
  * + 
  * + 
  * + 
  * + 
  * + document.ready()
  * + windows.load()
	###


	# Enlaza todos los eventos correspondientes a las diferentes 
	# funcionalidades de los botones, campos, teclas, etc.
	enlazarEventos = () ->
		### Eventos Globales para todo el documento ###
		$( window ).on( "beforeunload", (e) ->
			return "Todos los datos actuales se perderan si continúa." 
		)

		$("body").on( "keydown", (e) ->
			if e.keyCode is 118
				imprimir()
				return false
			
			else if e.keyCode is 117
				anular()
				return false
			return null
		)



		### Botones ###
		$("#search-clientes").on "click", (e) ->
			e.preventDefault()
			clientesObtenerLista()
			return null

		$(".cambiar-listas label").on "click", (e) ->
			e.preventDefault()
			cambiarLista(e)
			return null

		$("#imprimir").on "click", (e) ->
			e.preventDefault()
			imprimir()
			return null

		$("#anular").on "click", (e) ->
			e.preventDefault()
			anular()
			return null

		$("body").on "click", ".list-cli-row", (e) ->
			e.preventDefault()
			clientesSeleccionar($(@))
			return null

		$("body").on "click", ".delete-row", (e) ->
			e.preventDefault()
			deleteRow($(@))
			return null
		
		$("#clear-form").on "click", (e) ->
			e.preventDefault()
			clearForm()
			return null
			


		### Acciones en campos ###
		$("#cod-cliente").on "blur", (e) ->
			clientesObtenerUno($(@))
			return null

		$("#articulo-codigo").on "blur", (e) ->
			getArticulo($(@))
			return null

		$("#articulo-cantidad").on "keyup", (e) ->
			setCantidad($(@))
			return null
		
		$("#articulo-cantidad").on "keydown", (e) ->
			addArticulo(e)
			return null
		
		return null



	# Establece los datos del cliente en el cuadro "Cliente"
	clientesEstablecer = (nombre, direccion) ->
		$("#datos-cliente").html("#{nombre}<br><small>#{direccion}</small>")
		return null



	# Mustra una ventana modal con la lista de clientes
	clientesGeneraLista = (list) ->
		$("#modal-clientes .modal-body tbody").html("")
		
		$.each( list, ( key, value ) ->
			$("#modal-clientes .modal-body tbody")
				.append("
					<tr 
						class='list-cli-row' 
						data-clicod='#{key}'
						data-clinom='#{value.nombre}'
						data-clidir='#{value.direccion}'
					>
						<td>#{key}</td>
						<td>#{value.nombre}</td>
						<td>#{value.direccion}</td>
					</tr>")
		)
		
		$("#modal-clientes").modal('show')

		return null



	# Obtiene la lista de clientes de la BD
	clientesObtenerLista = () ->
		data = {
			'accion': "obtener-clientes",
			'data': { }
		}

		$.ajax
			data: '&json='+ JSON.stringify(data)
			success: (data, status, xhr) ->
				obj = $.parseJSON(data);
				clientesGeneraLista(obj.data)

			type: 'POST'
			url: "libs/ajax.php"

		return null
	


	# Busca en la BD los datos de un cliente en base al código de cliente
	clientesObtenerUno = (elm) ->
		val = elm.val()
		
		data = {
			'accion': "obtener-cliente",
			'data': { }
		}

		data.data['cliente_codcli'] = val

		if val isnt ''
			$.ajax
				data: '&json='+ JSON.stringify(data)
				success: (data, status, xhr) ->
					obj = $.parseJSON(data);

					if obj.estado is "exito"
						clientesEstablecer(
							obj.data.nombre, 
							obj.data.direccion
						)
					else if obj.estado is "error"
						console.error "Error al obtener el cliente."

				type: 'POST'
				url: "libs/ajax.php"
			return null

		return null



	# Al seleccionar un cliente de la lista actualiza el cuadro "Cliente"
	clientesSeleccionar = (elm) ->
		$("#cod-cliente").val( elm.data("clicod") )
		clientesEstablecer(elm.data("clinom"), elm.data("clidir") )
		$("#modal-clientes").modal('hide')

		return null



	getArticulo = (elm) ->
		val = elm.val()
		data = {
			'accion': "obtener-articulo",
			'data': { }
		}

		data.data['articulo_codart'] = val

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
				url: "libs/ajax.php"
			return null
	


	setCantidad = (elm) ->
		if $("#articulo-codigo").val() isnt ""
			cantidad = elm.val()
			if cantidad is ""
				cantidad = "1"

			elm.parent().data("value", cantidad)
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
						<td class='codigo'>#{codigo}</td>
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
						<td class='text-right acc'>
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
		$("#articulo-cantidad").data("value", "")
		$("#articulo-denominacion").html("")
		$("#articulo-precio").html("$ 0,00")
		$("#articulo-precio").data("precio1", "0")
		$("#articulo-precio").data("precio2", "0")
		$("#articulo-precio").data("precio3", "0")
		$("#articulo-importe").html("$ 0,00")
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
		
		$(".articulos tr").each((i) ->
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



	imprimir = () ->
		if confirm("
				¿Confirma que desea imprimir el recibo y procesar el stock?\n\n
				Total: #{$("#total").html()}\n
				Cantidad de Artículos: #{$("#contar").html()}

			")

			procesarStocks()
	


	anular = () ->
		clearForm()

		$("#cod-cliente").val("")
		$("#datos-cliente").html("Cliente<br><small>Dirección</small>")

		$(".articulos tbody").html("")

		actualizaTotales()

		$(".cambiar-listas label").removeClass("active")
		$($(".cambiar-listas label")[0]).addClass("active")

		$("#cod-cliente").focus()


	procesarStocks = () ->
		data = {
			'accion': "actualizar-stock",
			'data': { }
		}

		articulos = []

		$(".articulos tbody tr").each((i) ->
			articulos.push({
				"codigo": $(@).find("td.codigo").html(),
				"cantidad": $(@).find("td.cantidad").data("value")
			})
		)

		data.data['articulos'] = articulos

		$.ajax
			beforeSend: (xhr, settings) ->
				return null

			complete: (xhr, status)->
				return null

			data: '&json='+ JSON.stringify(data)
			success: (data, status, xhr) ->
				obj = $.parseJSON(data);

				if obj.estado is "exito"
					window.print()
					anular()
				else
					alert("Error al procesar stocks")

			type: 'POST'
			url: "libs/ajax.php"
		return null





	### begin $( document ).ready() block.  ###
	$ () ->
		enlazarEventos()

		#Configuramos el plugin Numeral para dar formato a los numeros
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
		

		$.ajax
			data: 'ajax=1'
			success: (data, status, xhr) ->
				obj = $.parseJSON(data);

				$("#empresa_nombre").html("#{obj.empresa_nombre}")
				$("#developed_by").html("#{obj.developed_by}")


			type: 'POST'
			url: "config.php"
		return null 
	### end $( document ).ready() block.  ###
	

	### begin $( window ).load() block.  ###
	$(window).load () ->
	### end $( window ).load() block.  ###
	return null 
)(jQuery)