<?php

namespace Tests\Unit\Listeners;

use App\Cart\Cart;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderPaymentFailed;
use App\Listeners\Order\EmptyCart;
use App\Listeners\Order\MarkOrderPaymentFailed;
use App\Listeners\Order\MarkOrderProcessing;
use App\Models\Order;
use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MarkOrderProcessingListenerTest extends TestCase
{
    public function test_it_marks_order_as_processing()
    {
        $event = new OrderPaid(
            $order = factory(Order::class)->create([
                'user_id' => factory(User::class)->create()
            ])
        );

        $listener = new MarkOrderProcessing();

        $listener->handle($event);

        $this->assertEquals($order->fresh()->status, Order::PROCESSING);
    }
}
