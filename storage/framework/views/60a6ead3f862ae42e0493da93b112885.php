<?php
    use Filament\Support\Enums\IconPosition;
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'active' => false,
    'alpineActive' => null,
    'badge' => null,
    'badgeColor' => null,
    'badgeTooltip' => null,
    'badgeIcon' => null,
    'badgeIconPosition' => IconPosition::Before,
    'href' => null,
    'icon' => null,
    'iconColor' => 'gray',
    'iconPosition' => IconPosition::Before,
    'spaMode' => null,
    'tag' => 'button',
    'target' => null,
    'type' => 'button',
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
    'active' => false,
    'alpineActive' => null,
    'badge' => null,
    'badgeColor' => null,
    'badgeTooltip' => null,
    'badgeIcon' => null,
    'badgeIconPosition' => IconPosition::Before,
    'href' => null,
    'icon' => null,
    'iconColor' => 'gray',
    'iconPosition' => IconPosition::Before,
    'spaMode' => null,
    'tag' => 'button',
    'target' => null,
    'type' => 'button',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    if (! $iconPosition instanceof IconPosition) {
        $iconPosition = filled($iconPosition) ? (IconPosition::tryFrom($iconPosition) ?? $iconPosition) : null;
    }

    $hasAlpineActiveClasses = filled($alpineActive);

    $inactiveItemClasses = 'hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-white/5 dark:focus-visible:bg-white/5';

    // @deprecated `fi-tabs-item-active` has been replaced by `fi-active`.
    $activeItemClasses = 'fi-active fi-tabs-item-active bg-gray-50 dark:bg-white/5';

    $inactiveLabelClasses = 'text-gray-500 group-hover:text-gray-700 group-focus-visible:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200 dark:group-focus-visible:text-gray-200';

    $activeLabelClasses = 'text-primary-600 dark:text-primary-400';

    $iconClasses = 'fi-tabs-item-icon h-5 w-5 shrink-0 transition duration-75';

    $inactiveIconClasses = 'text-gray-400 dark:text-gray-500';

    $activeIconClasses = 'text-primary-600 dark:text-primary-400';
?>

<<?php echo e($tag); ?>

    <?php if($tag === 'button'): ?>
        type="<?php echo e($type); ?>"
    <?php elseif($tag === 'a'): ?>
        <?php echo e(\Filament\Support\generate_href_html($href, $target === '_blank', $spaMode)); ?>

    <?php endif; ?>
    <?php if($hasAlpineActiveClasses): ?>
        x-bind:class="{
            <?php echo \Illuminate\Support\Js::from($inactiveItemClasses)->toHtml() ?>:  ! (<?php echo e($alpineActive); ?>) ,
            <?php echo \Illuminate\Support\Js::from($activeItemClasses)->toHtml() ?>: <?php echo e($alpineActive); ?>,
        }"
    <?php endif; ?>
    <?php echo e($attributes
            ->merge([
                'aria-selected' => $active,
                'role' => 'tab',
            ])
            ->class([
                'fi-tabs-item group flex items-center justify-center gap-x-2 whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium outline-none transition duration-75',
                $inactiveItemClasses => (! $hasAlpineActiveClasses) && (! $active),
                $activeItemClasses => (! $hasAlpineActiveClasses) && $active,
            ])); ?>

>
    <!--[if BLOCK]><![endif]--><?php if($icon && $iconPosition === IconPosition::Before): ?>
        <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $icon,'xBind:class' => $hasAlpineActiveClasses ? '{ ' . \Illuminate\Support\Js::from($inactiveIconClasses) . ': ! (' . $alpineActive . '), ' . \Illuminate\Support\Js::from($activeIconClasses) . ': ' . $alpineActive . ' }' : null,'class' => \Illuminate\Support\Arr::toCssClasses([
                $iconClasses,
                $inactiveIconClasses => (! $hasAlpineActiveClasses) && (! $active),
                $activeIconClasses => (! $hasAlpineActiveClasses) && $active,
            ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'x-bind:class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasAlpineActiveClasses ? '{ ' . \Illuminate\Support\Js::from($inactiveIconClasses) . ': ! (' . $alpineActive . '), ' . \Illuminate\Support\Js::from($activeIconClasses) . ': ' . $alpineActive . ' }' : null),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                $iconClasses,
                $inactiveIconClasses => (! $hasAlpineActiveClasses) && (! $active),
                $activeIconClasses => (! $hasAlpineActiveClasses) && $active,
            ]))]); ?>
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
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <span
        <?php if($hasAlpineActiveClasses): ?>
            x-bind:class="{
                <?php echo \Illuminate\Support\Js::from($inactiveLabelClasses)->toHtml() ?>:  ! (<?php echo e($alpineActive); ?>) ,
                <?php echo \Illuminate\Support\Js::from($activeLabelClasses)->toHtml() ?>: <?php echo e($alpineActive); ?>,
            }"
        <?php endif; ?>
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'fi-tabs-item-label transition duration-75',
            $inactiveLabelClasses => (! $hasAlpineActiveClasses) && (! $active),
            $activeLabelClasses => (! $hasAlpineActiveClasses) && $active,
        ]); ?>"
    >
        <?php echo e($slot); ?>

    </span>

    <!--[if BLOCK]><![endif]--><?php if($icon && $iconPosition === IconPosition::After): ?>
        <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $icon,'xBind:class' => $hasAlpineActiveClasses ? '{ ' . \Illuminate\Support\Js::from($inactiveIconClasses) . ': ! (' . $alpineActive . '), ' . \Illuminate\Support\Js::from($activeIconClasses) . ': ' . $alpineActive . ' }' : null,'class' => \Illuminate\Support\Arr::toCssClasses([
                $iconClasses,
                $inactiveIconClasses => (! $hasAlpineActiveClasses) && (! $active),
                $activeIconClasses => (! $hasAlpineActiveClasses) && $active,
            ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'x-bind:class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasAlpineActiveClasses ? '{ ' . \Illuminate\Support\Js::from($inactiveIconClasses) . ': ! (' . $alpineActive . '), ' . \Illuminate\Support\Js::from($activeIconClasses) . ': ' . $alpineActive . ' }' : null),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                $iconClasses,
                $inactiveIconClasses => (! $hasAlpineActiveClasses) && (! $active),
                $activeIconClasses => (! $hasAlpineActiveClasses) && $active,
            ]))]); ?>
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
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if(filled($badge)): ?>
        <?php if (isset($component)) { $__componentOriginal986dce9114ddce94a270ab00ce6c273d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal986dce9114ddce94a270ab00ce6c273d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.badge','data' => ['color' => $badgeColor,'icon' => $badgeIcon,'iconPosition' => $badgeIconPosition,'size' => 'sm','tooltip' => $badgeTooltip,'class' => 'w-max']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($badgeColor),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($badgeIcon),'icon-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($badgeIconPosition),'size' => 'sm','tooltip' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($badgeTooltip),'class' => 'w-max']); ?>
            <?php echo e($badge); ?>

         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $attributes = $__attributesOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $component = $__componentOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__componentOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</<?php echo e($tag); ?>>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\support\src\/../resources/views/components/tabs/item.blade.php ENDPATH**/ ?>