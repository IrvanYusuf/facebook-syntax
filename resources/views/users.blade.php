<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="px-4 md:px-10 py-4 md:py-7">
            <div class="flex items-center justify-between">
                <p tabindex="0"
                    class="focus:outline-none text-base sm:text-lg md:text-xl lg:text-2xl font-bold leading-normal text-gray-800">
                    Users</p>
            </div>
        </div>
        <div class="bg-white py-4 md:py-7 px-4 md:px-8 xl:px-10">
            <div class="mt-7 overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="px-6 py-3 text-xs font-semibold uppercase text-gray-500">
                                Name
                            </th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase text-gray-500">
                                Email
                            </th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase text-gray-500">
                                #
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">

                                        {{-- Send Email --}}
                                        <form action="{{ route('transaction.sendEmail', $user) }}" method="POST">
                                            @csrf

                                            <button type="submit" title="Send Email"
                                                class="inline-flex items-center justify-center rounded-md bg-emerald-50 p-2 text-emerald-700 hover:bg-emerald-100 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect width="20" height="16" x="2" y="4" rx="2" />
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                                </svg>
                                            </button>
                                        </form>

                                        {{-- View --}}
                                        <a href="#" title="View User"
                                            class="inline-flex items-center justify-center rounded-md bg-blue-50 p-2 text-blue-700 hover:bg-blue-100 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path
                                                    d="M2.06 12.35a1 1 0 0 1 0-.7 10 10 0 0 1 19.88 0 1 1 0 0 1 0 .7 10 10 0 0 1-19.88 0" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="#" title="Edit User"
                                            class="inline-flex items-center justify-center rounded-md bg-amber-50 p-2 text-amber-700 hover:bg-amber-100 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z" />
                                            </svg>
                                        </a>

                                        {{-- Delete --}}
                                        <form method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete {{ $user->name }}?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete User"
                                                class="inline-flex items-center justify-center rounded-md bg-red-50 p-2 text-red-700 hover:bg-red-100 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M3 6h18" />
                                                    <path d="M8 6V4h8v2" />
                                                    <path d="m19 6-1 14H6L5 6" />
                                                    <path d="M10 11v5M14 11v5" />
                                                </svg>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
