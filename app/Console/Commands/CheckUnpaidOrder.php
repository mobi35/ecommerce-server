<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
class CheckUnpaidOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:unpaidorder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will check all the unpaid order';

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
        
        User::create([
            'email' => "burat@yahoo.com",
            'password' => 'asdasd',
            'role' => 'asdas',
            'name' => 'asdasd'
        ]);

        echo "done";
        //
    }
}
