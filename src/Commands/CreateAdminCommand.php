<?php

namespace Exdeliver\Causeway\Commands;

use Carbon\Carbon;
use Exdeliver\Causeway\Domain\Entities\User\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'causeway:admin {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a admin account';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        /** @var User $user */
        $user = User::where('email', $email)->first();

        if (null === $user) {
            $user = User::create([
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'first_name' => 'Admin',
                'last_name' => 'Causeway',
                'name' => 'Admin Causeway',
            ]);

            $user->assignRole('admin');
        }
    }
}
