<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['color','disabled','form','formId','href','icon','iconSize','keyBindings','labelSrOnly','tag','target','tooltip','type','wire:click','wire:target','xOn:click','class','xBind:disabled','badge','badgeColor','badgeColor'])
<x-filament::dropdown.list.item :color="$color" :disabled="$disabled" :form="$form" :form-id="$formId" :href="$href" :icon="$icon" :icon-size="$iconSize" :key-bindings="$keyBindings" :label-sr-only="$labelSrOnly" :tag="$tag" :target="$target" :tooltip="$tooltip" :type="$type" :wire:click="$wireClick" :wire:target="$wireTarget" :x-on:click="$xOnClick" :class="$class" :x-bind:disabled="$xBindDisabled" :badge="$badge" :badgeColor="$badgeColor" :badge-color="$badgeColor" >

{{ $slot ?? "" }}
</x-filament::dropdown.list.item>