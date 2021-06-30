<?php

namespace Machete\Tests\Character;

use Illuminate\Support\Facades\Auth;
use Machete\Account\Models\Account;
use Machete\Character\Models\ActiveCharacter;
use Machete\Character\Models\Character;
use Machete\Tests\TestCase;

class CharacterTest extends TestCase
{
    /** @test */
    public function can_create_character()
    {
        $character = Character::factory()->make();
        $this->assertInstanceOf(Character::class, $character);
    }

    /** @test */
    public function has_one_account()
    {
        $character = Character::factory()->make();
        $this->assertInstanceOf(Account::class, $character->account);
    }

    /** @test */
    public function gets_active_character()
    {
        $account = Account::factory()->create();
        Auth::login($account);
        Character::factory()->for($account)->create();

        // Creates an inactive character
        Character::factory()->for($account)->inactive()->create();

        $character = ActiveCharacter::first();
        $this->assertInstanceOf(Character::class, $character);
    }

    /** @test */
    public function only_gets_active_characters()
    {
        $account = Account::factory()->create();
        Auth::login($account);
        Character::factory()->for($account)->create();

        // Creates an inactive character
        Character::factory()->for($account)->inactive()->create();

        $charCount = ActiveCharacter::count();
        $this->assertEquals(1, $charCount);
    }
}
