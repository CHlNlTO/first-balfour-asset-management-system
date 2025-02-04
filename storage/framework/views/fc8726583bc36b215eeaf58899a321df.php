<input
    <?php echo e($attributes
            ->merge([
                'id' => $getId(),
                'type' => 'hidden',
                $applyStateBindingModifiers('wire:model') => $getStatePath(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)
            ->class(['fi-fo-hidden'])); ?>

/>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\forms\src\/../resources/views/components/hidden.blade.php ENDPATH**/ ?>