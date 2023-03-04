<?php

namespace App\Console\Commands;

use App\Events\SendMailProcessed;
use App\Functions\Functions;
use App\Models\Customer;
use App\Models\MailConfig;
use Illuminate\Console\Command;

class resetAllPasswordUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resetAllPasswordUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and reset password all users ';

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
        $customers = Customer::all();
        foreach($customers as $customer) {
            $password = substr(md5(microtime()), rand(0, 26), 8);
            $customer->password = bcrypt($password);
            $customer->isVerified = 1;
            $customer->save();

            $replaces['NAME'] = $customer->firstName . ' ' . $customer->lastName;
            $replaces['PASSWORD'] = $password;
            $mailConfig = MailConfig::where('code','=','forgot_password')->first();
            $body =  Functions::replaceBodyEmail($mailConfig->body,$customer);
            $body = str_replace("{{PASSWORD}}", $password, $body);
            event(new SendMailProcessed($customer->email, $mailConfig->subject, $body));
        }
    }
}
