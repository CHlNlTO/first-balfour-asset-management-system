<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'notification',
]));

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

foreach (array_filter(([
    'notification',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div
    x-data="notificationComponent({ notification: <?php echo \Illuminate\Support\Js::from($notification)->toHtml() ?> })"
    <?php echo e($attributes
            ->merge([
                'wire:key' => "{$this->getId()}.notifications.{$notification->getId()}",
                'x-on:close-notification.window' => "if (\$event.detail.id == '{$notification->getId()}') close()",
            ], escape: false)
            ->class(['pointer-events-auto invisible'])); ?>

>
    <?php echo e($slot); ?>

</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\notifications\src\/../resources/views/components/notification.blade.php ENDPATH**/ ?>