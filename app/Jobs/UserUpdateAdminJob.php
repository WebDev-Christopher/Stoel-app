<?php

namespace App\Jobs;

use App\Mail\UserAdmin;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UserUpdateAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The podcast instance.
     *
     */
    public $email_to;
    public $email_details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email_to, $email_details)
    {
        $this->email_to = $email_to;
        $this->email_details = $email_details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email_to)->send(new UserAdmin($this->email_details));
    }
}
