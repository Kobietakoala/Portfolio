<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }

    // === TESTY DLA NIEAUTORYZOWANEGO DOSTĘPU ===

    public function test_profile_page_requires_authentication(): void
    {
        $response = $this->get('/profile');

        $response->assertRedirect('/login');
    }

    public function test_profile_update_requires_authentication(): void
    {
        $response = $this->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_profile_delete_requires_authentication(): void
    {
        $response = $this->delete('/profile', [
            'password' => 'password',
        ]);

        $response->assertRedirect('/login');
    }

    // === TESTY DLA NIEPRAWIDŁOWYCH DANYCH ===

    public function test_profile_update_requires_name(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => '',
                'email' => 'test@example.com',
            ]);

        $response->assertSessionHasErrors('name');
        $this->assertNotSame('', $user->fresh()->name);
    }

    public function test_profile_update_requires_valid_email(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'invalid-email',
            ]);

        $response->assertSessionHasErrors('email');
        $this->assertNotSame('invalid-email', $user->fresh()->email);
    }

    public function test_profile_update_requires_unique_email(): void
    {
        $existingUser = User::factory()->create([
            'email' => 'existing@example.com'
        ]);
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'existing@example.com',
            ]);

        $response->assertSessionHasErrors('email');
        $this->assertNotSame('existing@example.com', $user->fresh()->email);
    }

    public function test_profile_update_name_cannot_exceed_255_characters(): void
    {
        $user = User::factory()->create();
        $longName = str_repeat('a', 256);

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => $longName,
                'email' => 'test@example.com',
            ]);

        $response->assertSessionHasErrors('name');
        $this->assertNotSame($longName, $user->fresh()->name);
    }

    public function test_profile_update_email_cannot_exceed_255_characters(): void
    {
        $user = User::factory()->create();
        $longEmail = str_repeat('a', 250) . '@example.com'; // > 255 chars

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $longEmail,
            ]);

        $response->assertSessionHasErrors('email');
        $this->assertNotSame($longEmail, $user->fresh()->email);
    }

    public function test_profile_update_email_must_be_lowercase(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'TEST@EXAMPLE.COM',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        // Email powinien być automatycznie przekonwertowany na małe litery
        $this->assertSame('test@example.com', $user->fresh()->email);
    }

    public function test_profile_update_handles_missing_data(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', []);

        $response->assertSessionHasErrors(['name', 'email']);
    }

    public function test_user_can_update_own_profile_only(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Użytkownik nie może aktualizować profilu innego użytkownika
        // (Ten test zakłada, że routes są odpowiednio zabezpieczone)
        $response = $this
            ->actingAs($user1)
            ->patch('/profile', [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
            ]);

        // Sprawdź, że aktualizowany jest profil zalogowanego użytkownika
        $user1->refresh();
        $user2->refresh();

        $this->assertSame('Updated Name', $user1->name);
        $this->assertSame('updated@example.com', $user1->email);
        $this->assertNotSame('Updated Name', $user2->name);
        $this->assertNotSame('updated@example.com', $user2->email);
    }

    public function test_account_deletion_without_password_fails(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', []);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
