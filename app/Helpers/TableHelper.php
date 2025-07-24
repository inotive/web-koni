<?php

if (!function_exists('sortIcon')) {
    function sortIcon($field)
    {
        $currentSort = request('sort_by');
        $currentOrder = request('order');
        
        if ($currentSort === $field) {
            return $currentOrder === 'asc' 
                ? '<i class="fas fa-sort-up"></i>'
                : '<i class="fas fa-sort-down"></i>';
        }
        
        return '<i class="fas fa-sort text-muted"></i>';
    }
}

if (!function_exists('sortUrl')) {
    function sortUrl($field)
    {
        $currentSort = request('sort_by');
        $currentOrder = request('order');
        
        $order = ($currentSort === $field && $currentOrder === 'asc') 
            ? 'desc' 
            : 'asc';
            
        return request()->fullUrlWithQuery([
            'sort_by' => $field,
            'order' => $order
        ]);
    }
}