<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Edit User') }}
            </h2>

            <p class="text-xl px-3">"{{ $user->name }}"</p>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="border-2 border-blue-600 rounded-lg">
                        <div class="p-5">

                            <div class="py-3">
                                <h2 class="text-xl font-bold">Rol del usuario</h2>
                            </div>

                            <div class="py-2" >
                                @if($user->getRoleNames()->first() ==! null)
                                    <div class="py-4">
                                        <form action="{{route('user.deleterole', $user)}}" method="post">
                                        @csrf
                                        @method('PUT')
                                            <input type="hidden" name="role" value="{{$user->getRoleNames()->first()}}">
                                            <button type="submit"
                                                class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                                {{ $user->getRoleNames()->first() }}</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <div class="py-4">
                                <form action="{{route('user.setrole', $user)}}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <label for="role"
                                        class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Seleccione
                                        el rol</label>
                                    <div class="flex">
                                        <select name="role" id="role"
                                            class="block px-4 py-3 text-base text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="px-4 py-1">
                                            <button type="submit"
                                                class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Asignar
                                                Rol
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
