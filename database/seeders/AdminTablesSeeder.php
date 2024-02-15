<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // base tables
        \Encore\Admin\Auth\Database\Menu::truncate();
        \Encore\Admin\Auth\Database\Menu::insert(
            [
                [
                    "parent_id" => 0,
                    "order" => 1,
                    "title" => "Dashboard",
                    "icon" => "fa-bar-chart",
                    "uri" => "/",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 9,
                    "title" => "Admin",
                    "icon" => "fa-tasks",
                    "uri" => "",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 10,
                    "title" => "Users",
                    "icon" => "fa-users",
                    "uri" => "auth/users",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 11,
                    "title" => "Roles",
                    "icon" => "fa-user",
                    "uri" => "auth/roles",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 12,
                    "title" => "Permission",
                    "icon" => "fa-ban",
                    "uri" => "auth/permissions",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 13,
                    "title" => "Menu",
                    "icon" => "fa-bars",
                    "uri" => "auth/menu",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 14,
                    "title" => "Operation log",
                    "icon" => "fa-history",
                    "uri" => "auth/logs",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 3,
                    "title" => "Depots",
                    "icon" => "fa-bank",
                    "uri" => "/depots",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 2,
                    "title" => "Companies",
                    "icon" => "fa-building-o",
                    "uri" => "/companies",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 4,
                    "title" => "Users",
                    "icon" => "fa-users",
                    "uri" => "/users",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 12,
                    "order" => 6,
                    "title" => "Customers",
                    "icon" => "fa-user",
                    "uri" => "/customers",
                    "permission" => "*"
                ],
                [
                    "parent_id" => 0,
                    "order" => 5,
                    "title" => "DB Data",
                    "icon" => "fa-database",
                    "uri" => "/#",
                    "permission" => "*"
                ],
                [
                    "parent_id" => 12,
                    "order" => 7,
                    "title" => "Assets",
                    "icon" => "fa-car",
                    "uri" => "/assets",
                    "permission" => "*"
                ],
                [
                    "parent_id" => 12,
                    "order" => 8,
                    "title" => "Events",
                    "icon" => "fa-calendar",
                    "uri" => "/events",
                    "permission" => "*"
                ]
            ]
        );

        \Encore\Admin\Auth\Database\Permission::truncate();
        \Encore\Admin\Auth\Database\Permission::insert(
            [
                [
                    "name" => "All permission",
                    "slug" => "*",
                    "http_method" => "",
                    "http_path" => "*"
                ],
                [
                    "name" => "Dashboard",
                    "slug" => "dashboard",
                    "http_method" => "GET",
                    "http_path" => "/"
                ],
                [
                    "name" => "Login",
                    "slug" => "auth.login",
                    "http_method" => "",
                    "http_path" => "/auth/login\r\n/auth/logout"
                ],
                [
                    "name" => "User setting",
                    "slug" => "auth.setting",
                    "http_method" => "GET,PUT",
                    "http_path" => "/auth/setting"
                ],
                [
                    "name" => "Auth management",
                    "slug" => "auth.management",
                    "http_method" => "",
                    "http_path" => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs"
                ]
            ]
        );

        \Encore\Admin\Auth\Database\Role::truncate();
        \Encore\Admin\Auth\Database\Role::insert(
            [
                [
                    "name" => "Administrator",
                    "slug" => "administrator"
                ]
            ]
        );

        // pivot tables
        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_menu')->insert(
            [
                [
                    "role_id" => 1,
                    "menu_id" => 2
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 9
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 10
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 11
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 12
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 13
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 14
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 17
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 18
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 19
                ]
            ]
        );

        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_permissions')->insert(
            [
                [
                    "role_id" => 1,
                    "permission_id" => 1
                ]
            ]
        );

        // finish
    }
}
