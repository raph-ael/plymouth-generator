<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PlymouthGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plymouth:generate {--l|logo=} {--name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Plymouth Generator';

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
     * @return mixed
     */
    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\PlymouthController');
        app()->call([$controller, 'generate'], [
            'logo' => $this->option('logo'),
            'name' => $this->option('name')
        ]);
    }
}
