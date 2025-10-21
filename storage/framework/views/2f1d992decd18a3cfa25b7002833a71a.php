<?php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
?>

<?php if($paginator->total() > 0): ?>
    <div class="flex items-center justify-end gap-4">
        <div>
            <div class="font-semibold">
                <span>Tampil</span>
                <span class="fw-semibold"><?php echo e($paginator->firstItem()); ?></span>
                <span>-</span>
                <span class="fw-semibold"><?php echo e($paginator->lastItem()); ?></span>
                <span>dari</span>
                <span class="fw-semibold"><?php echo e($paginator->total()); ?></span>
            </div>
        </div>
    
        <?php if($paginator->hasPages()): ?>
            <div class="flex items-center gap-3">
                <span>
                    
                    <?php if($paginator->onFirstPage()): ?>
                        <div
                        class="rounded-xl border border-Orange-Primary text-Orange-Primary flex items-center justify-center size-10 cursor-not-allowed opacity-30" disabled>
                            <i class="ti ti-chevron-left text-xl"></i>
                        </div>
                    <?php else: ?>
                        <?php if(method_exists($paginator,'getCursorName')): ?>
                            <button type="button" dusk="previousPage" wire:key="cursor-<?php echo e($paginator->getCursorName()); ?>-<?php echo e($paginator->previousCursor()->encode()); ?>" wire:click="setPage('<?php echo e($paginator->previousCursor()->encode()); ?>','<?php echo e($paginator->getCursorName()); ?>')" x-on:click="<?php echo e($scrollIntoViewJsSnippet); ?>" wire:loading.attr="disabled" class="rounded-xl border border-Orange-Primary text-Orange-Primary flex items-center justify-center size-10">
                                    <i class="ti ti-chevron-left text-xl"></i>
                            </button>
                        <?php else: ?>
                            <button
                                type="button" wire:click="previousPage('<?php echo e($paginator->getPageName()); ?>')" x-on:click="<?php echo e($scrollIntoViewJsSnippet); ?>" wire:loading.attr="disabled" dusk="previousPage<?php echo e($paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName()); ?>" class="rounded-xl border border-Orange-Primary text-Orange-Primary flex items-center justify-center size-10">
                                    <i class="ti ti-chevron-left text-xl"></i>
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </span>
    
                <span>
                    
                    <?php if($paginator->hasMorePages()): ?>
                        <?php if(method_exists($paginator,'getCursorName')): ?>
                            <button type="button" dusk="nextPage" wire:key="cursor-<?php echo e($paginator->getCursorName()); ?>-<?php echo e($paginator->nextCursor()->encode()); ?>" wire:click="setPage('<?php echo e($paginator->nextCursor()->encode()); ?>','<?php echo e($paginator->getCursorName()); ?>')" x-on:click="<?php echo e($scrollIntoViewJsSnippet); ?>" wire:loading.attr="disabled" class="rounded-xl border border-Orange-Primary text-Orange-Primary flex items-center justify-center cursor-pointer size-10">
                                <i class="ti ti-chevron-right text-xl"></i>
                            </button>
                        <?php else: ?>
                            <button type="button" wire:click="nextPage('<?php echo e($paginator->getPageName()); ?>')" x-on:click="<?php echo e($scrollIntoViewJsSnippet); ?>" wire:loading.attr="disabled" dusk="nextPage<?php echo e($paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName()); ?>" class="rounded-xl border border-Orange-Primary text-Orange-Primary flex items-center justify-center cursor-pointer size-10">
                                <i class="ti ti-chevron-right text-xl"></i>
                            </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="rounded-xl border border-Orange-Primary text-Orange-Primary flex items-center justify-center size-10 cursor-not-allowed opacity-30" disabled>
                            <i class="ti ti-chevron-right text-xl"></i>
                        </div>
                    <?php endif; ?>
                </span>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/vendor/livewire/simple.blade.php ENDPATH**/ ?>