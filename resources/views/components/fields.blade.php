@props(['class', 'fields'])

@if ($class ?? false)
    <div class="{{ $class }}">
@endif

    @foreach ($fields as $field)

        @if ($field === null)

            <div>{{-- Spacer --}}</div>

        @else

            @switch($field['type'] ?? null)

                @case('date')
                    <x-jal::date-picker :props="$field" />
                    @break

                @case('select')
                    <x-jal::select :props="$field" />
                    @break
                
                {{-- 
                @case('file')
                    <x-input.file :props="$field" />
                    @break
                --}}

                @case('checkbox')
                    <x-jal::toggle :props="$field" />
                    @break

                @case('toggle')
                    <x-jal::toggle :props="$field" />
                    @break

                @case('multiselect')
                    <x-jal::choices :props="$field" />
                    @break

                @default
                    <x-jal::input :props="$field" />

            @endswitch

        @endif

    @endforeach

@if ($class ?? false)
    </div>
@endif