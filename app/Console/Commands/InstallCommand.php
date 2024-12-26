<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting installation...');

        // Clear caches
        $this->info('Clearing caches...');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('view:clear');
        $this->call('route:clear');

        // Run migrations
        $this->info('Running migrations...');
        $this->call('migrate:fresh');

        // Run seeders if available
        $this->info('Running seeders...');
        $this->call('db:seed');

        // Generate app key if not already set
        if (!env('APP_KEY')) {
            $this->info('Generating app key...');
            $this->call('key:generate');
        }

        // Passport installation commands
        $this->info('Setting up Passport...');
        
        // Generate encryption keys if they don't exist
        if (!file_exists(storage_path('oauth-private.key')) || !file_exists(storage_path('oauth-public.key'))) {
            $this->info('Generating Passport encryption keys...');
            $this->call('passport:keys');
        }
        
        // Create personal access client if not exists
        if (!\Laravel\Passport\Client::where('personal_access_client', 1)->exists()) {
            $this->info('Creating personal access client...');
            $this->call('passport:client', [
                '--personal' => true,
                '--name' => 'Personal Access Client'
            ]);
        }
        
        // Create password grant client if not exists
        if (!\Laravel\Passport\Client::where('password_client', 1)->exists()) {
            $this->info('Creating password grant client...');
            $this->call('passport:client', [
                '--password' => true,
                '--name' => 'Password Grant Client',
                '--provider' => 'users'
            ]);
        }

        // Create storage link
        if (!file_exists(public_path('storage'))) {
            $this->info('Creating storage link...');
            $this->call('storage:link');
        }

        $this->info('Installation completed successfully!');
        $this->info('Passport has been configured with all necessary clients and keys.');
        return Command::SUCCESS;
    }
}
