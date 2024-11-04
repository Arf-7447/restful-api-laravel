<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Student;

class StudentApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_student()
    {
        $response = $this->postJson('/api/students', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '081234567890',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Student successfully created',
                 ]);
    }

    /** @test */
    public function it_can_fetch_all_students()
    {
        Student::factory()->count(5)->create();

        $response = $this->getJson('/api/students');

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function it_can_fetch_single_student()
    {
        $student = Student::factory()->create();

        $response = $this->getJson("/api/students/{$student->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.id', $student->id);
    }

    /** @test */
    public function it_can_update_a_student()
    {
        $student = Student::factory()->create();

        $response = $this->putJson("/api/students/{$student->id}", [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '081234567891',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Student successfully updated',
                 ]);
    }

    /** @test */
    public function it_can_delete_a_student()
    {
        $student = Student::factory()->create();

        $response = $this->deleteJson("/api/students/{$student->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Student successfully deleted',
                 ]);
    }
}
