<div class="max-w-full mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        @if (session()->has('success'))
            <div class="p-4 m-2 text-sm  text-green-800 bg-green-50 rounded-lg dark:bg-green-800 dark:text-green-200" role="alert">
                {{ session('success') }}
            </div>
        @elseif(session()->has('error'))
            <div class="p-4 m-2 text-sm  text-red-800 bg-red-50 rounded-lg dark:bg-red-800 dark:text-red-200" role="alert">
                {{ session('error') }}
            </div>
            <div class="p-4 m-2 text-sm rounded-lg bg-blue-50 dark:bg-gray-800 text-blue-800 dark:text-blue-400" role="alert">
                <div class="font-bold">
                    Connect Your Account!
                </div>
                <div>
                    Don't worry, your data will not be stored anywhere.
                </div>
            </div>
        @else
            <div class="p-4 m-2 text-sm rounded-lg bg-blue-50 dark:bg-gray-800 text-blue-800 dark:text-blue-400" role="alert">
                <div class="font-bold">
                    Connect Your Account!
                </div>
                <div>
                    Don't worry, your data will not be stored anywhere.
                </div>
            </div>
        @endif

    <div class="p-4">
        <form wire:submit.prevent="check_account">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <input wire:model.live.debounce.500ms="form.email" type="email"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Personal email" required />
                    @error('form.email')
                        <p class="m-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
                <div>
                    <input wire:model.live.debounce.500ms="form.key" type="text" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Password Or Generated Key" required />
                    @error('form.key')
                        <p class="m-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
                <div>
                    <input wire:model.live.debounce.500ms="form.host" type="text" id="host" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Host (smtp.example.com)" required />
                    @error('form.host')
                        <p class="m-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
                <div>
                    <input wire:model.live.debounce.500ms="form.port" type="number" id="port" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Port (587)" required />
                    @error('form.port')
                        <p class="m-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Check Connection</button>
        </form>
    </div>
</div>


