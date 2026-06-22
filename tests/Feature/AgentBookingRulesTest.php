<?php
namespace Tests\Feature;
use Tests\TestCase;
class AgentBookingRulesTest extends TestCase { public function test_agent_booking_rule_endpoint_requires_authentication(): void { $this->getJson('/api/bookings')->assertStatus(401); } }
