<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_is_returning_index_page_for_any_web_route(): void
    {
        $response = $this->get('/shgdks/sgsgs/ds3/2');

        $response->assertOk()
            ->assertViewMissing('index');
    }
}
