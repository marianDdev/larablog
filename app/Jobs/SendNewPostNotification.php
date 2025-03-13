<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use App\Notifications\NewPostNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;

class SendNewPostNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Collection $readers, private Post $post)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var User $reader */
        foreach ($this->readers as $reader) {
            $reader->notify(new NewPostNotification($this->post));
        }
    }
}
