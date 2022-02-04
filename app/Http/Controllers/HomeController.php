<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Services\AllContributors\Contributors;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function index(Contributors $allContributors): View
    {
        $lastVersion = config('docs.default');

        $contributorsHtml = $allContributors->getHtml();

        $notices = Notice::getAll();

        return view('index', compact('lastVersion', 'contributorsHtml', 'notices'));
    }
}
