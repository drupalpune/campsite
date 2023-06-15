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
