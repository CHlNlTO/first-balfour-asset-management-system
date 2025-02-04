<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['color','disabled','form','formId','href','icon','iconSize','keyBindings','labelSrOnly','tag','target','tooltip','type','wire:click','wire:target','xOn:click','class','xBind:disabled','badge','badgeColor','badgeColor']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['color','disabled','form','formId','href','icon','iconSize','keyBindings','labelSrOnly','tag','target','tooltip','type','wire:click','wire:target','xOn:click','class','xBind:disabled','badge','badgeColor','badgeColor']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<?php if (isset($component)) { $__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.list.item','data' => ['color' => $color,'disabled' => $disabled,'form' => $form,'formId' => $formId,'href' => $href,'icon' => $icon,'iconSize' => $iconSize,'keyBindings' => $keyBindings,'labelSrOnly' => $labelSrOnly,'tag' => $tag,'target' => $target,'tooltip' => $tooltip,'type' => $type,'wire:click' => $wireClick,'wire:target' => $wireTarget,'xOn:click' => $xOnClick,'class' => $class,'xBind:disabled' => $xBindDisabled,'badge' => $badge,'badgeColor' => $badgeColor]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::dropdown.list.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($color),'disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($disabled),'form' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($form),'form-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formId),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($href),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'icon-size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconSize),'key-bindings' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($keyBindings),'label-sr-only' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($labelSrOnly),'tag' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tag),'target' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($target),'tooltip' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tooltip),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($type),'wire:click' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($wireClick),'wire:target' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($wireTarget),'x-on:click' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($xOnClick),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($class),'x-bind:disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($xBindDisabled),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($badge),'badgeColor' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($badgeColor),'badge-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($badgeColor)]); ?>

<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78)): ?>
<?php $attributes = $__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78; ?>
<?php unset($__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78)): ?>
<?php $component = $__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78; ?>
<?php unset($__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\storage\framework\views/9acc8bd1c7bfbc0566f6e7ce6a92f873.blade.php ENDPATH**/ ?>