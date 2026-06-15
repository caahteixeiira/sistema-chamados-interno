<?php

namespace Database\Factories;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Responsible;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'priority' => fake()->randomElement([
                TicketPriority::LOW->value,
                TicketPriority::MEDIUM->value,
                TicketPriority::HIGH->value,
            ]),
            'status' => TicketStatus::OPEN->value,
            'responsible_id' => Responsible::factory(),
            'opened_at' => now(),
        ];
    }
}