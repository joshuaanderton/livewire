<jal::input-group>

    <input {{ $attributes->merge([
      'id' => $id,
      'type' => $type,
      'name' => $name,
      'autocomplete' => $autocomplete,
    ]) }} />

</jal::input-group>