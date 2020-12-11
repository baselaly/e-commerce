<?php

namespace App\Console\Commands;

use App\Services\CartService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClearCartCommand extends Command
{
    protected $cartService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carts:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Clear Carts That reamins for morethan two days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CartService $cartService)
    {
        parent::__construct();

        $this->cartService = $cartService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            dd('test');
            $carts = $this->cartService->getCartsBy(['created_at' => ['operator' => '<', 'value' => Carbon::now()->subDays(2)]]);
            foreach ($carts as $cart) {
                Log::info('Deleting Cart with ID : ' . $cart->id . ' for product : ' . $cart->product->name);
                $this->cartService->deleteCart($cart);
                Log::info('Deleted');
            }
        } catch (\Throwable$t) {
            Log::info($t->getMessage());
        }
    }
}
