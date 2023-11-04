<?php

namespace Tests\Feature;

use Carbon\Carbon;
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
     * Test link shortener with custom alias and shortened link redirect.
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

    /**
     * Test link shortener, shortened link redirect and expiration.
     *
     * @return void
     */
    public function testShortenLinkWithExpirationDate()
    {
        $this->setNow(2020, 1, 1);

        $requestData = [
            'link' => $this->longLink,
            'expired_at' => '2020-01-02'
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

        $this->setNow(2020, 1, 2);

        $redirectResponse = $this->get(
            route('link.show', $hash)
        );

        $redirectResponse
            ->assertNotFound();
    }

    /**
     * Allows to rewind the time and remake the world.
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @return $this
     */
    protected function setNow(int $year, int $month, int $day)
    {
        $newNow = Carbon::create($year, $month, $day)->startOfDay();

        Carbon::setTestNow($newNow);

        return $this;
    }
}
