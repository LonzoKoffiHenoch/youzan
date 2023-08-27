<?php

declare(strict_types=1);

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

final class ProfileTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_profile_page_is_displayed(): void
    {
        $this->browse(function (Browser $browser): void {
            $user = User::factory()->create();

            $browser->loginAs($user)
                ->visit('/profile')
                ->waitForText('Profile Information')
                ->assertInputPresent('current_password');
        });
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('/profile')
                ->waitForText('Profile Information')
                ->within('@update-profile-information', function (Browser $browser): void {
                    $browser->type('name', 'Test User')
                        ->type('email', 'test@example.com')
                        ->press('Save')
                        ->waitForText('Saved');
                });
        });

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('/profile')
                ->waitForText('Profile Information')
                ->within('@update-profile-information', function (Browser $browser) use ($user): void {
                    $browser->type('name', 'Test User')
                        ->type('email', $user->email)
                        ->press('Save')
                        ->waitForText('Saved');
                });
        });

        $user->refresh();

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('/profile')
                ->waitForText('Delete Account')
                ->scrollTo('@delete-user')
                ->press('Delete Account')
                ->waitForText('Are you sure you want to delete your account?')
                ->within('#headlessui-portal-root', function (Browser $browser): void {
                    $browser
                        ->type('password', 'wrong_password')
                        ->press('Delete Account')
                        ->waitForText('The provided password is incorrect.')
                        ->type('password', 'password')
                        ->press('Delete Account')
                        ->waitForLocation('/')
                        ->assertGuest();
                });
        });

        $this->assertNull($user->fresh());
    }
}
