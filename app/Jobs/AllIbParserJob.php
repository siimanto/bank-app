<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\BankUser;

class AllIbParserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;
    protected $day;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($day)
    {
        $this->day      = $day;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->users    = BankUser::where(['status' => 1])->get();
        
        foreach ($this->users as $user) {
            foreach ($user->bankAccounts as $account) {
                IbParserJob::dispatch($user, $account, $this->day)
                                ->delay(now()->addSecond(5));
            }
        }
    }
}
