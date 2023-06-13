<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Admin users') }}
        </h2>
    </x-slot>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h1 class="text-center font-extrabold text-3xl py-2">LISTA DE USUARIOS</h1>

                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center px-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" id="name" name="nombre"
                            class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Busqueda de usuarios">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="resultado">

    </div>
</x-app-layout>

<script>
    $("#name").on("input", function() {
        const nombre = $(this).val();

        $.ajax({
            url: "{{ route('filter-users') }}",
            data: {
                nombre: nombre
            },
            success: function(html) {
                $("#resultado").html(html);
                console.log('filtrado correct');
            }
        });
    });

    $(document).ready(function() {
        $.ajax({
            url: "{{ route('filter-users') }}",
            success: function(html) {
                $("#resultado").html(html);
                console.log('filtrado initialized');
            }
        });
    });
</script>
