<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-12" id="div">
        <div id="edit-form" style="display: none;">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class=" p-5">
                            <input type="hidden" id="edit-id">

                            <div class="relative z-0 max-w-md mb-6 group">
                                <input type="text" id="edit-name"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="edit-name"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre</label>
                            </div>
                            <div class="relative z-0 max-w-md mb-6 group">
                                <input type="text" id="edit-description"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="edit-description"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Descripción</label>
                            </div>
                            <button id="edit-submit"
                                class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Guardar
                                cambios</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class=" p-5">
                        <p class="text-2xl font-extrabold">Actualmente estás logeado como
                            {{ Auth::user()->getRoleNames()->first() }}</p>
                    </div>

                    <div class="p-5">

                        <x-maps-leaflet :centerPoint="['lat' => 0.4453957, 'long' => -76.0545044]" :zoomLevel="7" :markers="[['lat' => 0.4453957, 'long' => -76.0545044]]">

                        </x-maps-leaflet>


                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    var currentMarker;
    // Agregar un controlador de eventos para el evento "click" en el mapa
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
                        '<b class="p-3 font-lg font-semibold">' +
                        name +
                        '</b><br>' +
                        description +
                        '<br><br><button class="delete-button text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 rounded-lg text-sm px-2.5 py-2 text-center mr-2 mb-2" data-id="' +
                        id +
                        '">Eliminar</button><br><button class="edit-button text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 rounded-lg text-sm px-2.5 py-2 text-center mr-2 mb-2" data-id="' +
                        id +
                        '">Editar</button>',
                    );

                // Agregar un controlador de eventos para el evento "popupopen" en el marcador
                marker.on('popupopen', function(e) {
                    currentMarker = e.target;
                    
                    $('.edit-button').on('click', function() {
                        var id = $(this).data('id');

                        // Obtener la información actual del marcador
                        var name = e.target._popup._content.match(/<b class="p-3 font-lg font-semibold">(.*?)<\/b>/)[1];
                        var description = e.target._popup._content.split('<br>')[1];

                        // Mostrar el formulario para editar la información del marcador
                        $('#edit-id').val(id);
                        $('#edit-name').val(name);
                        $('#edit-description').val(description);
                        $('#edit-form').show();

                        document.getElementById('div').scrollIntoView();
                    });

                    $('.delete-button').on('click', function() {
                        // Obtener el ID del marcador que se está eliminando
                        var id = $(this).data('id');

                        // Enviar una solicitud AJAX al método "destroy" del controlador del mapa
                        $.ajax({
                            url: 'map/' + id,
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


    // Crear un grupo de capas
    var markersGroup = L.featureGroup();

    @foreach ($mapas as $mapa)
        // Agregar cada marcador al grupo de capas
        var marker = L.marker([{{ $mapa->latitude }}, {{ $mapa->longitude }}])
            .bindPopup({!! json_encode(
                '<b class="p-3 font-lg font-semibold">' .
                    $mapa->name .
                    '</b><br>' .
                    $mapa->description .
                    '<br><br><button class="delete-button text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 rounded-lg text-sm px-2.5 py-2 text-center mr-2 mb-2" data-id="' .
                    $mapa .
                    '">Eliminar</button><br><button class="edit-button text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 rounded-lg text-sm px-2.5 py-2 text-center mr-2 mb-2" data-id="' .
                    $mapa->id .
                    '">Editar</button>',
            ) !!});
        markersGroup.addLayer(marker);
        // Agregar un controlador de eventos para el evento "click" en el marcador


        marker.on('popupopen', function(e) {
            currentMarker = e.target;

            $('.edit-button').on('click', function() {
                // Obtener el ID del marcador que se está editando
                var id = $(this).data('id');

                // Obtener la información actual del marcador
                var name = e.target._popup._content.match(
                    /<b class="p-3 font-lg font-semibold">(.*?)<\/b>/)[1];
                var description = e.target._popup._content.split('<br>')[1];

                // Mostrar el formulario para editar la información del marcador
                $('#edit-id').val(id);
                $('#edit-name').val(name);
                $('#edit-description').val(description);
                $('#edit-form').show();

                document.getElementById('div').scrollIntoView();

            });

            $('.delete-button').on('click', function() {


                // Enviar una solicitud AJAX al método "destroy" del controlador del mapa
                $.ajax({
                    url: "{{ route('map.destroy', $mapa) }}",
                    method: 'delete',
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
    @endforeach

    // Agregar el grupo de capas al mapa
    markersGroup.addTo(mymap);

    // Ajustar el área visible del mapa a los límites del grupo de capas
    mymap.fitBounds(markersGroup.getBounds());

    $('#edit-submit').on('click', function() {
        // Obtener los datos del formulario
        var id = $('#edit-id').val();
        var name = $('#edit-name').val();
        var description = $('#edit-description').val();

        // Enviar una solicitud AJAX al método "update" del controlador del mapa
        $.ajax({
            url: '/map/update/' + id,
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                name: name,
                description: description,
            },
            success: function() {
                // Actualizar el contenido del popup del marcador
                currentMarker.setPopupContent('<b class="p-3 font-lg font-semibold">' +
                    name +
                    '</b><br>' +
                    description +
                    '<br><br><button class="delete-button text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 rounded-lg text-sm px-2.5 py-2 text-center mr-2 mb-2" data-id="' +
                    id +
                    '">Eliminar</button><br><button class="edit-button text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 rounded-lg text-sm px-2.5 py-2 text-center mr-2 mb-2" data-id="' +
                    id +
                    '">Editar</button>',
                );
                // Ocultar el formulario
                $('#edit-form').hide();

                location.reload();
            }
        });
    });
</script>
