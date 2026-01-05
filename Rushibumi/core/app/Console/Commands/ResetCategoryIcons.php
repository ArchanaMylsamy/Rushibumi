<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class ResetCategoryIcons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categories:reset-icons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all category icons to default icons';

    /**
     * Default icons mapping based on category names
     */
    protected $defaultIcons = [
        'sports' => '<i class="fas fa-trophy"></i>',
        'music' => '<i class="fas fa-music"></i>',
        'entertainment' => '<i class="fas fa-film"></i>',
        'education' => '<i class="fas fa-graduation-cap"></i>',
        'tutorial' => '<i class="fas fa-chalkboard-teacher"></i>',
        'devotional' => '<i class="fas fa-praying-hands"></i>',
        'technology' => '<i class="fas fa-laptop-code"></i>',
        'tech' => '<i class="fas fa-laptop-code"></i>',
        'shopping' => '<i class="fas fa-shopping-cart"></i>',
        'gaming' => '<i class="fas fa-gamepad"></i>',
        'news' => '<i class="fas fa-newspaper"></i>',
        'comedy' => '<i class="fas fa-laugh"></i>',
        'travel' => '<i class="fas fa-plane"></i>',
        'food' => '<i class="fas fa-utensils"></i>',
        'cooking' => '<i class="fas fa-utensils"></i>',
        'fitness' => '<i class="fas fa-dumbbell"></i>',
        'health' => '<i class="fas fa-heartbeat"></i>',
        'beauty' => '<i class="fas fa-palette"></i>',
        'fashion' => '<i class="fas fa-tshirt"></i>',
        'science' => '<i class="fas fa-flask"></i>',
        'nature' => '<i class="fas fa-leaf"></i>',
        'animals' => '<i class="fas fa-paw"></i>',
        'default' => '<i class="fas fa-folder"></i>',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Resetting category icons to defaults...');

        $categories = Category::all();
        $updated = 0;

        foreach ($categories as $category) {
            $icon = $this->getDefaultIcon($category->name, $category->slug);
            
            $category->icon = $icon;
            $category->save();
            
            $updated++;
            $this->line("Updated: {$category->name} -> {$icon}");
        }

        $this->info("Successfully reset {$updated} category icons!");
        
        return Command::SUCCESS;
    }

    /**
     * Get default icon for a category based on name or slug
     */
    protected function getDefaultIcon($name, $slug)
    {
        $searchTerms = array_merge(
            explode(' ', strtolower($name)),
            explode('-', strtolower($slug)),
            [strtolower($name), strtolower($slug)]
        );

        foreach ($searchTerms as $term) {
            $term = trim($term);
            if (isset($this->defaultIcons[$term])) {
                return $this->defaultIcons[$term];
            }
        }

        return $this->defaultIcons['default'];
    }
}

