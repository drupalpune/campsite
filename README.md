# DrupalCamp Pune
## Local development instructions.
### Requirements
1. Docker and DDEV
### Set up instructions
1. Clone repo to your local and navigate to cloned directory.
2. Run `ddev composer install`
3. Import DB usind `ddev sql-cli < /path/to/db.sql`
### Theme development
1. Run `ddev theme:install` to install node packages. This is a one time step.
2. To build theme run `ddev theme:build`
3. To watch theme run `ddev theme:watch`
### Code quality
1. Run `ddev phpcs` to check and fix code standard errors in your code.


## Content Architecture
### Sessions:
- Content type: Session.
- Session page: @todo: Add a page view of sessions at '/sessions'
### Sponsors:
- Content type: Sponsor.
- Sponsors page: A page view of sponsors at '/sponsors'
### Speakers:
- Entity type: User.
- Referenced from Speaker CT via author (uid).
- Speakers page:
  - A page view of users with relationship added to Speaker content and condition: Speaker moderation state: Published.
  - A block of single content is added to top of this page as Keynote Speaker. Condition: Field 'Keynote session': TRUE.
### Schedules:
- Content type: Schedule.
- Fields: 'Schedule item' with reference to paragraph type 'Schedule' item.
- **Schedule item:**
  - Paragraph with a field reference to a session/Or a text field for schedule items like 'Lunch', 'Break' etc.
  - Other fields with details like Time, Location etc.
- Schedule page:
  - Create 1 schedule node for each day of the schedule.
  - Create a Landing page with Url alias `/schedule`.
  - The quicktabs block for schedule items will automatically get placed on this page.
    - Edit the 'Schedule' quicktab to configure which schedule nodes should appear on the schedule page.
    - @todo: Add 'Schedule' quicktab node config to config ignore,
