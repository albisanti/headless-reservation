<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Support\DripEmailer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SetupApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:make {email=admin@admin.com} {password=admin} {--name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the application and make a new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param  \App\Support\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $pwd = $this->argument('password');
        $name = $this->option('name');

        $roles = \Spatie\Permission\Models\Role::all();
        if(count($roles) === 0) {
            $user = new User();
            $user->email = $email;
            $user->name = $name ?? 'Admin';
            $user->surname = 'Admin';
            $user->password = app('hash')->make($pwd);
            $user->confirm_token = app('hash')->make(date('d-m-Y').'asd'.$name.'Admin');
            $user->save();
            \Spatie\Permission\Models\Permission::create(['name' => 'admin-room']);
            \Spatie\Permission\Models\Permission::create(['name' => 'admin-hours']);
            \Spatie\Permission\Models\Permission::create(['name' => 'admin-reservation']);
            \Spatie\Permission\Models\Permission::create(['name' => 'admin-request']);
            \Spatie\Permission\Models\Permission::create(['name' => 'admin-users']);
            \Spatie\Permission\Models\Role::create(['name' => 'super-admin'])
            ->givePermissionTo(['admin-room','admin-hours','admin-reservation','admin-request','admin-users']);
            $user->assignRole('super-admin');
            $this->info("Permission created succesfully");
        } else {
            $this->warn('Permission and roles already created');
        }
    }
}
