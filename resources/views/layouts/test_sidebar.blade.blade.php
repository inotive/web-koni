{{-- resources/views/layouts/test_sidebar.blade.php --}}

@php
// Simulate user roles and permissions
$users = [
    'dashboard' => (object)[
        'role' => (object)['hasPermission_id' => 1]
    ],
    'manajemen_rka' => (object)[
        'role' => (object)['hasPermission_id' => 2]
    ],
    'laporan_lpj' => (object)[
        'role' => (object)['hasPermission_id' => 3]
    ],
    'multi' => (object)[
        'role' => (object)['hasPermission_id' => [1,2,3]]
    ],
    'none' => (object)[
        'role' => (object)['hasPermission_id' => null]
    ],
];

// Helper to check permission (simulate)
function hasPermission($user, $id) {
    if (is_array($user->role->hasPermission_id)) {
        return in_array($id, $user->role->hasPermission_id);
    }
    return $user->role->hasPermission_id === $id;
}
@endphp

<h3>Test: User with Dashboard Permission</h3>
@if(hasPermission($users['dashboard'], 1))
    <div>Dashboard menu is visible ✅</div>
@else
    <div>Dashboard menu is NOT visible ❌</div>
@endif

<h3>Test: User with Manajemen RKA Permission</h3>
@if(hasPermission($users['manajemen_rka'], 2))
    <div>Manajemen RKA menu is visible ✅</div>
@else
    <div>Manajemen RKA menu is NOT visible ❌</div>
@endif

<h3>Test: User with Laporan LPJ Permission</h3>
@if(hasPermission($users['laporan_lpj'], 3))
    <div>Laporan LPJ menu is visible ✅</div>
@else
    <div>Laporan LPJ menu is NOT visible ❌</div>
@endif

<h3>Test: User with Multiple Permissions</h3>
@if(hasPermission($users['multi'], 1))
    <div>Dashboard menu is visible ✅</div>
@endif
@if(hasPermission($users['multi'], 2))
    <div>Manajemen RKA menu is visible ✅</div>
@endif
@if(hasPermission($users['multi'], 3))
    <div>Laporan LPJ menu is visible ✅</div>
@endif

<h3>Test: User with No Permissions</h3>
@if(hasPermission($users['none'], 1) || hasPermission($users['none'], 2) || hasPermission($users['none'], 3))
    <div>Some menu is visible ❌</div>
@else
    <div>No menu is visible ✅</div>
@endif