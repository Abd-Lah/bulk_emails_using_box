<div class="relative w-max-full mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <!--[if BLOCK]><![endif]--><?php if(session()->has('success')): ?>
        <div class="p-4 m-2 text-sm text-green-800 bg-green-50 rounded-lg dark:bg-green-800 dark:text-green-200" role="alert">
            <?php echo e(session('success')); ?>

        </div>
    <?php elseif(session()->has('error')): ?>
        <div class="p-4 m-2 text-sm text-red-800 bg-red-50 rounded-lg dark:bg-red-800 dark:text-red-200" role="alert">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="p-4 relative">
        <form wire:submit.prevent="check_account">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <input wire:model.live.blur="form.email" type="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Personal email" required />
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="m-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium"><?php echo e($message); ?></span></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <input wire:model.live.blur="form.key" type="text" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Password Or Generated Key" required />
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="m-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium"><?php echo e($message); ?></span></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <input wire:model.live.blur="form.host" type="text" id="host" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Host (smtp.example.com)" required />
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="m-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium"><?php echo e($message); ?></span></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <input wire:model.live.blur="form.port" type="number" id="port" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Port (587)" required />
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="m-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium"><?php echo e($message); ?></span></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Check Connection</button>
        </form>

    </div>
    <div class="p-4 m-2 text-sm rounded-lg bg-blue-50 dark:bg-gray-800 text-blue-800 dark:text-blue-400" role="alert">
        <div class="font-bold">
            Connect Your Account!
        </div>
        <div>
            Don't worry, your data will not be stored anywhere. If you don't trust this online version, you can run the application locally from our GitHub repository.
        </div>
        <div class="mt-2">
            <a href="https://github.com/your-repo-url" target="_blank" class="text-blue-500 hover:underline">GitHub Repository</a>
        </div>
    </div>
    <div wire:loading wire:target="check_account" >
        <div class="absolute inset-0 flex items-center justify-center bg-gray-200 bg-opacity-75 z-50" >
            <svg aria-hidden="true" class="w-16 h-16 text-gray-400 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            <span class="sr-only">Checking...</span>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/resources/views/livewire/email-form.blade.php ENDPATH**/ ?>