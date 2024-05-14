<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_academic::year","view_any_academic::year","create_academic::year","update_academic::year","restore_academic::year","restore_any_academic::year","replicate_academic::year","reorder_academic::year","delete_academic::year","delete_any_academic::year","force_delete_academic::year","force_delete_any_academic::year","view_category","view_any_category","create_category","update_category","restore_category","restore_any_category","replicate_category","reorder_category","delete_category","delete_any_category","force_delete_category","force_delete_any_category","view_classroom","view_any_classroom","create_classroom","update_classroom","restore_classroom","restore_any_classroom","replicate_classroom","reorder_classroom","delete_classroom","delete_any_classroom","force_delete_classroom","force_delete_any_classroom","view_employee","view_any_employee","create_employee","update_employee","restore_employee","restore_any_employee","replicate_employee","reorder_employee","delete_employee","delete_any_employee","force_delete_employee","force_delete_any_employee","view_extracurricular","view_any_extracurricular","create_extracurricular","update_extracurricular","restore_extracurricular","restore_any_extracurricular","replicate_extracurricular","reorder_extracurricular","delete_extracurricular","delete_any_extracurricular","force_delete_extracurricular","force_delete_any_extracurricular","view_facility","view_any_facility","create_facility","update_facility","restore_facility","restore_any_facility","replicate_facility","reorder_facility","delete_facility","delete_any_facility","force_delete_facility","force_delete_any_facility","view_financial::transaction","view_any_financial::transaction","create_financial::transaction","update_financial::transaction","restore_financial::transaction","restore_any_financial::transaction","replicate_financial::transaction","reorder_financial::transaction","delete_financial::transaction","delete_any_financial::transaction","force_delete_financial::transaction","force_delete_any_financial::transaction","view_guardian","view_any_guardian","create_guardian","update_guardian","restore_guardian","restore_any_guardian","replicate_guardian","reorder_guardian","delete_guardian","delete_any_guardian","force_delete_guardian","force_delete_any_guardian","view_law","view_any_law","create_law","update_law","restore_law","restore_any_law","replicate_law","reorder_law","delete_law","delete_any_law","force_delete_law","force_delete_any_law","view_organization","view_any_organization","create_organization","update_organization","restore_organization","restore_any_organization","replicate_organization","reorder_organization","delete_organization","delete_any_organization","force_delete_organization","force_delete_any_organization","view_package","view_any_package","create_package","update_package","restore_package","restore_any_package","replicate_package","reorder_package","delete_package","delete_any_package","force_delete_package","force_delete_any_package","view_post","view_any_post","create_post","update_post","restore_post","restore_any_post","replicate_post","reorder_post","delete_post","delete_any_post","force_delete_post","force_delete_any_post","view_product","view_any_product","create_product","update_product","restore_product","restore_any_product","replicate_product","reorder_product","delete_product","delete_any_product","force_delete_product","force_delete_any_product","view_program","view_any_program","create_program","update_program","restore_program","restore_any_program","replicate_program","reorder_program","delete_program","delete_any_program","force_delete_program","force_delete_any_program","view_public::page","view_any_public::page","create_public::page","update_public::page","restore_public::page","restore_any_public::page","replicate_public::page","reorder_public::page","delete_public::page","delete_any_public::page","force_delete_public::page","force_delete_any_public::page","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_student","view_any_student","create_student","update_student","restore_student","restore_any_student","replicate_student","reorder_student","delete_student","delete_any_student","force_delete_student","force_delete_any_student","view_student::product","view_any_student::product","create_student::product","update_student::product","restore_student::product","restore_any_student::product","replicate_student::product","reorder_student::product","delete_student::product","delete_any_student::product","force_delete_student::product","force_delete_any_student::product","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","view_wallet","view_any_wallet","create_wallet","update_wallet","restore_wallet","restore_any_wallet","replicate_wallet","reorder_wallet","delete_wallet","delete_any_wallet","force_delete_wallet","force_delete_any_wallet","page_EditProfile","page_EditProfileEmployee","page_EditProfileStudent"]},{"name":"panel_user","guard_name":"web","permissions":[]},{"name":"santri","guard_name":"web","permissions":["page_EditProfile","page_EditProfileStudent"]},{"name":"admin_keuangan","guard_name":"web","permissions":["view_financial::transaction","view_any_financial::transaction","create_financial::transaction","update_financial::transaction","restore_financial::transaction","restore_any_financial::transaction","replicate_financial::transaction","reorder_financial::transaction","delete_financial::transaction","delete_any_financial::transaction","force_delete_financial::transaction","force_delete_any_financial::transaction","view_package","view_any_package","create_package","update_package","restore_package","restore_any_package","replicate_package","reorder_package","delete_package","delete_any_package","view_product","view_any_product","create_product","update_product","restore_product","restore_any_product","replicate_product","reorder_product","delete_product","delete_any_product","view_role","view_any_role","view_student","view_any_student","view_student::product","view_any_student::product","create_student::product","update_student::product","restore_student::product","restore_any_student::product","replicate_student::product","reorder_student::product","delete_student::product","delete_any_student::product","view_wallet","view_any_wallet","create_wallet","update_wallet","restore_wallet","restore_any_wallet","replicate_wallet","reorder_wallet","delete_wallet","delete_any_wallet"]},{"name":"admin_tata_usaha","guard_name":"web","permissions":["view_academic::year","view_any_academic::year","create_academic::year","update_academic::year","restore_academic::year","restore_any_academic::year","replicate_academic::year","reorder_academic::year","delete_academic::year","delete_any_academic::year","view_category","view_any_category","create_category","update_category","restore_category","restore_any_category","replicate_category","reorder_category","delete_category","delete_any_category","view_classroom","view_any_classroom","create_classroom","update_classroom","restore_classroom","restore_any_classroom","replicate_classroom","reorder_classroom","delete_classroom","delete_any_classroom","view_employee","view_any_employee","create_employee","update_employee","restore_employee","restore_any_employee","replicate_employee","reorder_employee","delete_employee","delete_any_employee","view_extracurricular","view_any_extracurricular","create_extracurricular","update_extracurricular","restore_extracurricular","restore_any_extracurricular","replicate_extracurricular","reorder_extracurricular","delete_extracurricular","delete_any_extracurricular","view_facility","view_any_facility","create_facility","update_facility","restore_facility","restore_any_facility","replicate_facility","reorder_facility","delete_facility","delete_any_facility","view_guardian","view_any_guardian","create_guardian","update_guardian","restore_guardian","restore_any_guardian","replicate_guardian","reorder_guardian","delete_guardian","delete_any_guardian","view_law","view_any_law","create_law","update_law","restore_law","restore_any_law","replicate_law","reorder_law","delete_law","delete_any_law","view_organization","view_any_organization","create_organization","update_organization","restore_organization","restore_any_organization","replicate_organization","reorder_organization","delete_organization","delete_any_organization","view_package","view_any_package","create_package","update_package","restore_package","restore_any_package","replicate_package","reorder_package","delete_package","delete_any_package","view_product","view_any_product","create_product","update_product","restore_product","restore_any_product","replicate_product","reorder_product","delete_product","delete_any_product","view_program","view_any_program","create_program","update_program","restore_program","restore_any_program","replicate_program","reorder_program","delete_program","delete_any_program","view_role","view_any_role","update_role","create_role","view_student","view_any_student","create_student","update_student","restore_student","restore_any_student","replicate_student","reorder_student","delete_student","delete_any_student","view_student::product","view_any_student::product","view_user","view_any_user","view_wallet","view_any_wallet"]},{"name":"guru","guard_name":"web","permissions":[]},{"name":"pengurus","guard_name":"web","permissions":["view_academic::year","view_any_academic::year","view_category","view_any_category","view_classroom","view_any_classroom","view_employee","view_any_employee","view_extracurricular","view_any_extracurricular","view_facility","view_any_facility","view_financial::transaction","view_any_financial::transaction","view_guardian","view_any_guardian","view_law","view_any_law","view_organization","view_any_organization","view_package","view_any_package","view_post","view_any_post","view_product","view_any_product","view_program","view_any_program","view_public::page","view_any_public::page","view_any_role","view_role","view_student","view_any_student","view_student::product","view_any_student::product","view_user","view_any_user","view_wallet","view_any_wallet","page_EditProfileEmployee","page_EditProfile"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
