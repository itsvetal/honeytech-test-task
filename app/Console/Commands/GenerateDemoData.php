<?php

namespace App\Console\Commands;

use App\Modules\Post\Models\Post;
use App\Modules\Tag\Models\Tag;
use Illuminate\Console\Command;
use Faker\Factory as FakerFactory;

class GenerateDemoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:demo
                            {--count=20 : Number of demo posts to generate}
                            {--clear : Clear existing posts and tags before generating}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate demo posts with tags and random static thumbnails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->option('count');
        $clear = $this->option('clear');

        if ($clear) {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

            \Illuminate\Support\Facades\DB::table('post_tag_relations')->truncate();

            Post::truncate();
            Tag::truncate();

            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

            $this->info('Existing data cleared safely (with FK disabled temporarily).');
        }

        $tagsData = [
            'Laravel', 'PHP', 'Docker', 'API', 'Blog', 'Symfony', 'SCSS', 'MySQL', 'JavaScript', 'Testing'
        ];
        $createdTags = 0;
        foreach ($tagsData as $name) {
            if (Tag::firstOrCreate(['name' => $name])->wasRecentlyCreated) {
                $createdTags++;
            }
        }
        $this->info("Tags processed: {$createdTags} new created.");

        $allTags = Tag::all()->pluck('id')->toArray();
        if (empty($allTags)) {
            $this->error('No tags available. Create some first.');
            return 1;
        }

        $thumbnailsPath = storage_path('app/public/thumbnails');
        $staticThumbnails = glob($thumbnailsPath . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        $staticThumbnails = array_map(function ($path) {
            return basename($path);
        }, $staticThumbnails);

        $numThumbnails = count($staticThumbnails);
        if ($numThumbnails === 0) {
            $this->warn('No static thumbnails found in storage/app/public/thumbnails/. Posts will use default image.');
        } else {
            $this->info("Found {$numThumbnails} static thumbnails for random assignment.");
        }

        $faker = FakerFactory::create();
        $bar = $this->output->createProgressBar($count);
        $bar->start();

        for ($i = 0; $i < $count; $i++) {
            $postData = [
                'title' => $faker->sentence(4),
                'content' => $faker->paragraphs(3, true),
            ];

            if ($numThumbnails > 0) {
                $randomThumbnail = $staticThumbnails[$faker->numberBetween(0, $numThumbnails - 1)];
                $postData['thumbnail'] = 'thumbnails/' . $randomThumbnail;
            }

            $post = Post::create($postData);

            $numTags = $faker->numberBetween(1, 3);
            $randomTags = $faker->randomElements($allTags, $numTags);
            $post->tags()->attach($randomTags);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully generated {$count} demo posts with tags!");
        $this->info('Check /posts in your browser. Run with --clear to reset data.');
        $this->info("Thumbnails: Using static files from storage/app/public/thumbnails/. Add more for variety.");

        return 0;
    }
}
