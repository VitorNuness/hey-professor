@props([
    'action',
    'method' => 'POST'
])

<form action="{{ $action }}" method="post" {{ $attributes }}>
    @csrf
    @method($method)

    {{ $slot }}

</form>
