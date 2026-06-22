# Database Diagram

Core flow: `agents` -> `agent_route_assignments` -> `travel_routes` -> `travel_schedules` -> `bookings` -> `booking_seat` -> `seats`. Wallet entries live in `agent_wallet_transactions`; check-in records live in `check_ins`; uploads live in `media_assets`; enterprise preferences live in `system_settings`; API tokens live in `personal_access_tokens`.
