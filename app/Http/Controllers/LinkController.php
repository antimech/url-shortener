<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLinkRequest $request): Response
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
     */
    public function show(Link $link): RedirectResponse
    {
        if ($link->expired_at && Carbon::now() >= $link->expired_at) {
            throw new NotFoundHttpException();
        }

        return redirect($link->link);
    }
}
