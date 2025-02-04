<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['color','icon','iconSize','labelSrOnly','size','tooltip','class','iconPosition','labeledFrom','outlined','iconPosition','labeledFrom'])
<x-filament::button :color="$color" :icon="$icon" :icon-size="$iconSize" :label-sr-only="$labelSrOnly" :size="$size" :tooltip="$tooltip" :class="$class" :iconPosition="$iconPosition" :labeledFrom="$labeledFrom" :outlined="$outlined" :icon-position="$iconPosition" :labeled-from="$labeledFrom" >

{{ $slot ?? "" }}
</x-filament::button>