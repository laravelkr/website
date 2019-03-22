<?php

namespace App\Http\Controllers;

use App\Services\AllContributors\Contributors;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     * @param Contributors $allContributors
     * @return Factory|View
     */
    public function index(Contributors $allContributors)
    {
        $lastVersion = config('docs.default');

        $contributorsHtml = $allContributors->getHtml();


        return view('index', compact('lastVersion', 'contributorsHtml'));
    }
}
