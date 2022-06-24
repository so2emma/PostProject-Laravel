<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get('/');

        $response->assertSeeText('Welcome');
        $response->assertSeeText('Welcome to my Blogging App - HOME PAGE');
        $response->assertStatus(200);

    }
    public function testContactPageIsWorkingCorrectly(){
        $response = $this->get('/contact');
        $response->assertSeeText('Hello this is Contact!');

        $response->assertStatus(200);


    }
}
