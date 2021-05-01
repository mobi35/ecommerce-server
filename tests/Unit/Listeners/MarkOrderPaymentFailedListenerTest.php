<?php

namespace Tests\Unit\Listeners;

use App\Cart\Cart;
use App\Events\Order\OrderPaymentFailed;
use App\Listeners\Order\EmptyCart;
use App\Listeners\Order\MarkOrderPaymentFailed;
use App\Models\Order;
use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MarkOrderPaymentFailedListenerTest extends TestCase
{
    public function test_it_marks_order_as_payment_failed()
    {
        $event = new OrderPaymentFailed(
            $order = factory(Order::class)->create([
                'user_id' => factory(User::class)->create()
            ])
        );

        $listener = new MarkOrderPaymentFailed();

        $listener->handle($event);

        $this->assertEquals($order->fresh()->status, Order::PAYMENT_FAILED);
    }
}
