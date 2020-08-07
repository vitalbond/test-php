<?php

namespace App\Console\Commands;

use App\Libraries\Parser\RbcParser;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;

class Parse extends BaseCommand
{
    protected $signature = 'parse';
    protected $description = '';

    public function handle()
    {
        $insertedCount = 0;

        $parser = new RbcParser;

        $this->log('Parsing index page...');

        $items = $parser->parseIndexPage();

        $this->log(count($items) . ' items fetched');

        $sourceIds = array_map(function ($item) {
            return $item['source_id'];
        }, $items);
        $existingSourceIds = Article::fetchExistingSourceIds($sourceIds);
        $existingSourceIdsMap = array_flip($existingSourceIds);

        foreach ($items as &$item) {
            if (isset($existingSourceIdsMap[$item['source_id']])) {
                continue;
            }

            $this->log('Parsing ' . $item['url']);

            try {
                $res = $parser->parseFullPage($item['url']);

                $article = new Article();
                $article->fill([
                    'title' => $res['title'],
                    'text' => $res['text'],
                    'source_id' => $item['source_id'],
                    'source_url' => $item['url'],
                    'datetime' => $res['datetime'],
                    'has_image' => !!$res['imageUrl'],
                ]);
                if ($article->save()) {
                    $insertedCount++;
                }

                if ($res['imageUrl']) {
                    $imageContents = file_get_contents($res['imageUrl']);
                    Storage::put($article->getImagePath(), $imageContents);
                }
            } catch (\Exception $e) {
                $this->log('Error parsing ' . $item['url']);
            }
        }

        $this->log('Finished, ' . $insertedCount . ' items inserted');
    }
}
