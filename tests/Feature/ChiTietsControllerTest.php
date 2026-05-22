<?php

namespace Tests\Feature;

use App\Models\ChiTietHangHoa;
use App\Models\ThongBaoXuatHang;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChiTietsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_chi_tiet_hang_hoa_with_start_serial_and_num_serial(): void
    {
        // 1. Create a user and authenticate
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        // 2. Create ThongBaoXuatHang
        $thongBao = ThongBaoXuatHang::create([
            'loai_hang' => 'Sample',
            'so_luong' => 100,
        ]);

        // 3. Create ChiTietHangHoa
        $chiTiet = ChiTietHangHoa::create([
            'thong_bao_xuat_hang_id' => $thongBao->id,
            'model' => 'Old Model',
            'size' => 'Old Size',
        ]);

        // 4. Send PUT request to update
        $response = $this->put(route('chi-tiets.update', $chiTiet->id), [
            'model' => 'New Model',
            'size' => 'New Size',
            'start_serial' => '100',
            'num_serial' => 10,
        ]);

        // 5. Assert redirect and changes
        $response->assertRedirect(route('chi-tiets.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('chi_tiet_hang_hoas', [
            'id' => $chiTiet->id,
            'model' => 'New Model',
            'size' => 'New Size',
        ]);

        // Assert container was created/updated correctly
        $this->assertDatabaseHas('containers', [
            'chi_tiet_hang_hoa_id' => $chiTiet->id,
            'tu' => '100',
            'so_luong' => 10,
            'den' => '109', // 100 + 10 - 1
        ]);
    }

    public function test_can_update_chi_tiet_hang_hoa_with_alphanumeric_start_serial(): void
    {
        // 1. Create user and authenticate
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($user);

        // 2. Create ThongBaoXuatHang
        $thongBao = ThongBaoXuatHang::create([
            'loai_hang' => 'Sample',
            'so_luong' => 100,
        ]);

        // 3. Create ChiTietHangHoa
        $chiTiet = ChiTietHangHoa::create([
            'thong_bao_xuat_hang_id' => $thongBao->id,
            'model' => 'Old Model',
        ]);

        // 4. Send PUT request with alphanumeric start_serial
        $response = $this->put(route('chi-tiets.update', $chiTiet->id), [
            'model' => 'New Model',
            'start_serial' => 'A100',
            'num_serial' => 5,
        ]);

        // 5. Assert redirect and database changes
        $response->assertRedirect(route('chi-tiets.index'));

        // Since start_serial is alphanumeric, den should fall back to start_serial (A100)
        $this->assertDatabaseHas('containers', [
            'chi_tiet_hang_hoa_id' => $chiTiet->id,
            'tu' => 'A100',
            'so_luong' => 5,
            'den' => 'A100',
        ]);
    }
}
