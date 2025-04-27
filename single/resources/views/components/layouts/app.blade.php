<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Page Title' }}</title>
    @vite('resources/css/app.css') <!-- Assuming this loads Tailwind CSS -->
    @vite(['resources/js/app.js'])
{{--    <script src="https://cdn.tiny.cloud/1/ntw83k184syxh97ssl0bm0mh8bd35t93dtfokka19fnhq1nj/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>--}}
{{--    <script>--}}
{{--        tinymce.init({--}}
{{--            selector: 'textarea.tinymce-editor',--}}
{{--            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking table template help',--}}
{{--            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',--}}
{{--            apiKey: 'ntw83k184syxh97ssl0bm0mh8bd35t93dtfokka19fnhq1nj' // Replace with your actual TinyMCE API key--}}
{{--        });--}}
{{--    </script>--}}

    @livewireStyles

</head>
<body class="bg-gray-100 dark:bg-gray-800">
<!-- Livewire Component: Sidebar -->
<div x-data="{ isOpen: true }">
    <!-- Sidebar -->
    <div x-show="isOpen" class="fixed top-0 left-0 z-50 h-screen w-64 bg-white dark:bg-gray-800 shadow-lg">
        <div class="p-4 flex justify-between items-center">
            <h5 class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">Menu</h5>
        </div>
        <div class="py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M18 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3.546l3.2 3.659a1 1 0 0 0 1.506 0L13.454 14H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-8 10H5a1 1 0 0 1 0-2h5a1 1 0 1 1 0 2Zm5-4H5a1 1 0 0 1 0-2h10a1 1 0 1 1 0 2Z"/>
                        </svg>
                        <span class="ms-3">Bulk email</span>
                    </a>
                </li>
                <!-- Other sidebar menu items -->
            </ul>
        </div>
    </div>

    <!-- Content -->
    <div class="ml-0 lg:ml-64 transition-all duration-300">
        <div>
            <div class="container mx-auto px-4 py-4">
               {{$slot}}
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
