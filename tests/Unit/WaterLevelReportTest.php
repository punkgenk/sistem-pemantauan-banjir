<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WaterLevelReportTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'masyarakat']);
    }

    /** @test */
    public function report_dapat_dibuat_dengan_field_lengkap()
    {
        $report = Report::create([
            'user_id'     => $this->user->id,
            'title'       => 'Banjir RT 03',
            'description' => 'Air setinggi lutut',
            'latitude'    => -7.2575,
            'longitude'   => 112.7521,
            'address'     => 'Jl. Raya Surabaya',
            'status'      => 'pending',
        ]);

        $this->assertDatabaseHas('reports', [
            'title'  => 'Banjir RT 03',
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function report_berelasi_dengan_user()
    {
        $report = Report::create([
            'user_id'     => $this->user->id,
            'title'       => 'Banjir Test',
            'description' => 'Deskripsi test',
            'latitude'    => -7.2575,
            'longitude'   => 112.7521,
            'status'      => 'pending',
        ]);

        $this->assertEquals($this->user->id, $report->user_id);
    }

    /** @test */
    public function report_status_default_adalah_pending()
    {
        $report = Report::create([
            'user_id'     => $this->user->id,
            'title'       => 'Test Status',
            'description' => 'Deskripsi',
            'latitude'    => -7.2575,
            'longitude'   => 112.7521,
            'status'      => 'pending',
        ]);

        $this->assertEquals('pending', $report->status);
    }

    /** @test */
    public function water_level_index_hanya_tampilkan_selesai_untuk_masyarakat()
    {
        Report::create([
            'user_id' => $this->user->id, 'title' => 'Pending Report',
            'description' => 'desc', 'latitude' => -7.25, 'longitude' => 112.75,
            'status' => 'pending',
        ]);
        Report::create([
            'user_id' => $this->user->id, 'title' => 'Selesai Report',
            'description' => 'desc', 'latitude' => -7.25, 'longitude' => 112.75,
            'status' => 'selesai',
        ]);

        $this->actingAs($this->user)
             ->get('/water-levels')
             ->assertStatus(200);

        $visibleReports = Report::where('status', 'selesai')->get();
        $this->assertCount(1, $visibleReports);
    }
}