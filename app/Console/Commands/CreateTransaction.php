<?php

namespace App\Console\Commands;

use App\Models\Contact;
use App\Models\Transaction;
use Illuminate\Console\Command;

class CreateTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create transaction in middle and end of months';

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
        foreach (Contact::all() as $contact) {
            if ($contact->ordersNotPaye()->count() > 0) {
                $transaction = Transaction::create([
                    'total' => $contact->ordersNotPaye()->sum('total'),
                    'quantity' =>  $contact->ordersNotPaye()->count(),
                    'contact_id' => $contact->id,
                ]);

                foreach ($contact->ordersNotPaye() as $item) {

                    $item->transaction_id = $transaction->id;
                    $item->save();
                }
            }
        }
    }
}
