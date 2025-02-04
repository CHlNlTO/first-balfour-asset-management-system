<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['color','icon','iconSize','labelSrOnly','size','tooltip','class'])
<x-filament::icon-button :color="$color" :icon="$icon" :icon-size="$iconSize" :label-sr-only="$labelSrOnly" :size="$size" :tooltip="$tooltip" :class="$class" >

{{ $slot ?? "" }}
</x-filament::icon-button>