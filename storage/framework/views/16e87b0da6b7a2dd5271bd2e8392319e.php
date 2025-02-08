<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => ['class' => \Illuminate\Support\Arr::toCssClasses([
        'fi-resource-view-record-page',
        'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
        'fi-resource-record-' . $record->getKey(),
    ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
        'fi-resource-view-record-page',
        'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
        'fi-resource-record-' . $record->getKey(),
    ]))]); ?>
    <?php
        $relationManagers = $this->getRelationManagers();
        $hasCombinedRelationManagerTabsWithContent = $this->hasCombinedRelationManagerTabsWithContent();
    ?>

    <!--[if BLOCK]><![endif]--><?php if((! $hasCombinedRelationManagerTabsWithContent) || (! count($relationManagers))): ?>
        <!--[if BLOCK]><![endif]--><?php if($this->hasInfolist()): ?>
            <?php echo e($this->infolist); ?>

        <?php else: ?>
            <div
                wire:key="<?php echo e($this->getId()); ?>.forms.<?php echo e($this->getFormStatePath()); ?>"
            >
                <?php echo e($this->form); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if(count($relationManagers)): ?>
        <?php if (isset($component)) { $__componentOriginal66235374c4c55de4d5fac61c84f69826 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal66235374c4c55de4d5fac61c84f69826 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.resources.relation-managers','data' => ['activeLocale' => isset($activeLocale) ? $activeLocale : null,'activeManager' => $this->activeRelationManager ?? ($hasCombinedRelationManagerTabsWithContent ? null : array_key_first($relationManagers)),'contentTabLabel' => $this->getContentTabLabel(),'contentTabIcon' => $this->getContentTabIcon(),'contentTabPosition' => $this->getContentTabPosition(),'managers' => $relationManagers,'ownerRecord' => $record,'pageClass' => static::class]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::resources.relation-managers'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['active-locale' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($activeLocale) ? $activeLocale : null),'active-manager' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->activeRelationManager ?? ($hasCombinedRelationManagerTabsWithContent ? null : array_key_first($relationManagers))),'content-tab-label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getContentTabLabel()),'content-tab-icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getContentTabIcon()),'content-tab-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getContentTabPosition()),'managers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($relationManagers),'owner-record' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($record),'page-class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(static::class)]); ?>
            <!--[if BLOCK]><![endif]--><?php if($hasCombinedRelationManagerTabsWithContent): ?>
                 <?php $__env->slot('content', null, []); ?> 
                    <!--[if BLOCK]><![endif]--><?php if($this->hasInfolist()): ?>
                        <?php echo e($this->infolist); ?>

                    <?php else: ?>
                        <?php echo e($this->form); ?>

                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                 <?php $__env->endSlot(); ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal66235374c4c55de4d5fac61c84f69826)): ?>
<?php $attributes = $__attributesOriginal66235374c4c55de4d5fac61c84f69826; ?>
<?php unset($__attributesOriginal66235374c4c55de4d5fac61c84f69826); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal66235374c4c55de4d5fac61c84f69826)): ?>
<?php $component = $__componentOriginal66235374c4c55de4d5fac61c84f69826; ?>
<?php unset($__componentOriginal66235374c4c55de4d5fac61c84f69826); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\filament\src\/../resources/views/resources/pages/view-record.blade.php ENDPATH**/ ?>