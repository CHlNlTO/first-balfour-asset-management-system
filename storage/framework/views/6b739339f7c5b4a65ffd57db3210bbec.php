<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'actions' => [],
    'badge' => null,
    'badgeColor' => null,
    'button' => false,
    'color' => null,
    'dropdownMaxHeight' => null,
    'dropdownOffset' => null,
    'dropdownPlacement' => null,
    'dropdownWidth' => null,
    'dynamicComponent' => null,
    'group' => null,
    'icon' => null,
    'iconSize' => null,
    'iconButton' => false,
    'label' => null,
    'link' => false,
    'size' => null,
    'tooltip' => null,
    'view' => null,
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
    'actions' => [],
    'badge' => null,
    'badgeColor' => null,
    'button' => false,
    'color' => null,
    'dropdownMaxHeight' => null,
    'dropdownOffset' => null,
    'dropdownPlacement' => null,
    'dropdownWidth' => null,
    'dynamicComponent' => null,
    'group' => null,
    'icon' => null,
    'iconSize' => null,
    'iconButton' => false,
    'label' => null,
    'link' => false,
    'size' => null,
    'tooltip' => null,
    'view' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<!--[if BLOCK]><![endif]--><?php if(! ($dynamicComponent && $group)): ?>
    <?php
        $group = \Filament\Actions\ActionGroup::make($actions)
            ->badgeColor($badgeColor)
            ->color($color)
            ->dropdownMaxHeight($dropdownMaxHeight)
            ->dropdownOffset($dropdownOffset)
            ->dropdownPlacement($dropdownPlacement)
            ->dropdownWidth($dropdownWidth)
            ->icon($icon)
            ->iconSize($iconSize)
            ->label($label)
            ->size($size)
            ->tooltip($tooltip)
            ->view($view);

        $badge === true
            ? $group->badge()
            : $group->badge($badge);

        if ($button) {
            $group
                ->button()
                ->iconPosition($attributes->get('iconPosition') ?? $attributes->get('icon-position'))
                ->outlined($attributes->get('outlined') ?? false);
        }

        if ($iconButton) {
            $group->iconButton();
        }

        if ($link) {
            $group->link();
        }
    ?>

    <?php echo e($group); ?>

<?php elseif(! $group->hasDropdown()): ?>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $group->getActions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!--[if BLOCK]><![endif]--><?php if($action->isVisible()): ?>
            <?php echo e($action); ?>

        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
<?php else: ?>
    <?php
        $actionLists = [];
        $singleActions = [];

        foreach ($group->getActions() as $action) {
            if ($action->isHidden()) {
                continue;
            }

            if ($action instanceof \Filament\Actions\ActionGroup && (! $action->hasDropdown())) {
                if (count($singleActions)) {
                    $actionLists[] = $singleActions;
                    $singleActions = [];
                }

                $actionLists[] = array_filter(
                    $action->getActions(),
                    fn ($action): bool => $action->isVisible(),
                );
            } else {
                $singleActions[] = $action;
            }
        }

        if (count($singleActions)) {
            $actionLists[] = $singleActions;
        }
    ?>

    <?php if (isset($component)) { $__componentOriginal22ab0dbc2c6619d5954111bba06f01db = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal22ab0dbc2c6619d5954111bba06f01db = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.index','data' => ['maxHeight' => $group->getDropdownMaxHeight(),'offset' => $group->getDropdownOffset(),'placement' => $group->getDropdownPlacement() ?? 'bottom-start','width' => $group->getDropdownWidth(),'teleport' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['max-height' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->getDropdownMaxHeight()),'offset' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->getDropdownOffset()),'placement' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->getDropdownPlacement() ?? 'bottom-start'),'width' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->getDropdownWidth()),'teleport' => true]); ?>
         <?php $__env->slot('trigger', null, []); ?> 
            <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $dynamicComponent] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => $group->getColor(),'icon' => $group->getIcon(),'icon-size' => $group->getIconSize(),'label-sr-only' => $group->isLabelHidden(),'size' => $group->getSize(),'tooltip' => $group->getTooltip(),'attributes' => \Filament\Support\prepare_inherited_attributes($attributes)->merge($group->getExtraAttributes(), escape: false)]); ?>
                <?php echo e($slot); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
         <?php $__env->endSlot(); ?>

        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $actionLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginal66687bf0670b9e16f61e667468dc8983 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal66687bf0670b9e16f61e667468dc8983 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.list.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::dropdown.list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($action); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal66687bf0670b9e16f61e667468dc8983)): ?>
<?php $attributes = $__attributesOriginal66687bf0670b9e16f61e667468dc8983; ?>
<?php unset($__attributesOriginal66687bf0670b9e16f61e667468dc8983); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal66687bf0670b9e16f61e667468dc8983)): ?>
<?php $component = $__componentOriginal66687bf0670b9e16f61e667468dc8983; ?>
<?php unset($__componentOriginal66687bf0670b9e16f61e667468dc8983); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal22ab0dbc2c6619d5954111bba06f01db)): ?>
<?php $attributes = $__attributesOriginal22ab0dbc2c6619d5954111bba06f01db; ?>
<?php unset($__attributesOriginal22ab0dbc2c6619d5954111bba06f01db); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal22ab0dbc2c6619d5954111bba06f01db)): ?>
<?php $component = $__componentOriginal22ab0dbc2c6619d5954111bba06f01db; ?>
<?php unset($__componentOriginal22ab0dbc2c6619d5954111bba06f01db); ?>
<?php endif; ?>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\actions\src\/../resources/views/components/group.blade.php ENDPATH**/ ?>