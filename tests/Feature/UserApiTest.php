<?php

namespace Tests\Feature;
 
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApiTest extends PassportTestCase {

    public function testGetApiUserWithTokenInHeaders() {
        // $this->withoutExceptionHandling();
        $this->get('/api/user', $this->headersWithToken)->assertStatus(200);
    }

    public function testGetApiUserWithOutTokenInHeaders() {
        // $this->withoutExceptionHandling();
        $this->get('/api/user', $this->headersWithoutToken)->assertStatus(401);
    }
}