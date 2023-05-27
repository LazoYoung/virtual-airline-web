<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class ForumController extends Controller {
    public function browseView(): Response {
        return Inertia::render('Forum/Browse');
    }
}
