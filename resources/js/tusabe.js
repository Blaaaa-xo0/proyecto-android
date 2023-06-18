mymap.on('click', function(e) {
    // Obtener la latitud y longitud del punto donde se hizo clic
    var latitude = e.latlng.lat;
    var longitude = e.latlng.lng;

    // Pedir al usuario que ingrese el nombre y la descripción del punto
    var name = prompt('Ingrese el nombre del punto:');
    var description = prompt('Ingrese la descripción del punto:');

    // Enviar una solicitud AJAX al método "store" del controlador del mapa
    $.ajax({
        url: '{{ route('map.store') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            name: name,
            description: description,
            latitude: latitude,
            longitude: longitude,
        },
        success: function(response) {
            // Obtener el ID del marcador recién creado
            var id = response.id;

            // Agregar un marcador en el mapa en el punto donde se hizo clic
            var marker = L.marker([latitude, longitude]).addTo(mymap)
                .bindPopup(
                    '<b>' + name + '</b><br>' + description +
                    '<br><button class="delete-button" data-id="' + id + '">Eliminar</button>' +
                    '<br><button class="edit-button" data-id="' + id + '">Editar</button>'
                );

            // Agregar un controlador de eventos para el evento "popupopen" en el marcador
            marker.on('popupopen', function(e) {
                $('.edit-button').on('click', function() {
                    // Obtener el ID del marcador que se está editando
                    var id = $(this).data('id');

                    // Obtener la información actual del marcador
                    var name = e.target._popup._content.match(/<b>(.*?)<\/b>/)[1];
                    var description = e.target._popup._content.split('<br>')[1];

                    // Mostrar el formulario para editar la información del marcador
                    $('#edit-id').val(id);
                    $('#edit-name').val(name);
                    $('#edit-description').val(description);
                    $('#edit-form').show();
                });

                $('.delete-button').on('click', function() {
                    // Obtener el ID del marcador que se está eliminando
                    var id = $(this).data('id');

                    // Enviar una solicitud AJAX al método "destroy" del controlador del mapa
                    $.ajax({
                        url: '/map/' + id,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function() {
                            // Eliminar el marcador del mapa
                            mymap.removeLayer(e.popup._source);
                        }
                    });
                });
            });
        }
    });
});
