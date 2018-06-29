<?php

namespace Maher\Counters\Commands;

use Illuminate\Console\Command;
use Maher\Counters\Models\Counter;

class MakeCounter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:counter {key} {name} {initial_value=0} {step=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Counter';

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
        $this->line('[Counters] Creating the counter...');


        $key = $this->argument('key');
        $name = $this->argument('name');
        $initial_value = $this->argument('initial_value');
        $step = $this->argument('step');

        $value = $initial_value;

        Counter::query()->create(
            compact('key', 'name', 'initial_value', 'step', 'value')
        );


        $this->info("[Counters] Counter $key created Successfully");

        return;
    }

}
