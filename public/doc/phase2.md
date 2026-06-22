# TravelHub ERP - Phase 2 (Booking Engine)

Read CRUD.md first.

Read the existing project.

Continue from Phase 1.

Implement ONLY the Booking Engine.

--------------------------------

MODULES

Routes

Route Stops

Route Charges

Travel Schedule

Seat Layout

Seat Configuration

--------------------------------

Booking System

Create Booking

Passenger Details

Travel Date

Route Selection

Seat Selection

Temporary Seat Hold

Booking Confirmation

Return Booking

Booking History

--------------------------------

Passenger Information

- First Name
- Last Name
- Gender
- DOB
- Nationality
- Passport
- National ID
- Contact Number

--------------------------------

PNR Generator

Generate unique booking reference.

Must be handled inside a dedicated service.

--------------------------------

QR Code

Generate QR Code for every booking.

--------------------------------

Seat Engine

Features

- Seat Layout
- Seat Availability
- Seat Conflict Validation
- Seat Blocking
- Temporary Hold
- Release Expired Holds

Business Rules

A booked seat cannot be booked again.

Temporary holds expire automatically.

Seat validation must occur before booking.

--------------------------------

Business Logic

Create Services

BookingService

SeatService

PnrService

RouteService

QRService

--------------------------------

Database

Create all required migrations.

Use transactions.

Create relationships.

--------------------------------

Deliverables

- Complete Booking Flow
- Services
- Requests
- Policies
- Controllers
- Blade Pages
- Routes
- Testing Checklist

Do NOT implement Agents or Reports yet.
