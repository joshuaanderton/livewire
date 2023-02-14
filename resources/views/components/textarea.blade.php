<jal::input-group>

    <textarea {{ $attributes->merge([
      'id' => $id,
      'name' => $name,
      'autocomplete' => $autocomplete,
    ]) }}>{{ $value }}{{ $slot }}</textarea>

</jal::input-group>