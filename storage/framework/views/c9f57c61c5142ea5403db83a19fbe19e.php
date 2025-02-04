<?php
    use Filament\Support\Enums\MaxWidth;
    use Illuminate\Support\Js;

    $isRoot = $isRoot();
?>

<?php if (isset($component)) { $__componentOriginal30dbd75eb120a380110a2b340cd88f46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30dbd75eb120a380110a2b340cd88f46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.grid.index','data' => ['xData' => $isRoot ? '{}' : null,'xOn:formValidationError.window' => 
        $isRoot ? ('if ($event.detail.livewireId !== ' . Js::from($this->getId()) . ') {
                return
            }

            $nextTick(() => {
                let error = $el.querySelector(\'[data-validation-error]\')

                if (! error) {
                    return
                }

                let elementToExpand = error

                while (elementToExpand) {
                    elementToExpand.dispatchEvent(new CustomEvent(\'expand\'))

                    elementToExpand = elementToExpand.parentNode
                }

                setTimeout(
                    () =>
                        error.closest(\'[data-field-wrapper]\').scrollIntoView({
                            behavior: \'smooth\',
                            block: \'start\',
                            inline: \'start\',
                        }),
                    200,
                )
        })') : null
    ,'default' => $getColumns('default'),'sm' => $getColumns('sm'),'md' => $getColumns('md'),'lg' => $getColumns('lg'),'xl' => $getColumns('xl'),'twoXl' => $getColumns('2xl'),'attributes' => 
        \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
            ->class(['fi-fo-component-ctn gap-6'])
    ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRoot ? '{}' : null),'x-on:form-validation-error.window' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
        $isRoot ? ('if ($event.detail.livewireId !== ' . Js::from($this->getId()) . ') {
                return
            }

            $nextTick(() => {
                let error = $el.querySelector(\'[data-validation-error]\')

                if (! error) {
                    return
                }

                let elementToExpand = error

                while (elementToExpand) {
                    elementToExpand.dispatchEvent(new CustomEvent(\'expand\'))

                    elementToExpand = elementToExpand.parentNode
                }

                setTimeout(
                    () =>
                        error.closest(\'[data-field-wrapper]\').scrollIntoView({
                            behavior: \'smooth\',
                            block: \'start\',
                            inline: \'start\',
                        }),
                    200,
                )
        })') : null
    ),'default' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getColumns('default')),'sm' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getColumns('sm')),'md' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getColumns('md')),'lg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getColumns('lg')),'xl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getColumns('xl')),'two-xl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getColumns('2xl')),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
        \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
            ->class(['fi-fo-component-ctn gap-6'])
    )]); ?>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $getComponents(withHidden: true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formComponent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            /**
             * Instead of only rendering the hidden components, we should
             * render the `<div>` wrappers for all fields, regardless of
             * if they are hidden or not. This is to solve Livewire DOM
             * diffing issues.
             *
             * Additionally, any `<div>` elements that wrap hidden
             * components need to have `class="hidden"`, so that they
             * don't consume grid space.
             */
            $isHidden = $formComponent->isHidden();
        ?>

        <?php if (isset($component)) { $__componentOriginal6f9d0ad23f77111c926012ad6ce09333 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6f9d0ad23f77111c926012ad6ce09333 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.grid.column','data' => ['wire:key' => $formComponent instanceof \Filament\Forms\Components\Field ? $this->getId() . '.' . $formComponent->getStatePath() . '.' . $formComponent::class : null,'hidden' => $isHidden,'default' => $formComponent->getColumnSpan('default'),'sm' => $formComponent->getColumnSpan('sm'),'md' => $formComponent->getColumnSpan('md'),'lg' => $formComponent->getColumnSpan('lg'),'xl' => $formComponent->getColumnSpan('xl'),'twoXl' => $formComponent->getColumnSpan('2xl'),'defaultStart' => $formComponent->getColumnStart('default'),'smStart' => $formComponent->getColumnStart('sm'),'mdStart' => $formComponent->getColumnStart('md'),'lgStart' => $formComponent->getColumnStart('lg'),'xlStart' => $formComponent->getColumnStart('xl'),'twoXlStart' => $formComponent->getColumnStart('2xl'),'class' => \Illuminate\Support\Arr::toCssClasses([
                match ($maxWidth = $formComponent->getMaxWidth()) {
                    MaxWidth::ExtraSmall, 'xs' => 'max-w-xs',
                    MaxWidth::Small, 'sm' => 'max-w-sm',
                    MaxWidth::Medium, 'md' => 'max-w-md',
                    MaxWidth::Large, 'lg' => 'max-w-lg',
                    MaxWidth::ExtraLarge, 'xl' => 'max-w-xl',
                    MaxWidth::TwoExtraLarge, '2xl' => 'max-w-2xl',
                    MaxWidth::ThreeExtraLarge, '3xl' => 'max-w-3xl',
                    MaxWidth::FourExtraLarge, '4xl' => 'max-w-4xl',
                    MaxWidth::FiveExtraLarge, '5xl' => 'max-w-5xl',
                    MaxWidth::SixExtraLarge, '6xl' => 'max-w-6xl',
                    MaxWidth::SevenExtraLarge, '7xl' => 'max-w-7xl',
                    default => $maxWidth,
                },
            ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::grid.column'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formComponent instanceof \Filament\Forms\Components\Field ? $this->getId() . '.' . $formComponent->getStatePath() . '.' . $formComponent::class : null),'hidden' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isHidden),'default' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formComponent->getColumnSpan('default')),'sm' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formComponent->getColumnSpan('sm')),'md' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formComponent->getColumnSpan('md')),'lg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formComponent->getColumnSpan('lg')),'xl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formComponent->getColumnSpan('xl')),'twoXl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formComponent->getColumnSpan('2xl')),'defaultStart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formComponent->getColumnStart('default')),'smStart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formComponent->getColumnStart('sm')),'mdStart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formComponent->getColumnStart('md')),'lgStart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formComponent->getColumnStart('lg')),'xlStart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formComponent->getColumnStart('xl')),'twoXlStart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formComponent->getColumnStart('2xl')),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                match ($maxWidth = $formComponent->getMaxWidth()) {
                    MaxWidth::ExtraSmall, 'xs' => 'max-w-xs',
                    MaxWidth::Small, 'sm' => 'max-w-sm',
                    MaxWidth::Medium, 'md' => 'max-w-md',
                    MaxWidth::Large, 'lg' => 'max-w-lg',
                    MaxWidth::ExtraLarge, 'xl' => 'max-w-xl',
                    MaxWidth::TwoExtraLarge, '2xl' => 'max-w-2xl',
                    MaxWidth::ThreeExtraLarge, '3xl' => 'max-w-3xl',
                    MaxWidth::FourExtraLarge, '4xl' => 'max-w-4xl',
                    MaxWidth::FiveExtraLarge, '5xl' => 'max-w-5xl',
                    MaxWidth::SixExtraLarge, '6xl' => 'max-w-6xl',
                    MaxWidth::SevenExtraLarge, '7xl' => 'max-w-7xl',
                    default => $maxWidth,
                },
            ]))]); ?>
            <!--[if BLOCK]><![endif]--><?php if(! $isHidden): ?>
                <?php echo e($formComponent); ?>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6f9d0ad23f77111c926012ad6ce09333)): ?>
<?php $attributes = $__attributesOriginal6f9d0ad23f77111c926012ad6ce09333; ?>
<?php unset($__attributesOriginal6f9d0ad23f77111c926012ad6ce09333); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6f9d0ad23f77111c926012ad6ce09333)): ?>
<?php $component = $__componentOriginal6f9d0ad23f77111c926012ad6ce09333; ?>
<?php unset($__componentOriginal6f9d0ad23f77111c926012ad6ce09333); ?>
<?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal30dbd75eb120a380110a2b340cd88f46)): ?>
<?php $attributes = $__attributesOriginal30dbd75eb120a380110a2b340cd88f46; ?>
<?php unset($__attributesOriginal30dbd75eb120a380110a2b340cd88f46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal30dbd75eb120a380110a2b340cd88f46)): ?>
<?php $component = $__componentOriginal30dbd75eb120a380110a2b340cd88f46; ?>
<?php unset($__componentOriginal30dbd75eb120a380110a2b340cd88f46); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\forms\src\/../resources/views/component-container.blade.php ENDPATH**/ ?>