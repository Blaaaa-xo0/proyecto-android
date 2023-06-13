<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Edit Role') }}
            </h2>

            <p class="text-xl px-3">"{{ $role->name }}"</p>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="border-2 border-blue-600 rounded-lg">
                            <div class="p-5">
                                <div class="py-3">
                                    <h2 class="text-xl font-bold">Permisos del rol</h2>
                                </div>

                                <div class="px-3">
                                    <form action="{{ route('role.update', $role) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        @foreach ($permissions as $permission)
                                            <label class="block">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                    {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                                {{ $permission->name }}
                                            </label>
                                        @endforeach

                                        <div class="px-4 py-6">
                                            <button type="submit"
                                                class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                                Actualizar Permisos
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
