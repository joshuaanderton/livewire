<{{ $tag }} {{ $attributes->merge([
  'href' => $href,
  'type' => $type,
  'class' => join(' ', [
    'truncate block px-4 py-2 text-sm text-gray-700',
    'transition-colors flex items-center',
    $href ? 'hover:bg-gray-100 cursor-pointer' : '',
  ])
]) }}>
  @if ($icon)
    <x-jal::icon library="fontawesome" :name="$icon" :type="$iconType" class="fa-fw mr-2" />
  @endif
  <span>{{ $text }}{{ $slot }}</span>
</{{ $tag }}>