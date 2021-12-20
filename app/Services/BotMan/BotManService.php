<?php

namespace App\Services\BotMan;

use App\Models\Comment;
use App\Models\Dialog\DialogMessage;
use App\Models\Like;
use App\Models\Post;
use App\Models\User\User;
use Illuminate\Support\Collection;

class BotManService
{
    private Collection $messages;

    public function __construct()
    {
        $this->messages = collect([
            'What is your name?' => [
                'My name is Legion Bot.',
                'My name is Legion Bot :).',
            ],
            'Hi' => [
                'Hello',
                'Hi',
                'Welcome'
            ],
            'Hello' => [
                'Hello',
                'Hi',
                'Welcome'
            ],
            'hi' => [
                'Hello',
                'Hi',
                'Welcome'
            ],
            'hello' => [
                'Hello',
                'Hi',
                'Welcome'
            ]
        ]);
    }

    public function hearMessage(string $message): string
    {
        if ($this->messages->has($message)) {
            return $this->returnAnswer($message);
        } else if ($message === 'How many posts?') {
            return "The project created {$this->returnPostsCount()} posts.";
        } else if ($message === 'How many likes?') {
            return "The project have {$this->returnLikesCount()} likes.";
        } else if ($message === 'How many comments?') {
            return "The project have {$this->returnCommentsCount()} comments.";
        } else if ($message === 'How many users?') {
            return "The project have {$this->returnUsersCount()} users.";
        } else if ($message === 'How many dialogs?') {
            return "The project have {$this->returnDialogsCount()} dialogs.";
        }

        return "Sorry, I can't answer :(.";
    }

    private function returnAnswer(string $message): string
    {
        return $this->messages->get($message)[array_rand($this->messages->get($message))];
    }

    private function returnPostsCount(): int
    {
        return Post::query()->count();
    }

    private function returnLikesCount(): int
    {
        return Like::query()->count();
    }

    private function returnCommentsCount(): int
    {
        return Comment::query()->count();
    }

    private function returnUsersCount(): int
    {
        return User::query()->count();
    }

    private function returnDialogsCount(): int
    {
        return DialogMessage::query()->count();
    }
}
