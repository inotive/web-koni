@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

@if ($paginator->total() > 0)
    <div class="flex items-center justify-end gap-4">
        <div>
            <div class="font-semibold">
                <span>Tampil</span>
                <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                <span>-</span>
                <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                <span>dari</span>
                <span class="fw-semibold">{{ $paginator->total() }}</span>
            </div>
        </div>
    
        @if ($paginator->hasPages())
            <div class="flex items-center gap-3">
                <span>
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <div
                        class="rounded-xl border border-Orange-Primary text-Orange-Primary flex items-center justify-center size-10 cursor-not-allowed opacity-30" disabled>
                            <i class="ti ti-chevron-left text-xl"></i>
                        </div>
                    @else
                        @if(method_exists($paginator,'getCursorName'))
                            <button type="button" dusk="previousPage" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->previousCursor()->encode() }}" wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="rounded-xl border border-Orange-Primary text-Orange-Primary flex items-center justify-center size-10">
                                    <i class="ti ti-chevron-left text-xl"></i>
                            </button>
                        @else
                            <button
                                type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="rounded-xl border border-Orange-Primary text-Orange-Primary flex items-center justify-center size-10">
                                    <i class="ti ti-chevron-left text-xl"></i>
                            </button>
                        @endif
                    @endif
                </span>
    
                <span>
                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        @if(method_exists($paginator,'getCursorName'))
                            <button type="button" dusk="nextPage" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->nextCursor()->encode() }}" wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="rounded-xl border border-Orange-Primary text-Orange-Primary flex items-center justify-center cursor-pointer size-10">
                                <i class="ti ti-chevron-right text-xl"></i>
                            </button>
                        @else
                            <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="rounded-xl border border-Orange-Primary text-Orange-Primary flex items-center justify-center cursor-pointer size-10">
                                <i class="ti ti-chevron-right text-xl"></i>
                            </button>
                        @endif
                    @else
                        <div class="rounded-xl border border-Orange-Primary text-Orange-Primary flex items-center justify-center size-10 cursor-not-allowed opacity-30" disabled>
                            <i class="ti ti-chevron-right text-xl"></i>
                        </div>
                    @endif
                </span>
            </div>
        @endif
    </div>
@endif