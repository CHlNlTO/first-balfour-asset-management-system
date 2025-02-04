<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'active' => false,
    'ariaLabel' => null,
    'disabled' => false,
    'icon' => null,
    'iconAlias' => null,
    'label' => null,
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
    'ariaLabel' => null,
    'disabled' => false,
    'icon' => null,
    'iconAlias' => null,
    'label' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<li
    <?php echo e($attributes->class([
            'fi-pagination-item group/item border-x-[0.5px] border-gray-200 first:border-s-0 last:border-e-0 dark:border-white/10',
            'fi-disabled' => $disabled,
            'fi-active' => $active,
        ])); ?>

>
    <button
        aria-label="<?php echo e($ariaLabel); ?>"
        <?php if($disabled): echo 'disabled'; endif; ?>
        type="button"
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'fi-pagination-item-button group/button relative flex overflow-hidden p-2 outline-none transition duration-75 group-first/item:rounded-s-lg group-last/item:rounded-e-lg',
            'hover:bg-gray-50 focus-visible:z-10 focus-visible:ring-2 focus-visible:ring-primary-600 dark:hover:bg-white/5 dark:focus-visible:ring-primary-500' => ! $disabled,
            'bg-gray-50 dark:bg-white/5' => $active,
        ]); ?>"
    >
        <!--[if BLOCK]><![endif]--><?php if(filled($icon)): ?>
            <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['alias' => $iconAlias,'icon' => $icon,'class' => 'fi-pagination-item-icon h-5 w-5 text-gray-400 transition duration-75 group-hover/button:text-gray-500 dark:text-gray-500 dark:group-hover/button:text-gray-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alias' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconAlias),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => 'fi-pagination-item-icon h-5 w-5 text-gray-400 transition duration-75 group-hover/button:text-gray-500 dark:text-gray-500 dark:group-hover/button:text-gray-400']); ?>
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

        <!--[if BLOCK]><![endif]--><?php if(filled($label)): ?>
            <span
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'fi-pagination-item-label px-1.5 text-sm font-semibold',
                    'text-gray-700 dark:text-gray-200' => ! ($disabled || $active),
                    'text-gray-500 dark:text-gray-400' => $disabled,
                    'text-primary-600 dark:text-primary-400' => $active,
                ]); ?>"
            >
                <?php echo e($label ?? '...'); ?>

            </span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </button>
</li>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\support\src\/../resources/views/components/pagination/item.blade.php ENDPATH**/ ?>