<?php

namespace App\Jobs;

use App\Mail\AddedChair;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ChairCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The podcast instance.
     *
     */
    public $allUsers;
    public $CreateChair;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($allUsers, $CreateChair)
    {
        $this->allUsers = $allUsers;
        $this->CreateChair = $CreateChair;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->allUsers)->send(new AddedChair($this->CreateChair));
    }
}
