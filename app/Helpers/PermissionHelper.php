<?php

/**
 * Cek apakah user punya permission tertentu
 */
function hasPermission(string $slug): bool
{
    $permissions = session()->get('permissions');

    if (!is_array($permissions)) {
        return false;
    }

    return in_array($slug, $permissions);
}

/**
 * Cek banyak permission (OR)
 * salah satu boleh
 */
function hasAnyPermission(array $slugs): bool
{
    $permissions = session()->get('permissions');

    if (!is_array($permissions)) {
        return false;
    }

    foreach ($slugs as $slug) {
        if (in_array($slug, $permissions)) {
            return true;
        }
    }

    return false;
}

/**
 * Cek semua permission (AND)
 * semua harus ada
 */
function hasAllPermissions(array $slugs): bool
{
    $permissions = session()->get('permissions');

    if (!is_array($permissions)) {
        return false;
    }

    foreach ($slugs as $slug) {
        if (!in_array($slug, $permissions)) {
            return false;
        }
    }

    return true;
}