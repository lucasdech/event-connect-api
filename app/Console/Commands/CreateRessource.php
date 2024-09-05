<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRessource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:ressource {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument("name");
        $nameArgument = compact("name");

        $this->call('make:repository', $nameArgument);
        $this->call('make:validator', $nameArgument);

    }
}
