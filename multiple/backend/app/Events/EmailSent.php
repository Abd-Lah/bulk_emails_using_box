<?php

namespace App\Events;

// app/Events/EmailSent.php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $emailId;
    public $status;

    public function __construct($emailId, $status)
    {
        $this->emailId = $emailId;
        $this->status = $status;
    }

    public function broadcastOn()
    {
        return ['email'];
    }

    public function broadcastAs()
    {
        return $this->status;
    }
}
