<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\Term;

class ModController extends Controller
{
    public function termsPageView(){

        $terms = Term::all();

        return view('pages.terms', ['terms'=>$terms]);
    }

    public function addTerm(Request $request){

        if ($request->term == null)
            return back()->with('alert', 'Nothing entered');

        Term::create([
            'term' => $request->term
        ]);

        return back()->with('status', 'Term/requlation successfully added');
    }

    public function editTerm(Term $term, Request $request){

        $term->update([
            'term' => $request->term
        ]);

        return back()->with('status', 'Term/requlation successfully edited');
    }

    public function deleteTerm(Term $term){

        $term->delete();

        return back()->with('status', 'Term/requlation successfully deleted');
    }
}
