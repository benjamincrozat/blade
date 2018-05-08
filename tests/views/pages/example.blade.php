@component('layout')
    Hello {{ $name }}! I'm {{ $god }}!

    @component('components.example')
        @lorem
    @endcomponent
@endcomponent
