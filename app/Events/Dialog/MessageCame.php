<?php

namespace App\Events\Dialog;

use App\Http\Resources\DialogMessage\DialogMessageResource;
use App\Models\Dialog\DialogMessage;
use App\Models\User\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class MessageCame implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private DialogMessage $message;
    private Collection $users;

    public function __construct(DialogMessage $message, Collection $users)
    {
        $this->message = $message;
        $this->users = $users;
    }

    #[ArrayShape([
        'id' => "int",
        'text' => "string"
    ])]
    public function broadcastWith(): array
    {
        return (new DialogMessageResource($this->message->load('user')))->resolve();
    }

    public function broadcastOn(): array
    {
        $channels = collect();

        $this->users->each(function (User $user) use ($channels) {
            $channels->push(new PrivateChannel("dialog.users.$user->id"));
        });

        return $channels->toArray();
    }
}
