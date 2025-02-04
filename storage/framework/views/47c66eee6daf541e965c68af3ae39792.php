<!--[if BLOCK]><![endif]--><?php if(filament()->hasUnsavedChangesAlerts()): ?>
        <?php
        $__scriptKey = '1009853406-0';
        ob_start();
    ?>
        <script>
            window.addEventListener('beforeunload', (event) => {
                if (typeof window.Livewire.find('<?php echo e($_instance->getId()); ?>') === 'undefined') {
                    return
                }

                if (
                    [
                        ...(<?php echo \Illuminate\Support\Js::from($this instanceof \Filament\Actions\Contracts\HasActions)->toHtml() ?> ? ($wire.mountedActions ?? []) : []),
                        ...(<?php echo \Illuminate\Support\Js::from($this instanceof \Filament\Forms\Contracts\HasForms)->toHtml() ?>
                            ? ($wire.mountedFormComponentActions ?? [])
                            : []),
                        ...(<?php echo \Illuminate\Support\Js::from($this instanceof \Filament\Infolists\Contracts\HasInfolists)->toHtml() ?>
                            ? ($wire.mountedInfolistActions ?? [])
                            : []),
                        ...(<?php echo \Illuminate\Support\Js::from($this instanceof \Filament\Tables\Contracts\HasTable)->toHtml() ?>
                            ? [
                                  ...($wire.mountedTableActions ?? []),
                                  ...($wire.mountedTableBulkAction
                                      ? [$wire.mountedTableBulkAction]
                                      : []),
                              ]
                            : []),
                    ].length &&
                    !$wire?.__instance?.effects?.redirect
                ) {
                    event.preventDefault()
                    event.returnValue = true

                    return
                }
            })
        </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\filament\src\/../resources/views/components/unsaved-action-changes-alert.blade.php ENDPATH**/ ?>