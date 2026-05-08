@props(['messages'])

@if ($messages)
    <div class="text-danger text-xs mt-1">
        @foreach ((array) $messages as $message)
            {{ $message }}
        @endforeach
    </div>
@endif
