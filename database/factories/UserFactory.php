<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Convert the number in indian format.
     *
     * @return string
     */
    public function convertToIndianFormat($number)
    {
        $number = str_replace('-', '', $number);
        $number = str_replace('.', '', $number);
        $number = str_replace('(', '', $number);
        $number = str_replace(')', '', $number);
        $number = str_replace('+', '', $number);
        $number = str_replace(' ', '', $number);

        return strlen($number) > 10 ? substr($number, 0, 9) : $number;
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = ['Active', 'InActive'];

        return [
            'name' => $this->faker->name(),
            'phone' => $this->convertToIndianFormat($this->faker->phoneNumber()),
            'email' => 'user_'. bin2hex(random_bytes(16)) . '@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'remember_token' => null,
            'status' => $status[rand(0, 1)],
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
