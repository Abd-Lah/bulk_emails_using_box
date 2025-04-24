<div class="max-w-full mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <button wire:click="back" type="button" class="m-1.5 w-full flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
        <svg class="w-5 h-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
        </svg>
    </button>
    <div class="p-6">
        @if (session()->has('success'))
            <div class="p-4 mb-4 text-sm text-green-800 bg-green-50 rounded-lg dark:bg-green-800 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-4 mb-4 text-sm text-red-800 bg-red-50 rounded-lg dark:bg-red-800 dark:text-red-200">
                {{ session('error') }}
            </div>
        @endif
        <form wire:submit.prevent="sendEmail" class="grid grid-cols-1 gap-y-4 sm:grid-cols-2">
            <div class="mb-4">
                <label for="fromName" class="block text-sm font-medium text-gray-700">From Name :</label>
                <input type="text" wire:model.live.blur="fromName" id="fromName" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('fromName') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="fromEmail" class="block text-sm font-medium text-gray-700">From Email:</label>
                <input type="email" wire:model.live.blur="fromEmail" id="fromEmail" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('fromEmail') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 mb-4">
                <label for="recipients" class="block text-sm font-medium text-gray-700">Recipients:</label>
                @foreach($recipients as $index => $recipient)
                    <div class="flex items-center mb-2">
                        <input type="email" wire:model.live.blur="recipients.{{ $index }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <button type="button" wire:click="removeRecipient({{ $index }})" class="ml-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Remove</button>
                    </div>
                @endforeach
                <button type="button" wire:click="addRecipient" class="mt-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Add Recipient</button>
                @error('recipients') <span class="text-red-600">{{ $message }}</span> @enderror
                @error('recipients.*') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 mb-4">
                <label for="subject" class="block text-sm font-medium text-gray-700">Subject:</label>
                <input type="text" wire:model.live.blur="subject" id="subject" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('subject') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Content:</label>
                <textarea wire:model.live.blur="content" id="content" class="tinymce-editor mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="You can put Html Content"></textarea>
                @error('content') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 flex justify-end">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Send
                </button>
            </div>
        </form>
    </div>
    <div wire:loading wire:target="sendEmail" >
        <div class="absolute inset-0 flex items-center justify-center bg-gray-200 bg-opacity-75 z-50" >
            <svg aria-hidden="true" class="w-16 h-16 text-gray-400 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            <span class="sr-only">Checking...</span>
        </div>
    </div>
</div>
