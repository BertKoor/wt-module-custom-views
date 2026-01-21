# webtrees module for custom views

This [webtrees](https://www.webtrees.net) module provides a storage location for customized versions of the `.phtml` files
outside of the usual `resources/views/` directory, so they remain untouched upon upgrades.

## Compatibility

### webtrees 2.2
This module is primarily developed for, and tested with webtrees 2.2.5 running under PHP 8.4.

### webtrees 2.1
This module is tested with webtrees 2.1.25 under PHP 7.4 and 8.2, and it seems to work.

### webtrees 2.0
It is generally discouraged to run this version of webtrees and PHP7 it is based on.
_You really should upgrade._ Nevertheless, I have tested this out of curiosity, and it seems to work.

### webtrees 1.7
This module **will not work** with webtrees versions lower than 2.0.

## Installation instructions
On your server there is a directory `modules_v4`.
Create a subdirectory `wt-module-custom-views` in there.

Download the source files of this repository as a zip, and unzip them onto your server into the directory you just created.

The end result looks like this:

* `modules_v4 <dir>` (already exists on your server)
   * `wt-module-custom-views <dir>`
      * `resources <dir>`
         * `views <dir>`
            * `login-page.phtml`
      * `CustomViewsModule.php`
      * `module.php`

The files `latest-version.txt` and this `README.md` are not required to be uploaded to your server, but won't do any harm.

## Usage
Put your copy of `.phtml` files in the `resources/views/` directory of this module.

The original folder structure of webtrees should be mimicked, so subdirectories 
such as `edit/` or `modules/faq/` should be created by you.

The provided `login-page.phtml` can be deleted, it serves just as an example.
It is a plain copy of the webtrees 2.1 login page with `Username` changed to `User id`.

## Privacy, telemetry, tracking, etc.
Privacy: yes. Tracking: no.

There is no way for me to find out how many sites have this module installed, let alone which ones.
It would be simple for me to implement it for the sake of monitoring, but I have chosen not to.

The module will do a check on the latest available version whenever the webtrees Control Panel is opened.
It checks a url on github.com, not on my own server, so traffic data is inaccessible to me.

## License
````
Copyright (C) 2025-2026 BertKoor.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
````
## Warranty
````
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
See the GNU General Public License for more details:
<https://www.gnu.org/licenses/>
````