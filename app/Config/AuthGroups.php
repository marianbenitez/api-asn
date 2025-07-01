<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'usuario';

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * An associative array of the available groups in the system, where the keys
     * are the group names and the values are arrays of the group info.
     *
     * Whatever value you assign as the key will be used to refer to the group
     * when using functions such as:
     *      $user->addGroup('superadmin');
     *
     * @var array<string, array<string, string>>
     *
     * @see https://codeigniter4.github.io/shield/quick_start_guide/using_authorization/#change-available-groups for more info
     */
    public array $groups = [
        'superadmin' => [
            'title'       => 'Super Administrador',
            'description' => 'Control completo del sitio.',
        ],
        'admin' => [
            'title'       => 'Administrador',
            'description' => 'Administradores diarios del sitio.',
        ],
        'usuario' => [
            'title'       => 'Usuario',
            'description' => 'Usuarios generales del sitio.',
        ],
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system.
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        'admin.access'        => 'Puede acceder al área de administración del sitio',
        'admin.settings'      => 'Puede acceder a la configuración principal del sitio',
        'users.manage-admins' => 'Puede gestionar otros administradores',
        'users.create'        => 'Puede crear nuevos usuarios no administradores',
        'users.edit'          => 'Puede editar usuarios existentes no administradores',
        'users.delete'        => 'Puede eliminar usuarios existentes no administradores',
        'api.access'          => 'Puede acceder a los endpoints de la API',
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     *
     * This defines group-level permissions.
     */
    public array $matrix = [
        'superadmin' => [
            'admin.*',
            'users.*',
            'api.access',
        ],
        'admin' => [
            'admin.access',
            'users.create',
            'users.edit',
            'users.delete',
            'api.access',
        ],
        'usuario' => [
            'api.access',
        ],
    ];
}