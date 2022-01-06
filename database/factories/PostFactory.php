<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class PostFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Post::class;

    #[ArrayShape([
        'author_id' => "int",
        'image' => "string",
        'title' => "string",
        'text' => "string"
    ])]
    public function definition(): array
    {
        /** @var User $author */
        $author = User::query()->select('id')->inRandomOrder()->first();

        return [
            'author_id' => $author->id,
            'image' => 'test-link',
            'title' => $this->faker->title,
            'text' => [["id" => "AaBB2WqCGP","type" => "paragraph","data" => ["text" => "Test text."]]]
        ];
    }
}
