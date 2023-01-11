<div
  class="{{ $wrapperClass }}"
  x-data="{
    color: $wire.get('{{ $model = $attributes->wire('model')->value() }}'),
    init() {
      $watch('color', value => $wire.set('{{ $model }}', value))
    }
  }"
>
  <x-jal::input x-model="color" :label="$label">
    <x-slot name="prepend">
      <div class="relative w-8 h-full" :style="{ backgroundColor: color }">
        <input type="color" x-model="color" class="cursor-pointer absolute inset-0 opacity-0" />
      </div>
    </x-slot>
  </x-jal::input>
</div>