<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\BankUser;
use App\BankAccount;
use App\MantoServices\Bank\IbParser;

class IbParserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $account;
    protected $user;
    protected $bank;
    protected $day;
    protected $jobStatus;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(BankUser $user, BankAccount $account, $day)
    {
        $this->account          = $account;
        $this->user             = $user;
        $this->bank             = ($user->type == 1) ? $user->bank->personal_lib : $user->bank->corporate_lib;
        $this->day              = $day;
        $this->jobStatus        = ($account->status == 1 && $user->status == 1) ? 1 : 2;
        if(date('H:i') != config('mantoServices.cron_bank_daily') && $this->jobStatus == 1 && $account->updated_at->addMinutes($account->delay_job_minutes) > now()){
            $this->jobStatus = 2;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->jobStatus == 1){
            $parser     = new IbParser($this->user, $this->account, $this->day);
            $type       = $parser->getType($this->account->type);
            $parser->$type($this->bank);
        }
    }
}
