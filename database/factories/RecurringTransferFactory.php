<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\RecurringTransfer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RecurringTransfer>
 */
class RecurringTransferFactory extends Factory
{
    public function definition(): array
    {
        return [
            // 'amount' => fake()->numberBetween(1, 100),
        ];
    }

    public function recipient(string $recipient_email): self
    {
        return $this->state(fn (array $attributes) => [
            'recipient_email' => $recipient_email,
        ]);
    }
}
