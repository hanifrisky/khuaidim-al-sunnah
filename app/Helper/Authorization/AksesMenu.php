<?php

namespace App\Helper\Authorization;

use Illuminate\Database\Eloquent\Model;

trait AksesMenu
{
    protected static function userId()
    {
        return auth()->user()->id;
    }
    protected static function guruId()
    {
        $user = auth()->user()->guru;
        if ($user == null) return null;
        return $user->id;
    }
    protected static function siswaId()
    {
        $user = auth()->user()->siswa;
        if ($user == null) return null;
        return $user->id;
    }
    protected static function menuRole(): array
    {
        return ['admin'];
    }
    public static function isRole(string $role): bool
    {
        $user = auth()->user();
        if ($user == null) return false;

        if ($user->role == null) return false;

        return $user->role == $role;
    }

    public static function hasAccess(): bool
    {
        $user = auth()->user();
        if ($user == null) return false;

        if ($user->role == null) return false;
        $value = in_array($user->role, static::menuRole(), true);
        return $value;
    }

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return self::hasAccess() && static::$shouldRegisterNavigation;
    }

    public static function canAccess(array $parameters = []): bool
    {
        return self::hasAccess();
    }

    public static function canEdit(Model $record): bool
    {
        return self::hasAccess();
    }

    public static function canCreate(): bool
    {
        return self::hasAccess();
    }

    public static function canDelete(Model $record): bool
    {
        return self::hasAccess();
    }

    public static function canView(Model $record): bool
    {
        return self::hasAccess();
    }

    public static function canViewAny(): bool
    {
        return self::hasAccess();
    }
}
