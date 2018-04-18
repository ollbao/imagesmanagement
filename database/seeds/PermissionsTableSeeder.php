<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['pid' => '0', 'name' => '/', 'param' => null, 'title' => '主页', 'icon' => 'fas fa-home', 'sort' => '0', 'is_menu' => '1', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '0', 'name' => 'rbac', 'param' => null, 'title' => 'RBAC管理', 'icon' => 'fas fa-sitemap', 'sort' => '1', 'is_menu' => '1', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '2', 'name' => 'permission', 'param' => null, 'title' => '权限列表', 'icon' => 'fas fa-puzzle-piece', 'sort' => '0', 'is_menu' => '1', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '3', 'name' => 'add-permission', 'param' => null, 'title' => '增加权限', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '3', 'name' => 'edit-permission', 'param' => null, 'title' => '修改权限', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '3', 'name' => 'delete-permission', 'param' => null, 'title' => '删除权限', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '2', 'name' => 'roles', 'param' => null, 'title' => '角色管理', 'icon' => 'fas fa-user-md', 'sort' => '0', 'is_menu' => '1', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '7', 'name' => 'add-role', 'param' => null, 'title' => '添加角色', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '7', 'name' => 'edit-role', 'param' => 'id=1', 'title' => '编辑角色', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '7', 'name' => 'delete-role', 'param' => null, 'title' => '删除角色', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '3', 'name' => 'sort-permission', 'param' => null, 'title' => '排序', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '3', 'name' => 'menu-permission', 'param' => null, 'title' => '设置菜单', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '2', 'name' => 'admin-users', 'param' => null, 'title' => '管理员管理', 'icon' => 'fas fa-user', 'sort' => '0', 'is_menu' => '1', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '13', 'name' => 'add-admin', 'param' => null, 'title' => '添加', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '13', 'name' => 'edit-admin', 'param' => null, 'title' => '修改', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '13', 'name' => 'delete-admin', 'param' => null, 'title' => '删除', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '13', 'name' => 'status-admin', 'param' => null, 'title' => '设置状态', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '0', 'name' => 'me', 'param' => null, 'title' => '个人中心', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '7', 'name' => 'assign-permission', 'param' => null, 'title' => '分配权限', 'icon' => 'fas fa-info-circle', 'sort' => '0', 'is_menu' => '0', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '0', 'name' => 'users.manage', 'param' => null, 'title' => '用户管理', 'icon' => 'fas fa-users', 'sort' => '0', 'is_menu' => '1', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pid' => '20', 'name' => 'users', 'param' => null, 'title' => '用户列表', 'icon' => 'far fa-user', 'sort' => '0', 'is_menu' => '1', 'guard_name' => 'admin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ];

        Permission::insert($data);

    }
}
