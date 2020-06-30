<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'link' => ['required', 'url'],
            'custom_alias' => ['nullable', 'string', 'alpha_dash', 'unique:links,hash', 'min:8', 'max:16']
        ]);

        $linkHash = $request->custom_alias ?? Str::random(8);

        $shortLink = Link::create([
            'hash' => $linkHash,
            'link' => $request->link
        ]);

        return response([
            'data' => $shortLink
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Link  $link
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Link $link)
    {
        return redirect($link->link);
    }
}
