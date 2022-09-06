<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feed;

class RSSFeed extends Controller
{
    public function view(Request $request) {
        $feed_data = Feed::all();

        return view('feed', ['feed_data' => $feed_data]);
    }
}
