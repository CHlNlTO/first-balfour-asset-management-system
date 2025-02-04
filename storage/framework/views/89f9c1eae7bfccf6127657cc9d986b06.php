<?php
    use Filament\Tables\Enums\FiltersLayout;
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'activeFiltersCount' => 0,
    'applyAction',
    'form',
    'layout',
    'maxHeight' => null,
    'triggerAction',
    'width' => 'xs',
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
    'activeFiltersCount' => 0,
    'applyAction',
    'form',
    'layout',
    'maxHeight' => null,
    'triggerAction',
    'width' => 'xs',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<!--[if BLOCK]><![endif]--><?php if(($layout === FiltersLayout::Modal) || $triggerAction->isModalSlideOver()): ?>
    <?php if (isset($component)) { $__componentOriginal0942a211c37469064369f887ae8d1cef = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0942a211c37469064369f887ae8d1cef = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.modal.index','data' => ['alignment' => $triggerAction->getModalAlignment(),'autofocus' => $triggerAction->isModalAutofocused(),'closeButton' => $triggerAction->hasModalCloseButton(),'closeByClickingAway' => $triggerAction->isModalClosedByClickingAway(),'closeByEscaping' => $triggerAction?->isModalClosedByEscaping(),'description' => $triggerAction->getModalDescription(),'footerActions' => $triggerAction->getVisibleModalFooterActions(),'footerActionsAlignment' => $triggerAction->getModalFooterActionsAlignment(),'heading' => $triggerAction->getCustomModalHeading() ?? __('filament-tables::table.filters.heading'),'icon' => $triggerAction->getModalIcon(),'iconColor' => $triggerAction->getModalIconColor(),'slideOver' => $triggerAction->isModalSlideOver(),'stickyFooter' => $triggerAction->isModalFooterSticky(),'stickyHeader' => $triggerAction->isModalHeaderSticky(),'width' => $width,'wire:key' => ''.e($this->getId()).'.table.filters','attributes' => $attributes->class(['fi-ta-filters-modal'])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction->getModalAlignment()),'autofocus' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction->isModalAutofocused()),'close-button' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction->hasModalCloseButton()),'close-by-clicking-away' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction->isModalClosedByClickingAway()),'close-by-escaping' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction?->isModalClosedByEscaping()),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction->getModalDescription()),'footer-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction->getVisibleModalFooterActions()),'footer-actions-alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction->getModalFooterActionsAlignment()),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction->getCustomModalHeading() ?? __('filament-tables::table.filters.heading')),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction->getModalIcon()),'icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction->getModalIconColor()),'slide-over' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction->isModalSlideOver()),'sticky-footer' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction->isModalFooterSticky()),'sticky-header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($triggerAction->isModalHeaderSticky()),'width' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($width),'wire:key' => ''.e($this->getId()).'.table.filters','attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes->class(['fi-ta-filters-modal']))]); ?>
         <?php $__env->slot('trigger', null, []); ?> 
            <?php echo e($triggerAction->badge($activeFiltersCount)); ?>

         <?php $__env->endSlot(); ?>

        <?php echo e($triggerAction->getModalContent()); ?>


        <?php echo e($form); ?>


        <?php echo e($triggerAction->getModalContentFooter()); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0942a211c37469064369f887ae8d1cef)): ?>
<?php $attributes = $__attributesOriginal0942a211c37469064369f887ae8d1cef; ?>
<?php unset($__attributesOriginal0942a211c37469064369f887ae8d1cef); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0942a211c37469064369f887ae8d1cef)): ?>
<?php $component = $__componentOriginal0942a211c37469064369f887ae8d1cef; ?>
<?php unset($__componentOriginal0942a211c37469064369f887ae8d1cef); ?>
<?php endif; ?>
<?php else: ?>
    <?php if (isset($component)) { $__componentOriginal22ab0dbc2c6619d5954111bba06f01db = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal22ab0dbc2c6619d5954111bba06f01db = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.index','data' => ['maxHeight' => $maxHeight,'placement' => 'bottom-end','shift' => true,'width' => $width,'wire:key' => ''.e($this->getId()).'.table.filters','attributes' => $attributes->class(['fi-ta-filters-dropdown'])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['max-height' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($maxHeight),'placement' => 'bottom-end','shift' => true,'width' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($width),'wire:key' => ''.e($this->getId()).'.table.filters','attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes->class(['fi-ta-filters-dropdown']))]); ?>
         <?php $__env->slot('trigger', null, []); ?> 
            <?php echo e($triggerAction->badge($activeFiltersCount)); ?>

         <?php $__env->endSlot(); ?>

        <?php if (isset($component)) { $__componentOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.filters.index','data' => ['applyAction' => $applyAction,'form' => $form,'class' => 'p-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['apply-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($applyAction),'form' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($form),'class' => 'p-6']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39)): ?>
<?php $attributes = $__attributesOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39; ?>
<?php unset($__attributesOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39)): ?>
<?php $component = $__componentOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39; ?>
<?php unset($__componentOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39); ?>
<?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\tables\src\/../resources/views/components/filters/dialog.blade.php ENDPATH**/ ?>