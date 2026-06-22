# Architecture Notes

TravelHub keeps HTTP controllers thin and places operational workflows in `app/Services/Admin`. Phase 3/4 agent booking, wallet, allocation, reporting, media, settings, and check-in logic reuse Eloquent relationships and database transactions. API controllers reuse the same services as admin web controllers.
