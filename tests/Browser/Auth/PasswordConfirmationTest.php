<?php

declare(strict_types=1);

namespace Tests\Browser\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

final class PasswordConfirmationTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_confirm_password_screen_can_be_rendered(): void
    {
        $this->browse(function (Browser $browser): void {
            $user = User::factory()->create();

            $browser->loginAs($user)
                ->visit('/confirm-password')
                ->waitForText('Please confirm your password before continuing.')
                ->assertInputPresent('password');
        });
    }

    public function test_password_can_be_confirmed(): void
    {
        $this->browse(function (Browser $browser): void {
            $user = User::factory()->create();

            $browser->loginAs($user)
                ->visit('/confirm-password')
                ->waitForText('Please confirm your password before continuing.')
                ->type('password', 'password')
                ->press('Confirm')
                ->waitForLocation(RouteServiceProvider::HOME)
                ->assertPathIs(RouteServiceProvider::HOME);
        });
    }

    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        $this->browse(function (Browser $browser): void {
            $user = User::factory()->create();

            $browser->loginAs($user)
                ->visit('/confirm-password')
                ->waitForText('Please confirm your password before continuing.')
                ->type('password', 'wrong-password')
                ->press('Confirm')
                ->waitForText('The provided password is incorrect.')
                ->assertPathIs('/confirm-password');
        });
    }
}
