# Detroit Aerotropolis

The Detroit Aerotropolis website is developed in Wordpress.  It features a custom built theme designed by [Hoyden Creative](http://www.hoydencreative.com) and developed by [Bryan Stanley](https://github.com/bstanley0811)


## Contributing

Not all files on the site are committed to this repository.  Some files are excluded for security reasons, while others are excluded due to differences between the staging and production site.  These files should only be changed with SFTP and not through GIT.

**Excluded for Security**

| File | Description |
| -- | -- |
| `github.php` | File that Github webhooks reach out to for auto-deploying |
| `bash.sh` | Script that runs to pull latest code from Github |
| `env.php` | Contains environment variables.  This file is pulled in from the `wp-config.php` file |
| `php.ini` | Contains settings for PHP |

**Excluded for environment differences**

| File | Description |
| -- | -- |
| `robots.txt` | Used by search engines and web crawlers |
| `ror.xml` | Used by search engines and web crawlers |
| `sitemap.xml` | Used by search engines and web crawlers |


## Branch Structure, Environments & Deploying

There are two main branches for the site:  `staging`, and `master`.  Anything merged to the `staging` branch will auto-deploy to our [staging site](http://aerotropolis.hoydencreative.com) and likewise, anything merged to the `master` branch will auto-deploy to our [production site](http://detroitaero.com).  Auto-deploys are done with the configured webhooks that Github allows us to tap into.  Each webhook listens for commits made to their branch and then makes an HTTP request out to their respective environments.  The environment then pulls the latest code from their respective branch on to the server.  For more information, visit the [webhooks section](https://github.com/Hoyden-Creative-Group/DRA/settings/hooks) within the repository settings.

#### Gotchas
* When merging code to `staging` or `master` be sure to watch the webooks section.  Every once in a while the webhook fails to receive a success response and needs to be replayed.  If it fails, simply click on the failed delivery and click on the `redeliver` button.
* After a successful deployment, the first check of the site may seem slow.  This is most likely due to Wordpress invalidating it's cache and querying for new data.  After a refresh, the site should load as normal.


## Database Backups

The production site is setup to run a database backup once a month.  It does this through the use of a Cron job and the `db-backup.php` file, stored on the web root.  Backups are stored outside the webroot in the `aerotropolis_db_backups` directory.  Settings to change how often this job should be run, can be adjusted through the Cron Jobs section within the hosting company's Control Panel.


## Wordpress Core Plugins

| Plugin | Description |
| -- | -- |
| Aerotropolis Theme Support | Supports the Aerotropolis theme with custom admin pages, widgets, and visual composer elements |
| [Visual Composer](https://visualcomposer.io/) | Plugin to help visualize layouts within Wordpress |
| [Advanced Custom Fields](https://www.advancedcustomfields.com/) | Adds the ability to create custom forms and fields within the Wordpress control panel  |
| [Gravity Forms](https://www.gravityforms.com/) | Adds the ability to create custom forms and track analytics around each form |
| [SMTP Mailer](https://wordpress.org/plugins/smtp-mailer) | Allows the configuration of a mail server for handling all outgoing email |


## Caching

Wordpress is notorious for performing poorly under heavy load.  This is mostly due to the tradeoffs of allowing a very customizable backend.  To circumvent this, caching is an excellent tool for improving site performance. Caching is done on several levels for the site.

#### Caching files
Expires headers are set in the `.htaccess` file and tells browsers how long to cache different types of files.  Basically, the browser downloads the files once and doesn't need to download them again on subsequent views.  However, there are times when we want the browser to re-download files; specifically after making changes to the site.  To prevent caching files after making changes, the site uses a `CACHE_BUSTER` variable that gets created each time the Github webhook is run.  This `CACHE_BUSTER` variable is then utilized for the `$version` option for both the [`wp_register_script`](https://developer.wordpress.org/reference/functions/wp_register_script/) and [`wp_register_style`](https://developer.wordpress.org/reference/functions/wp_register_style/) methods used for loading scripts and CSS styles.

#### Caching Data
For caching data, Wordpress offers something called [`transients`](https://codex.wordpress.org/Transients_API).  Transients are a way to for us to store any kind of data and set an expiration on that data.  The transients for the Aerotropolis theme are managed in the theme's [`functions.php`](./wp-content/themes/aerotropolis/functions.php) file.


## JavaScript & CSS

All JavaScript and CSS is precompiled using [`Gulp`](https://gulpjs.com/).  Gulp is a tool that allows a developer to run a multitude of tasks automatically, thus saving the developer time.  In addition to `Gulp`, the CSS is compiled using [`SASS`](https://sass-lang.com/).  `SASS` is an extension of CSS that enables the use of things like variables and mixins.  All JavaScript and CSS files are located in the theme's [`assets`](./wp-content/themes/aerotropolis/assets/)) directory.  To contribute to these files, follow these steps:
1. [Install Compass](http://compass-style.org/install/)
1. Install SASS globbing. `sudo gem install sass-globbing`
1. Download the repository and install the required modules. `cd wp-content/themes/aerotropolis` and run `npm i`
1. Install Gulp.  `npm install gulp-cli -g`
1. Run Gulp's `watch` command. `gulp watch`

Gulp will now watch for any changes made to the JavaScript or to the SASS files and automatically compile the output to to the `assets/dist` folder; the files that the theme is looking for.  To stop Gulp from watching your files, hit `Ctrl + C`.  If you prefer to not have Gulp watch for changes, you can also manually run commands to compile the JavaScript or CSS individually.  These commands are `gulp build-css` and `gulp build-js`.  For more information on these commands, view the [`gulpfile.js`](./wp-content/themes/aerotropolis/gulpfile.js).

### CSS Sprites
CSS sprite generation is done automatically with the use of `SASS` and `Compass`.  Create the normal and 2x sizes of the image you would like to add to your sprite and save each image in the respective image directories with the [sprite directory](./wp-content/themes/aerotropolis/assets/img/sprites).  Gulp will detect the file change (or run `gulp build-css`) and run a mixin to generate the sprites.  To then refer to your sprite image within the CSS, use the `@include retina-sprite( '<name_of_the_image>', desktop );`  For more details, view the [`_sprite.scss`](./wp-content/themes/aerotropolis/assets/sass/plugins/retina/_sprite.scss) file.

### Custom Fonts
In many cases, a font is a better alternative than using an image sprite.  Any time there is a flat, single colored vector element, a font symbol was created instead of a sprite image.  By using a font, we are able to reuse an element and scale it to any size without rendering issues.  The custom font was created using [Fontello](http://fontello.com/).  The `config.json` and source svg files are located in the [assets directory.](./wp-content/themes/aerotropolis/assets/fonts/fontello/src)  If adding new items to this font, please be sure to save the updated `config.json` file, along with the svg source image.  Additionally, be sure to update the [`_fonts.scss`](./wp-content/themes/aerotropolis/assets/sass/global/_fonts.scss#L76-L92) file with the new icon created.

### CSS Classes
The majority of the layout of the site is handled by Visual Composer.  And while there are some general CSS classes, each page has it's own dedicated `SASS` file located in the [SASS pages directory.](www/aerotropolisv2/wp-content/themes/aerotropolis/assets/sass/desktop/pages) When looking for specific page styles this is most likely where those styles are written.

For the some of the more common and reusable classes, look in the [`_desktop-common.scss`](./wp-content/themes/aerotropolis/assets/sass/desktop/_desktop-common.scss) and [`_common.scss`](./wp-content/themes/aerotropolis/assets/sass/global/_common.scss) files.


## Local Development
Coming soon
