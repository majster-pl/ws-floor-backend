<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;

class apiInstallation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Step by step installation process';

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
     * @return int
     */
    public function handle()
    {
        // check if .env file present
        if (!env('APP_NAME')) {
            $this->error("ERROR: .env file is missing!");
            $this->info("\nRun  <bg=green;fg=black>cp .env.example .env</> in app root directory and run this command again");
            return Command::SUCCESS;
        }

        $this->info("Welcome to WS Floor API installer, please follow instruction bellow to complete installation");

        $run_confirm = $this->confirm("Please be aware that running this operation will wipe all data stored in <fg=red>" . env('DB_DATABASE') . "</> database.
 Do you want yo proceed?");

        if (!$run_confirm) {
            $this->info("Installation not completed, you will not be able to login to admin panel of the API.");
            return Command::SUCCESS;
        } else {
            Artisan::call("migrate:fresh", array('--force' => true));
        }

        $seed = $this->confirm("Do you want to populate API with fake data?");
        if ($seed) {
            Artisan::call("db:seed", ["--class" => "FakeDataSeeder", '--force' => true]);

            // draw table for user with login details
            $this->info("Below you have login details to front-end application:");
            $table = new Table($this->output);
            $separator = new TableSeparator;
            $table->setHeaders([
                'login', 'password'
            ]);
            $table->setRows([
                [User::where('id', 1)->pluck('email')[0], 'password123'],
                // [User::where('id', 2)->pluck('email')[0], 'demo123'],
            ]);
            $table->render();

        }


        return Command::SUCCESS;
    }
}
