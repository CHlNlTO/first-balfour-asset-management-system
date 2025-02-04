<?php
    use Filament\Support\Enums\IconSize;
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'color' => 'gray',
    'icon',
    'size' => IconSize::Large,
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
    'color' => 'gray',
    'icon',
    'size' => IconSize::Large,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $icon,'attributes' => 
        $attributes
            ->class([
                'fi-no-notification-icon',
                match ($color) {
                    'gray' => 'text-gray-400',
                    default => 'fi-color-custom text-custom-400',
                },
                is_string($color) ? 'fi-color-' . $color : null,
                match ($size) {
                    IconSize::Small, 'sm' => 'h-4 w-4',
                    IconSize::Medium, 'md' => 'h-5 w-5',
                    IconSize::Large, 'lg' => 'h-6 w-6',
                    default => $size,
                },
            ])
            ->style([
                \Filament\Support\get_color_css_variables(
                    $color,
                    shades: [400],
                    alias: 'notifications::notification.icon',
                ),
            ])
    ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
        $attributes
            ->class([
                'fi-no-notification-icon',
                match ($color) {
                    'gray' => 'text-gray-400',
                    default => 'fi-color-custom text-custom-400',
                },
                is_string($color) ? 'fi-color-' . $color : null,
                match ($size) {
                    IconSize::Small, 'sm' => 'h-4 w-4',
                    IconSize::Medium, 'md' => 'h-5 w-5',
                    IconSize::Large, 'lg' => 'h-6 w-6',
                    default => $size,
                },
            ])
            ->style([
                \Filament\Support\get_color_css_variables(
                    $color,
                    shades: [400],
                    alias: 'notifications::notification.icon',
                ),
            ])
    )]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\notifications\src\/../resources/views/components/icon.blade.php ENDPATH**/ ?>