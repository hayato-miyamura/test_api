<?php

namespace Tests;

use Tests\TestCase;
use App\User;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class PassportTestCase extends TestCase {

    use DatabaseTransactions;

    protected $headersWithToken = [];
    protected $headersWithoutToken = [];
    protected $scopes = [];
    protected $user;

    public function setUp(): void {

        parent::setUp();

        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null, 'TestPersonalAccessClient', url('/')
        );
        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime,
        ]);

        $this->user = factory(User::class)->create();
        $token = $this->user->createToken('TestToken', $this->scopes)->accessToken;

        $this->headersWithToken['Accept'] = 'application/json';
        $this->headersWithToken['Authorization'] = 'Bearer '.$token;
 
        $this->headersWithoutToken['Accept'] = 'application/json';
    }
}