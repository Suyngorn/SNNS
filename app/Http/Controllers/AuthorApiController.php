<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorApiController extends Controller
{
    //

    public function index(Request $request)
    {
        $search_term = $request->input('q');

        if ($search_term)
        {
            $results = Author::where('name', 'LIKE', '%'.$search_term.'%')->paginate(10);
        }
        else
        {
            $results = Author::paginate(10);
        }

        return $results;
    }
}
