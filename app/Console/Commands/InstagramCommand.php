<?php

namespace App\Console\Commands;

use App\HashTag;
use App\Instagram;
use App\Post;
use App\PostHashTag;
use App\User;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class InstagramCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:Instagram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $newDataExists = false;

        /** @var HashTag $ssuls */
        $tags = HashTag::get();
        $tags->each(function (HashTag $tag) use (&$newDataExists) {
            try {


                $title = $tag->tag;

                $title = str_replace(' ', '', $title);

                $title = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", '', $title);

                echo "[Instagram]" . $title . "\n";

                $media = $this->getMediaByTag(urlencode($title));

                foreach ($media as $me) {
                    foreach ($me['media']['nodes'] as $node) {
                        if (!Instagram::where('display_src', $node['display_src'])->exists()) {
                            DB::transaction(function () use ($node, $title, $tag, &$newDataExists) {
                                $newInstagram = new Instagram();

                                $newInstagram->display_src = $node['display_src'];
                                $newInstagram->date = $node['date'];
                                $caption = $this->removeEmoji($node['caption']);

                                $newInstagram->caption = $caption;


                                $newInstagram->save();

                                $newPost = new Post();

                                $instaUser = User::where('name', "익명")->first();

                                $newPost->user_id = $instaUser->id;

                                $imagePath = public_path("image/" . $newInstagram->id);
                                file_put_contents($imagePath, file_get_contents($node['display_src']));

                                $newPost->picture = "image/" . $newInstagram->id;

                                $content = $caption;
                                $newPost->message = $content;

                                $newPost->save();


                                $newPostHashTag = new PostHashTag();
                                $newPostHashTag->post_id = $newPost->id;
                                $newPostHashTag->hash_tag_id = $tag->id;
                                $newPostHashTag->save();

                                $newDataExists = true;
                            });
                        }
                    }

                }
            } catch (Exception $e) {
                echo "[Instagram Crawling]에러가 발생했습니다 {$title}\n" . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
            }
        });

        if ($newDataExists) {
            Artisan::call('push:toAll', [
                'message' => "새 글이 등록 됐습니다."
            ]);
        }
    }

    public function getMediaByTag(string $name): array
    {
        $client = new Client([
            'base_uri' => 'https://www.instagram.com',
            'query' => ['__a' => 1],
        ]);
        $response = $client->request('GET', '/explore/tags/' . $name);

        $body = json_decode($response->getBody()->getContents(), true);

        return ($body);
    }


    public static function removeEmoji($text)
    {

        $clean_text = "";

        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $text);

        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);

        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);

        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);

        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);

        return $clean_text;
    }

}
