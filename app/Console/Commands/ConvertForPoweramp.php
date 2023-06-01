<?php

namespace App\Console\Commands;

class ConvertForPoweramp extends Convert
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-for-poweramp {source} {dest?}';

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
        $this->mode = 'poweramp';
        parent::handle();
    }
}
