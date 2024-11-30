# Webform Booking Calendar

The Webform Booking Calendar module is an extension of the [Webform Booking module](https://www.drupal.org/project/webform_booking), adding a flexible and user-friendly calendar block to display bookings visually within Drupal.

## Features
- **Visual Booking Management:** Displays bookings in an interactive FullCalendar.js-based view.
- **Calendar Integration:** Automatically calculates session end times based on the Webform Booking slot duration.
- **Customizable Block:** Add a configurable calendar block to any page and choose the Webform Booking elements to display.
- **Permissions:** Built-in permission checks to ensure only authorized users can view the calendar.

## Requirements
- Drupal 9 or later
- [Webform Booking module](https://www.drupal.org/project/webform_booking)

## Installation
1. Install the Webform Booking Calendar module like any other Drupal module:
   ```bash
   composer require drupal/webform_booking_calendar
2. Enable the module through the UI or drush en webform_booking_calendar

## Usage
1. Add the Webform Booking Calendar block to any region via the block placement UI.
2. Configure the block settings to select the desired Webform Booking elements.
3. View and manage bookings visually using the calendar interface.