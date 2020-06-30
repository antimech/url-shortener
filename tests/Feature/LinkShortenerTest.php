<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LinkShortenerTest extends TestCase
{
    use RefreshDatabase;

    private $longLink;

    protected function setUp(): void
    {
        parent::setUp();

        $this->longLink = 'https://lbry.tv/@openkoder:a/Rick-Astley---Never-Gonna-Give-You-Up:4';
    }

    /**
     * Test link shortener and shortened link redirect.
     *
     * @return void
     */
    public function testShortenLink()
    {
        $requestData = [
            'link' => $this->longLink
        ];

        $shortenResponse = $this->post(
            route('link.store'),
            $requestData
        );

        $shortenResponse
            ->assertOk()
            ->assertJson(['data' => [
                'link' => $this->longLink
            ]]);

        $hash = $shortenResponse['data']['hash'];

        $this->assertDatabaseHas('links', [
            'hash' => $hash,
            'link' => $this->longLink
        ]);

        $redirectResponse = $this->get(
            route('link.show', $hash)
        );

        $redirectResponse
            ->assertRedirect($this->longLink);
    }

    /**
     * Test link shortener with custom aliast and shortened link redirect.
     *
     * @return void
     */
    public function testShortenLinkWithCustomAlias()
    {
        $requestData = [
            'link' => $this->longLink,
            'custom_alias' => 'my-cool-link-777'
        ];

        $shortenResponse = $this->post(
            route('link.store'),
            $requestData
        );

        $shortenResponse
            ->assertOk()
            ->assertJson(['data' => [
                'hash' => $requestData['custom_alias'],
                'link' => $this->longLink,
            ]]);

        $this->assertDatabaseHas('links', [
            'hash' => $requestData['custom_alias'],
            'link' => $this->longLink
        ]);

        $redirectResponse = $this->get(
            route('link.show', $requestData['custom_alias'])
        );

        $redirectResponse
            ->assertRedirect($this->longLink);
    }
}
