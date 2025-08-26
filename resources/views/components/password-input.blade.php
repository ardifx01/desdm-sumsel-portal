@props(['disabled' => false])

<div x-data="{ show: false }" class="relative">
    <input {{ $disabled ? 'disabled' : '' }}
           :type="show ? 'text' : 'password'"
           {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full pr-10']) !!}>

    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
        <button type="button" @click="show = !show" class="text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg x-show="!show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.577 3.01 9.964 7.822.09.304.09.638 0 .942-1.387 4.81-5.325 7.82-9.964 7.82-4.638 0-8.577-3.01-9.964-7.82a1.012 1.012 0 010-.639z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <svg x-show="show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a1.05 1.05 0 01-1.066 1.154" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 12a5.25 5.25 0 10-10.5 0 5.25 5.25 0 0010.5 0z" />
            </svg>
        </button>
    </div>
</div>