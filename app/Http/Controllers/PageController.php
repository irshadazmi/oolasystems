<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Inquiry;
use App\Models\User;
use App\Models\Visitor;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function portfolio()
    {
        return view('pages.portfolio');
    }

    public function industries()
    {
        return view('pages.industries');
    }

    public function tutorial()
    {
        return view('tutorial.index');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function admin()
    {
        return view('admin.dashboard', [
            'contactsCount' => Contact::count(),
            'inquiriesCount' => Inquiry::count(),
            'visitorsCount' => Visitor::count(),
            'usersCount' => User::count(),
        ]);
    }
}
