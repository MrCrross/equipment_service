<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Orders\EquipmentOrder;
use App\Models\User;
use App\Models\Equipment\Equipment;
use Illuminate\Foundation\Testing\WithFaker;

class OrdersControllerTest extends TestCase
{
    use WithFaker;

    public function test_guest_cannot_access_orders()
    {
        $response = $this->get(route('orders.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_view_orders_index()
    {
        $user = User::factory()->create();
        $user->syncPermissions(['equipment_orders_view']);

        $response = $this
            ->actingAs($user)
            ->get(route('orders.index'));

        $response->assertStatus(200);
        $response->assertViewIs('orders.index');
    }

    public function test_user_can_create_order()
    {
        $user = User::factory()->create();
        $user->syncPermissions(['equipment_orders_create']);

        $equipment = Equipment::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('orders.store'), [
                'description' => 'Test Order',
                'price' => 100,
                'equipment_id' => $equipment->id,
            ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('equipment_orders', [
            'description' => 'Test Order',
            'price' => 100,
            'equipment_id' => $equipment->id,
            'client_id' => $user->id,
        ]);
    }

    public function test_user_can_update_order()
    {
        $user = User::factory()->create();
        $user->syncPermissions(['equipment_orders_view', 'equipment_orders_edit']);
        $order = EquipmentOrder::factory()->create();
        $equipment = Equipment::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put(route('orders.update', $order->id), [
                'description' => 'Updated Order',
                'price' => 150,
                'equipment_id' => $equipment->id,
                'status_code' => 'draft',
            ]);

        $response->assertRedirect(route('orders.index'));
        $this->assertDatabaseHas('equipment_orders', [
            'id' => $order->id,
            'description' => 'Updated Order',
            'price' => 150,
            'equipment_id' => $equipment->id,
        ]);
    }

    public function test_user_can_delete_order()
    {
        $user = User::factory()->create();
        $user->syncPermissions(['equipment_orders_view', 'equipment_orders_edit']);
        $order = EquipmentOrder::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('orders.destroy', $order->id));

        $response->assertRedirect(route('orders.index'));
        $this->assertSoftDeleted('equipment_orders', ['id' => $order->id]);
    }

    public function test_user_can_recover_order()
    {
        $user = User::factory()->create();
        $user->syncPermissions(['equipment_orders_view', 'equipment_orders_edit']);
        $order = EquipmentOrder::factory()->create();
        $order->delete();

        $response = $this
            ->actingAs($user)
            ->patch(route('orders.recovery', $order->id));

        $response->assertRedirect(route('orders.show', $order->id));
        $this->assertDatabaseHas('equipment_orders', [
            'id' => $order->id,
            'deleted_at' => null,
            'status_code' => 'draft',
        ]);
    }

    public function test_user_can_view_single_order()
    {
        $user = User::factory()->create();
        $user->syncPermissions(['equipment_orders_view', 'equipment_orders_view-delete']);
        $order = EquipmentOrder::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('orders.show', $order->id));

        $response->assertStatus(200);
        $response->assertViewIs('orders.show');
        $response->assertViewHas('order', $order);
    }
}
