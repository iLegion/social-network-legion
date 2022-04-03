<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
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
        $image = $this
            ->faker
            ->image(
                Storage::disk('posts')->path('/'),
                450,
                250,
                'cats',
                false
            );

        return [
            'author_id' => User::query()->select('id')->inRandomOrder()->first()->id,
            'title' => $this->faker->title,
            'text' => [["id" => "AaBB2WqCGP","type" => "paragraph","data" => ["text" => "Test text."]]],
            'image' => $image
        ];
    }
}
