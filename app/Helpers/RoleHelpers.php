<?php
if (!function_exists('authorize_role')) {
    function authorize_role(array $roles) {
        $user = auth()->user();
        if (!$user || !$user->hasRole($roles)) {
            abort(403, 'Akses ditolak.');
        }
    }
}