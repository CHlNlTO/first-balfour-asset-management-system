<?php
    use Filament\Support\Facades\FilamentView;
?>

<!--[if BLOCK]><![endif]--><?php if($this->hasUnsavedDataChangesAlert()): ?>
    <!--[if BLOCK]><![endif]--><?php if(FilamentView::hasSpaMode()): ?>
            <?php
        $__scriptKey = '23842023-0';
        ob_start();
    ?>
            <script>
                let formSubmitted = false

                document.addEventListener(
                    'submit',
                    () => (formSubmitted = true),
                )

                shouldPreventNavigation = () => {
                    if (formSubmitted) {
                        return
                    }

                    return (
                        window.jsMd5(
                            JSON.stringify($wire.data).replace(/\\/g, ''),
                        ) !== $wire.savedDataHash ||
                        $wire?.__instance?.effects?.redirect
                    )
                }

                const showUnsavedChangesAlert = () => {
                    return confirm(<?php echo \Illuminate\Support\Js::from(__('filament-panels::unsaved-changes-alert.body'))->toHtml() ?>)
                }

                document.addEventListener('livewire:navigate', (event) => {
                    if (typeof window.Livewire.find('<?php echo e($_instance->getId()); ?>') !== 'undefined') {
                        if (!shouldPreventNavigation()) {
                            return
                        }

                        if (showUnsavedChangesAlert()) {
                            return
                        }

                        event.preventDefault()
                    }
                })

                window.addEventListener('beforeunload', (event) => {
                    if (!shouldPreventNavigation()) {
                        return
                    }

                    event.preventDefault()
                    event.returnValue = true
                })
            </script>
            <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
    <?php else: ?>
            <?php
        $__scriptKey = '23842023-1';
        ob_start();
    ?>
            <script>
                window.addEventListener('beforeunload', (event) => {
                    if (
                        window.jsMd5(
                            JSON.stringify($wire.data).replace(/\\/g, ''),
                        ) === $wire.savedDataHash ||
                        $wire?.__instance?.effects?.redirect
                    ) {
                        return
                    }

                    event.preventDefault()
                    event.returnValue = true
                })
            </script>
            <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\filament\src\/../resources/views/components/page/unsaved-data-changes-alert.blade.php ENDPATH**/ ?>