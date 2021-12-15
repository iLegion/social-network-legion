<?php

namespace App\Events\Chat;

use App\Models\Dialog\DialogMessage;
use App\Models\User\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class MessageCame
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
        return [
            'id' => $this->message->id,
            'text' => $this->message->text,
        ];
    }

    public function broadcastOn(): array
    {
        $channels = collect();

        $this->users->each(function (User $user) use ($channels) {
            $channels->push(new PrivateChannel("chat.users.$user->id"));
        });

        return $channels->toArray();
    }
}
