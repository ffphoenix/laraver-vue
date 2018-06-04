<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\TransactionRepository;

class storeSumOfAllTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:sum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store Sum Of All Transactions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $transactionRep;

    public function __construct(TransactionRepository $transactionRepository) {

        $this->transactionRep = $transactionRepository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->transactionRep->yesterdaySum();
    }
}
