# webtrees module for custom views (and translations)

This [webtrees](https://www.webtrees.net) module provides a storage location for customized versions of the `.phtml` files
outside of the usual `resources/views/` directory, so they remain untouched upon upgrades.

For simple textual changes it also supports custom translations through `.php` or `.csv` files.

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
         * `lang <dir>`
            * `en-US.csv` 
            * `en-US.php`
          * `views <dir>`
            * `login-page.phtml`
      * `CustomViewsModule.php`
      * `module.php`

The files `latest-version.txt` and this `README.md` are not required to be uploaded to your server, but won't do any harm.

Anything in the `resources/` directory serves as a basic example and may be deleted.
You are expected to put your own files there.

## Usage

### Custom views
Put your copy of `.phtml` files in the `resources/views/` directory of this module.
All files in all subdirectories with the extension `.phtml` will automatically be registered
as a custom view.

The original folder structure of webtrees must be mimicked.
Subdirectories such as `edit/` or `modules/faq/` should be created if applicable.

Because the original files might change with an upgrade, it is advised 
to make a copy of each one in the `resources/views/` folder of this module, 
for example copy the original `login-page.phtml` to `login-page.phtml.bak`.
Then after an upgrade you can compare what you have changed and what changed in the core code.

The provided `login-page.phtml` can be deleted, it serves just as an example.
It is a plain copy of the webtrees 2.1 (for compatibility) login page with `Username` changed to `User id`.

This is actually a bad example. If you merely want to change some text literals 
and these are found inside a code block like `<?= I18N::translate('some text') ?>`, 
then it is advised to use:

### Custom translations
The mechanism to supply custom translations via `.php` or `.csv` files is borrowed from webtrees 1.7.
It is deemed simple enough and fit for most use cases. Both formats may be used, even for the same language.

The provided `en-US.csv` and `en-US.php` translation file can be deleted.
These serve just as an example.

* `en-US.csv` contains an alternative title of the login page.
* `en-US.php` changes the phrase "_Forgot password?_" to "_Request a new password_", which also is present on the login page.

#### Translation file requirements:
* The file location must be the `resources/lang/` directory of this module.
* The file name should be the code of the language plus `.csv` or `.php`.
* Valid language codes can be looked up in the `resources/lang/` directory of webtrees.
* Currently only simple translations (without context) are supported.

##### For `.php` files:
* They must return an array of key-value pairs, eg:
``` php 
<?php return [
   'some text' => 'the translation',
   'another text' => 'another translation',
];
```
* The key represents the original (US English) text as can be found as parameter
  of a `I18N::translate` function call.
* The value is your alternative rendition or translation.

##### For `.csv` files:
* A header line is not expected. If present, it will be processed as if it were a translation.
* Each line contains a single translation, within double quotes and delimited by a semicolon,
  eg:
``` csv
"some text";"the translation"
"another text";"another translation"
```
* The first string on a line is the original (US English) text as can be found as parameter
  of a `I18N::translate` function call.
* The second string on a line is your alternative rendition or translation of the first text.

#### Some considerations for using either `.php` or `.csv` files:
* There's more freedom in the formatting of a `.php` file, since the original text
  and translation are not required to be on the same line, and they  
  [may contain](https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.single)
  embedded newlines to span multiple lines or contain unescaped double quote characters.
* Processing of `.php` files is supposedly faster, depending on 
  [caching configuration](https://webtrees.net/admin/performance/) of your PHP engine. 
* A `.csv` file is read multiple times per page view.
  I suspect this might also be cached by the file system, although that may not be the case.
  Note that I have not done any performance measurements, _yet_.

#### Translation tips & tricks, whatelse...
* The date format in webtrees is localized via translation key `"%j %F %Y"`.
  This makes the date format in American English different from British English.
  By translating this key to a different formatting string, you can swap the day and month,
  use traditional `dd/mm/yyyy` notation, include the day of the week, pick long or short month names, etcetera.
  See for details: https://www.php.net/manual/en/datetime.format.php 
* I wasted some time trying to get a different text for `first cousin`, 
  since it has a translation context (male versus female form in some languages) but alas to no avail.
  As it turns out, this text is literally present in `app/Module/LanguageEnglishUnitedStates.php`
  and does not pass any translation. So not every textual tweak is simple or straight forward.

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