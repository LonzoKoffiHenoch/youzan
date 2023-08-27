<?php

declare(strict_types=1);

namespace Tests\Browser\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

final class AuthenticationTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_login_screen_can_be_rendered(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser->logout()
                ->visit('/login')
                ->waitForInput('email')
                ->assertInputPresent('email')
                ->assertInputPresent('password');
        });
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $this->browse(function (Browser $browser): void {
            $user = User::factory()->create();

            $browser->logout()
                ->visit('/login')
                ->waitForInput('email')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Log in')
                ->waitForLocation(RouteServiceProvider::HOME)
                ->assertAuthenticatedAs($user);
        });
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $this->browse(function (Browser $browser): void {
            $user = User::factory()->create();

            $browser->logout()
                ->visit('/login')
                ->waitForInput('email')
                ->type('email', $user->email)
                ->type('password', 'wrong-password')
                ->press('Log in')
                ->waitForText('These credentials do not match our records.')
                ->assertGuest();
        });
    }
}
