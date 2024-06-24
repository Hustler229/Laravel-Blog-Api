    <?php

    use App\Models\Category;
    use App\Models\Comment;
    use App\Models\Post;
    use App\Models\Tag;
    use App\Models\User;
    use Illuminate\Database\Seeder;

    class DatabaseSeeder extends Seeder
    {
        public function run()
        {
            // Création des catégories
            $categories = Category::factory()->count(10)->create();

            // Création des tags
            $tags = Tag::factory()->count(10)->create();

            // Création des utilisateurs
            $users = User::factory()->count(20)->create();

            // Création des posts pour chaque utilisateur
            $users->each(function ($user) use ($categories, $tags, $users) {
                $posts = Post::factory()->count(5)->create([
                    'user_id' => $user->id,
                    'category_id' => $categories->random()->id,
                ]);

                $posts->each(function ($post) use ($tags, $users) {
                    // Attacher des tags au post (aléatoirement)
                    $post->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray());

                    // Création de commentaires pour chaque post
                    Comment::factory()->count(rand(1, 4))->create([
                        'user_id' => $users->random()->id,
                        'post_id' => $post->id,
                    ]);
                });
            });
        }
    }
