<?php

namespace App\Console\Commands;

use App\Models\Plan;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Stripe\Exception\ApiErrorException;

class PlansSyncProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plans:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Stripe products for available plans';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // look all active plans and create products for them if they don't have one
        // then update the product id in the plans table

        foreach (Plan::query()->get() as $plan) {
            try {
                $product = Cashier::stripe()->products->create(array_filter([
                    'name' => $plan->name,
                    'description' => $plan->description,
                    'marketing_features' => collect($plan->features)->map(fn ($feature) => ['name' => $feature])->toArray(),
                    'active' => $plan->active,
                    // 'tax_code' => '?', // replace with your tax code
                    // 'images' => ['image_url']
                    // 'unit_label' => 'seat', // e.g. seat, user, etc.
                    'metadata' => [
                        'plan_id' => $plan->id,
                        'created_by' => config('app.name'),
                    ],
                ]));

                $plan->stripe_product_id = $product->id;
                $plan->save();
                $this->info("Created Stripe product for plan {$plan->name}: {$product->id}");
            } catch (ApiErrorException $e) {
                $this->error("Error creating product for plan {$plan->name}: {$e->getMessage()}");
                continue;
            }

            ///////////////////////////////////////////////
            /////////////// create prices... //////////////
            ///////////////////////////////////////////////

            foreach ($plan->prices as $price) {
                try {
                    $newPrice = Cashier::stripe()->prices->create(array_filter([
                        'product' => $product->id,
                        'nickname' => $price->name,
                        'currency' => $price->currency,
                        'unit_amount' => $price->amount * 100, // amount in cents
                        // 'billing_scheme' => 'per_unit', // per_unit or tiered (we only support per_unit for now)
                        'recurring' => $price->interval ? [
                            'interval' => $price->interval,
                            'interval_count' => $price->interval_count,
                            // 'usage_type' => 'licensed', // metered or licensed
                            // 'meter' => 'The meter tracking the usage of a metered price'
                        ] : null,
                        'tax_behavior' => 'exclusive',
                        'active' => $price->active,
                        'metadata' => [
                            'plan_id' => $plan->id,
                            'plan_price_id' => $price->id,
                            'created_by' => config('app.name'),
                        ],
                    ]));

                    $price->stripe_price_id = $newPrice->id;
                    $price->save();
                    $this->info("  Created price: {$newPrice->id}");
                } catch (ApiErrorException $ex) {
                    $this->error("  Error creating price for plan {$plan->name}: {$ex->getMessage()}");
                }
            }

            $this->newLine();
        }

        return self::SUCCESS;
    }
}
