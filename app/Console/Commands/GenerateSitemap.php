<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap';

    public function handle()
    {
        $locales = ['sk', 'en'];
        $sitemap = Sitemap::create();

        foreach ($locales as $locale) {
            $sitemap->add(Url::create("/$locale"));           // Home page
            $sitemap->add(Url::create("/$locale/coffee"));    // Coffee
            $sitemap->add(Url::create("/$locale/cukr"));      // Cukráreň
            $sitemap->add(Url::create("/$locale/ice"));       // Ice
            $sitemap->add(Url::create("/$locale/bar"));       // Bar
            $sitemap->add(Url::create("/$locale/location"));  // Location
            $sitemap->add(Url::create("/$locale/events"));    // Events
            $sitemap->add(Url::create("/$locale/contact"));   // Contact
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}
