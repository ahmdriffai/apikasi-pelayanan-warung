<?php

namespace App\Jobs;

use App\Mail\SendEmailUserCredential;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sendMail;
    protected $password;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sendMail, $password)
    {
        $this->sendMail = $sendMail;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new SendEmailUserCredential($this->sendMail, $this->password);
        Mail::to($this->sendMail)->send($email);
        echo "halo";
    }
}
