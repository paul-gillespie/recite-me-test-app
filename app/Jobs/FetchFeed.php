<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Feed;
use Carbon\Carbon;

class FetchFeed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rss_feed_url = env("RSS_FEED_URL");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $rss_feed_url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $output = curl_exec($ch);

        curl_close($ch);

        $feed_xml_obj = new \SimpleXMLElement($output);

        foreach($feed_xml_obj->channel->item as $item) {

            // Check if item already exists
            $users = Feed::select('*')->where('guid', '=', $item->guid)->get();

            if(count($users) == 0) {
                Feed::insert([
                    'title' => $item->title,
                    'link' => $item->link,
                    'description' => $item->description,
                    'pubdate' => $item->pubDate,
                    'guid' => $item->guid,
                    'image' => $item->enclosure->attributes()->url,
                    'created_at' => Carbon::now()
                ]);
            }
        }

        return(true);
    }
}
