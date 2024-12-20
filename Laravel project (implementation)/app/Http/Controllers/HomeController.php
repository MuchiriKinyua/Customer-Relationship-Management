<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Interaction;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalClients = Client::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalDepartments = Department::count();
        $totalEmployees = Employee::count();
        $totalInteractions = Interaction::count();

        return view('home', compact('totalClients', 'totalProducts', 'totalOrders','totalDepartments','totalEmployees','totalInteractions'));
    }
}
