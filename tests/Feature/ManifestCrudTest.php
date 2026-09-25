<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Inventory;

class ManifestCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_manifest_reduces_stock()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $inv = Inventory::create([
            'nama_alat' => 'Test Speaker',
            'kategori' => 'Audio',
            'stok_tersedia' => 5,
            'kondisi_alat' => 'Baik',
            'foto_alat' => '-',
            'deskripsi' => '-'
        ]);

        $payload = [
            'klien_event' => 'ACME',
            'tanggal_loading' => now()->toDateString(),
            'crew_chief' => 'John',
            'inventory_ids' => [$inv->id],
            'quantities' => [2],
            'manual_names' => [],
            'manual_qtys' => [],
            'catatan' => ''
        ];

        $resp = $this->post('/admin/manifes', $payload);
        $resp->assertRedirect('/dashboard');

        $this->assertDatabaseHas('inventories', [
            'id' => $inv->id,
            'stok_tersedia' => 3
        ]);
    }

    public function test_update_manifest_adjusts_stock()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $inv = Inventory::create([
            'nama_alat' => 'Test Lamp',
            'kategori' => 'Lighting',
            'stok_tersedia' => 10,
            'kondisi_alat' => 'Baik',
            'foto_alat' => '-',
            'deskripsi' => '-'
        ]);

        // Create manifest with qty 3
        $payload = [
            'klien_event' => 'ACME',
            'tanggal_loading' => now()->toDateString(),
            'crew_chief' => 'John',
            'inventory_ids' => [$inv->id],
            'quantities' => [3],
            'manual_names' => [],
            'manual_qtys' => [],
            'catatan' => ''
        ];
        $this->post('/admin/manifes', $payload)->assertRedirect('/dashboard');

        $inv->refresh();
        $this->assertEquals(7, $inv->stok_tersedia);

        // Find manifest id
        $manifestId = \App\Models\Manifest::first()->id;

        // Update manifest to qty 1 (should restore 3 then decrement 1 => + -2 net)
        $updatePayload = [
            'klien_event' => 'ACME',
            'tanggal_loading' => now()->toDateString(),
            'crew_chief' => 'John',
            'inventory_ids' => [$inv->id],
            'quantities' => [1],
            'manual_names' => [],
            'manual_qtys' => [],
            'catatan' => ''
        ];

        $this->post('/admin/manifes/update/' . $manifestId, $updatePayload)->assertRedirect('/dashboard');
        $inv->refresh();
        $this->assertEquals(9, $inv->stok_tersedia);
    }

    public function test_delete_manifest_restores_stock()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $inv = Inventory::create([
            'nama_alat' => 'Test Mic',
            'kategori' => 'Audio',
            'stok_tersedia' => 4,
            'kondisi_alat' => 'Baik',
            'foto_alat' => '-',
            'deskripsi' => '-'
        ]);

        $payload = [
            'klien_event' => 'ACME',
            'tanggal_loading' => now()->toDateString(),
            'crew_chief' => 'John',
            'inventory_ids' => [$inv->id],
            'quantities' => [2],
            'manual_names' => [],
            'manual_qtys' => [],
            'catatan' => ''
        ];

        $this->post('/admin/manifes', $payload)->assertRedirect('/dashboard');
        $inv->refresh();
        $this->assertEquals(2, $inv->stok_tersedia);

        $manifestId = \App\Models\Manifest::first()->id;
        $this->delete('/admin/manifes/delete/' . $manifestId)->assertRedirect('/dashboard');

        $inv->refresh();
        $this->assertEquals(4, $inv->stok_tersedia);
    }

    public function test_return_manifest_increments_stock_and_sets_status()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $inv = Inventory::create([
            'nama_alat' => 'Test Cable',
            'kategori' => 'Accessory',
            'stok_tersedia' => 6,
            'kondisi_alat' => 'Baik',
            'foto_alat' => '-',
            'deskripsi' => '-'
        ]);

        $payload = [
            'klien_event' => 'ACME',
            'tanggal_loading' => now()->toDateString(),
            'crew_chief' => 'John',
            'inventory_ids' => [$inv->id],
            'quantities' => [2],
            'manual_names' => [],
            'manual_qtys' => [],
            'catatan' => ''
        ];

        $this->post('/admin/manifes', $payload)->assertRedirect('/dashboard');
        $inv->refresh();
        $this->assertEquals(4, $inv->stok_tersedia);

        $manifestId = \App\Models\Manifest::first()->id;
        $this->post('/admin/manifes/return/' . $manifestId)->assertRedirect('/dashboard');

        $inv->refresh();
        $this->assertEquals(6, $inv->stok_tersedia);

        $this->assertDatabaseHas('manifests', ['id' => $manifestId, 'status' => 'Alat Kembali']);
    }
}
