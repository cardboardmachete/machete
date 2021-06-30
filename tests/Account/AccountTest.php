<?php

namespace Machete\Tests\Account;

use Illuminate\Support\Facades\Auth;
use Machete\Account\Models\Account;
use Machete\Character\Models\Character;
use Machete\Tests\TestCase;

class AccountTest extends TestCase
{
    /** @test */
    public function can_create_account()
    {
        $account = Account::factory()->make();
        $this->assertInstanceOf(Account::class, $account);
    }

    /** @test */
    public function account_is_used_for_auth()
    {
        $account = Account::factory()->make();
        Auth::login($account);
        $this->assertInstanceOf(Account::class, Auth::user());
    }

    /** @test */
    public function has_characters()
    {
        $account = Account::factory()->hasCharacters(1)->create();
        $this->assertInstanceOf(Character::class, $account->characters->first());
    }

    /** @test */
    public function can_have_multiple_characters()
    {
        $account = Account::factory()->hasCharacters(3)->create();
        $this->assertEquals(3, $account->characters()->count());
    }
}
