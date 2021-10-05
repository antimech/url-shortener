<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Link;
use App\Services\LinkService;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLinkRequest $request)
    {
        $linkHash = $request->custom_alias ?? LinkService::generateRandomUniqueHash();

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
