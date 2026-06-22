<?php
namespace Database\Factories;
use App\Models\Agent; use Illuminate\Database\Eloquent\Factories\Factory;
class AgentFactory extends Factory { protected $model=Agent::class; public function definition(): array { return ['name'=>$this->faker->name(),'company'=>$this->faker->company(),'credit_balance'=>$this->faker->numberBetween(1000,10000),'contact'=>$this->faker->phoneNumber(),'email'=>$this->faker->companyEmail(),'status'=>'active']; } }
