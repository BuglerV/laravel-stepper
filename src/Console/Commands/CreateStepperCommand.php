<?php

namespace Buglerv\Stepper\Console\Commands;

use Illuminate\Console\Command;

class CreateStepperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stepper:create {step=1 : Steps count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create controllers for stepper';

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
        $this->comment('Works!');
      
        return 0;
    }
}
