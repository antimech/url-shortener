<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            'custom_alias' => ['nullable', 'string', 'alpha_dash', 'unique:links,hash', 'min:8', 'max:16'],
            'expired_at' => ['nullable', 'date']
        ]);

        $linkHash = $request->custom_alias ?? Str::random(8);

        $shortLink = Link::create([
            'hash' => $linkHash,
            'link' => $request->link,
            'expired_at' => $request->expired_at
        ]);

        return response([
            'data' => $shortLink
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Link  $link
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function show(Link $link)
    {
        if ($link->expired_at && Carbon::now() >= $link->expired_at) {
            throw new NotFoundHttpException();
        }

        return redirect($link->link);
    }
}
