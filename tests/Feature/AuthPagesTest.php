<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthPagesTest extends TestCase
{
    /**
     * Test that the /login route returns a successful response and contains the login form.
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Welcome Back'); // Text from the login form
        $response->assertSee('Login to manage your bookings'); // Another text from login form
    }

    /**
     * Test that the /signup route returns a successful response and contains the registration form.
     */
    public function test_signup_page_is_accessible(): void
    {
        $response = $this->get('/signup');

        $response->assertStatus(200);
        $response->assertSee('Create Account'); // Text from the register form
        $response->assertSee('Join Serviqo today'); // Another text from register form
    }

    /**
     * Test that the home page initially shows login/signup links and no profile icon.
     */
    public function test_home_page_shows_login_signup_links_when_not_logged_in(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<a href="/login"', false);
        $response->assertSee('<a href="/signup"', false);
        $response->assertDontSee('<a href="/profile"', false); // Ensure profile is not visible
    }

    /**
     * Test that the home page shows profile icon and hides login/signup links when logged in.
     */
    public function test_home_page_shows_profile_icon_when_logged_in(): void
    {
        $response = $this->withSession(['logged_in' => true])->get('/');

        $response->assertStatus(200);
        $response->assertSee('<a href="/profile"', false);
        $response->assertDontSee('<a href="/login"', false); // Ensure login is not visible
        $response->assertDontSee('<a href="/signup"', false); // Ensure signup is not visible
    }
}
