<x-app-layout>
    <div x-data="{ open: {{ $errors->any() ? 'true' : 'false' }} }" @keydown.escape.window="open = false" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="px-4 md:px-10 py-4 md:py-7">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-bold text-gray-800">
                    Branches
                </h1>

                <button type="button" @click="open = true"
                    class="rounded-lg bg-emerald-700 px-4 py-2.5
                           text-sm font-semibold text-white hover:bg-emerald-800">
                    + Add Branch
                </button>
            </div>
        </div>

        {{-- Branch Table --}}
        <div class="rounded-xl bg-white px-4 py-6 shadow-sm md:px-8">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="px-6 py-3 text-xs font-semibold uppercase text-gray-500">
                                Name
                            </th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase text-gray-500">
                                Address
                            </th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase text-gray-500">
                                Phone
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($branches as $branch)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $branch->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $branch->address }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $branch->phone }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-sm text-gray-500">
                                    No branches found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Add Branch Modal --}}
        <div x-show="open" x-cloak x-transition.opacity class="fixed inset-0 z-50 overflow-y-auto">
            {{-- Overlay --}}
            <div class="fixed inset-0 bg-black/50" @click="open = false"></div>

            {{-- Dialog --}}
            <div class="relative flex min-h-full items-center justify-center p-4">
                <div x-show="open" x-transition @click.stop
                    class="relative w-full max-w-lg rounded-xl bg-white p-6 shadow-xl">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">
                                Add New Branch
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Enter your branch information.
                            </p>
                        </div>

                        <button type="button" @click="open = false" class="text-gray-500 hover:text-gray-800">
                            ✕
                        </button>
                    </div>

                    <form action="{{ route('branch.store') }}" method="POST">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label for="name" class="mb-1 block text-sm font-medium text-gray-700">
                                    Branch Name
                                </label>
                                <input id="name" name="name" type="text"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600"
                                    placeholder="Enter branch name">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="address" class="mb-1 block text-sm font-medium text-gray-700">
                                    Address
                                </label>
                                <textarea id="address" name="address" rows="3"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600"
                                    placeholder="Enter branch address"></textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="mb-1 block text-sm font-medium text-gray-700">
                                    Phone
                                </label>
                                <input id="phone" name="phone" type="tel"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-600 focus:ring-emerald-600"
                                    placeholder="Enter phone number">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="open = false"
                                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancel
                            </button>

                            <button type="submit"
                                class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
                                Save Branch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-app-layout>
