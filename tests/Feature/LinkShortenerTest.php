<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LinkShortenerTest extends TestCase
{
    /**
     * Test link shortener and shortened link redirect.
     *
     * @return void
     */
    public function testShortenLink()
    {
        $link = 'https://lbry.tv/@openkoder:a/Rick-Astley---Never-Gonna-Give-You-Up:4';

        $shortenResponse = $this->post(
            route('link.store'),
            compact('link')
        );

        $shortenResponse
            ->assertOk()
            ->assertJson(['data' => [
                'link' => $link
            ]]);

        $hash = $shortenResponse['data']['hash'];

        $redirectResponse = $this->get(
            route('link.show', $hash)
        );

        $redirectResponse
            ->assertRedirect($link);
    }
}
