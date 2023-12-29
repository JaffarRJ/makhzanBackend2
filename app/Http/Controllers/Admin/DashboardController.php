<?php

namespace App\Http\Controllers\Admin;
use App\Models\Dashboard;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
//use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    private $pagination, $model;

    public function __construct()
    {
        $this->model = new Dashboard();
        $this->pagination = request('page_size') ? request('page_size') : PAGINATE;
    }
    public function dashboard()
    {
        return view('dashboard.dashboard');
    }
    public function setLocale($locale)
    {
        if (in_array($locale, ['en', 'ur'])) {
            App::setLocale($locale);
        }

        return redirect()->back();
    }
}
