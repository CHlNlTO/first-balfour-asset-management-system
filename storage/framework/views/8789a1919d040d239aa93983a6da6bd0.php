<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'availableHeight' => null,
    'availableWidth' => null,
    'flip' => true,
    'maxHeight' => null,
    'offset' => 8,
    'placement' => null,
    'shift' => false,
    'size' => false,
    'sizePadding' => 16,
    'teleport' => false,
    'trigger' => null,
    'width' => null,
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
    'availableHeight' => null,
    'availableWidth' => null,
    'flip' => true,
    'maxHeight' => null,
    'offset' => 8,
    'placement' => null,
    'shift' => false,
    'size' => false,
    'sizePadding' => 16,
    'teleport' => false,
    'trigger' => null,
    'width' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    use Filament\Support\Enums\MaxWidth;

    $sizeConfig = collect([
        'availableHeight' => $availableHeight,
        'availableWidth' => $availableWidth,
        'padding' => $sizePadding,
    ])->filter()->toJson();
?>

<div
    x-data="{
        toggle: function (event) {
            $refs.panel.toggle(event)
        },

        open: function (event) {
            $refs.panel.open(event)
        },

        close: function (event) {
            $refs.panel.close(event)
        },
    }"
    <?php echo e($attributes->class(['fi-dropdown'])); ?>

>
    <div
        x-on:click="toggle"
        <?php echo e($trigger->attributes->class(['fi-dropdown-trigger flex cursor-pointer'])); ?>

    >
        <?php echo e($trigger); ?>

    </div>

    <!--[if BLOCK]><![endif]--><?php if(! \Filament\Support\is_slot_empty($slot)): ?>
        <div
            x-cloak
            x-float<?php echo e($placement ? ".placement.{$placement}" : ''); ?><?php echo e($size ? '.size' : ''); ?><?php echo e($flip ? '.flip' : ''); ?><?php echo e($shift ? '.shift' : ''); ?><?php echo e($teleport ? '.teleport' : ''); ?><?php echo e($offset ? '.offset' : ''); ?>="{ offset: <?php echo e($offset); ?>, <?php echo e($size ? ('size: ' . $sizeConfig) : ''); ?> }"
            x-ref="panel"
            x-transition:enter-start="opacity-0"
            x-transition:leave-end="opacity-0"
            <?php if($attributes->has('wire:key')): ?>
                wire:ignore.self
                wire:key="<?php echo e($attributes->get('wire:key')); ?>.panel"
            <?php endif; ?>
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'fi-dropdown-panel absolute z-10 w-screen divide-y divide-gray-100 rounded-lg bg-white shadow-lg ring-1 ring-gray-950/5 transition dark:divide-white/5 dark:bg-gray-900 dark:ring-white/10',
                match ($width) {
                    // These max width classes need to be `!important` otherwise they will be usurped by the Floating UI "size" middleware.
                    MaxWidth::ExtraSmall, 'xs' => '!max-w-xs',
                    MaxWidth::Small, 'sm' => '!max-w-sm',
                    MaxWidth::Medium, 'md' => '!max-w-md',
                    MaxWidth::Large, 'lg' => '!max-w-lg',
                    MaxWidth::ExtraLarge, 'xl' => '!max-w-xl',
                    MaxWidth::TwoExtraLarge, '2xl' => '!max-w-2xl',
                    MaxWidth::ThreeExtraLarge, '3xl' => '!max-w-3xl',
                    MaxWidth::FourExtraLarge, '4xl' => '!max-w-4xl',
                    MaxWidth::FiveExtraLarge, '5xl' => '!max-w-5xl',
                    MaxWidth::SixExtraLarge, '6xl' => '!max-w-6xl',
                    MaxWidth::SevenExtraLarge, '7xl' => '!max-w-7xl',
                    null => '!max-w-[14rem]',
                    default => $width,
                },
                'overflow-y-auto' => $maxHeight || $size,
            ]); ?>"
            style="<?php echo \Illuminate\Support\Arr::toCssStyles([
                "max-height: {$maxHeight}" => $maxHeight,
            ]) ?>"
        >
            <?php echo e($slot); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\support\src\/../resources/views/components/dropdown/index.blade.php ENDPATH**/ ?>