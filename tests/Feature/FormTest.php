<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Coupon;
use App\Models\PersonalInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the form page displays with cities.
     */
    public function test_form_page_displays(): void
    {
        $response = $this->get('/formular');
        $response->assertStatus(200);
        $response->assertViewHas('cities');
    }

    /**
     * Test that form submission with city_id is accepted.
     */
    public function test_form_submission_with_city(): void
    {
        $city = City::first();
        
        $response = $this->post('/formular', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '123456789',
            'sex' => 'M',
            'city_id' => $city->id,
            'message' => 'Test message',
            'gdpr_consent' => '1',
        ]);

        $response->assertRedirect();
        
        $personalInfo = PersonalInformation::where('email', 'test@example.com')->first();
        $this->assertNotNull($personalInfo);
        $this->assertEquals($city->id, $personalInfo->city_id);
        
        $coupon = Coupon::where('email', 'test@example.com')->first();
        $this->assertNotNull($coupon);
    }

    /**
     * Test that form submission without city_id is still accepted (optional field).
     */
    public function test_form_submission_without_city(): void
    {
        $response = $this->post('/formular', [
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'phone' => '123456789',
            'sex' => 'F',
            'city_id' => null,
            'message' => 'Test message',
            'gdpr_consent' => '1',
        ]);

        $response->assertRedirect();
        
        $personalInfo = PersonalInformation::where('email', 'test2@example.com')->first();
        $this->assertNotNull($personalInfo);
        $this->assertNull($personalInfo->city_id);
    }

    /**
     * Test that form submission with invalid city_id is rejected.
     */
    public function test_form_submission_with_invalid_city(): void
    {
        $response = $this->post('/formular', [
            'name' => 'Test User 3',
            'email' => 'test3@example.com',
            'phone' => '123456789',
            'sex' => 'M',
            'city_id' => 9999, // Invalid city ID
            'message' => 'Test message',
            'gdpr_consent' => '1',
        ]);

        $response->assertSessionHasErrors('city_id');
    }
}
