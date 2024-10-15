<!-- resources/views/components/button.blade.php -->
@props(['type' => 'button', 'class' => '', 'href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition']) . ' ' . $class }}">
    {{ $slot }}
</a>
