<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{

    public function run(): void
    {

        $permissions = [

            'users.manage',

            'berita.manage',
            'video.manage',
            'pamflet.manage',
            'slider-website.manage',

            'sejarah-dinas.manage',
            'visi-misi-instansi.manage',
            'tugas-fungsi.manage',
            'struktur-organisasi.manage',
            'data-kadis.manage',
            'data-pejabat.manage',

            'visimisippid.manage',
            'tugasppid.manage',
            'ppid.manage',
            'alamat.manage',

            'faq.manage',
            'settings.manage',
        ];


        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $superadmin = Role::create([
            'name' => 'Superadmin'
        ]);

        $editor = Role::create([
            'name' => 'Editor'
        ]);

        $operator = Role::create([
            'name' => 'Operator'
        ]);

        $superadmin->givePermissionTo(
            Permission::all()
        );

        $editor->givePermissionTo([
            'berita.manage',
            'video.manage',
            'pamflet.manage',
            'slider-website.manage',
            'faq.manage',

        ]);

        $operator->givePermissionTo([
            'berita.manage',
            'video.manage',
            'pamflet.manage',
            'slider-website.manage',

            'sejarah-dinas.manage',
            'visi-misi-instansi.manage',
            'tugas-fungsi.manage',
            'struktur-organisasi.manage',
            'data-kadis.manage',
            'data-pejabat.manage',

            'visimisippid.manage',
            'tugasppid.manage',
            'ppid.manage',
            'alamat.manage',

            'faq.manage',
            'settings.manage',

        ]);
    }
}
