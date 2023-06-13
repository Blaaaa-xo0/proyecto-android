<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Admin Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-900 ">
                            <thead class="text-xs text-gray-900 uppercase bg-blue-300 ">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-l-lg">
                                        Nombre
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-r-lg">
                                        Opciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr class="bg-white">
                                    <th scope="row" class="px-6 py-4">
                                        {{ $role->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('role.edit', $role) }}"
                                        class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                        Editar</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>