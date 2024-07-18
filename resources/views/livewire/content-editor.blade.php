<div class="max-w-full mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
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

        <form wire:submit.prevent="sendTestEmail" class="grid grid-cols-1 gap-y-4 sm:grid-cols-2">
            <div class="mb-4">
                <label for="fromName" class="block text-sm font-medium text-gray-700">From Name:</label>
                <input type="text" wire:model.live.debounce.500ms="fromName" id="fromName" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('fromName') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="fromEmail" class="block text-sm font-medium text-gray-700">From Email:</label>
                <input type="email" wire:model.live.debounce.500ms="fromEmail" id="fromEmail" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('fromEmail') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 mb-4">
                <label for="recipients" class="block text-sm font-medium text-gray-700">Recipients:</label>
                @foreach($recipients as $index => $recipient)
                    <div class="flex items-center mb-2">
                        <input type="email" wire:model.live.debounce.500ms="recipients.{{ $index }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <button type="button" wire:click="removeRecipient({{ $index }})" class="ml-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Remove</button>
                    </div>
                @endforeach
                <button type="button" wire:click="addRecipient" class="mt-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Add Recipient</button>
                @error('recipients') <span class="text-red-600">{{ $message }}</span> @enderror
                @error('recipients.*') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 mb-4">
                <label for="subject" class="block text-sm font-medium text-gray-700">Subject:</label>
                <input type="text" wire:model.live.debounce.500ms="subject" id="subject" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('subject') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Content:</label>
                <textarea wire:model.live.debounce.500ms="content" id="content" class="tinymce-editor mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="You can put Html Content"></textarea>
                @error('content') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 flex justify-end">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Send Test Email
                </button>
            </div>
        </form>
    </div>
</div>
