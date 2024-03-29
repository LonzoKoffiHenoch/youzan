<?php

declare(strict_types=1);

namespace Tests\Browser\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

final class PasswordUpdateTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_password_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('/profile')
                ->waitForText('Update Password')
                ->within('@update-password', function (Browser $browser): void {
                    $browser->type('current_password', 'password')
                        ->type('password', 'new-password')
                        ->type('password_confirmation', 'new-password')
                        ->press('Save')
                        ->waitForText('Saved');
                });
        });

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_correct_password_must_be_provided_to_update_password(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('/profile')
                ->waitForText('Update Password')
                ->within('@update-password', function (Browser $browser): void {
                    $browser->type('current_password', 'wrong-password')
                        ->type('password', 'new-password')
                        ->type('password_confirmation', 'new-password')
                        ->press('Save')
                        ->waitForText('The password is incorrect.');
                });
        });
    }
}
