# Rikiki MVC
Version: 1.0.1

## INSTALL

#### PREREQUISITES
- PHP 5.2+
- Apache **with mod_rewrite activated**
- MySQL / MariaDB

#### Composer

**Install**
- If not already installed, install Composer:
  - Linux / MacOS: in `app/` folder, run:
    - `curl -sS https://getcomposer.org/installer | php`
  - Windows: https://getcomposer.org/Composer-Setup.exe

**Run**
- In the `app/` folder, run `composer install` to install dependencies
- Add Propel generator's path on the `PATH` environment variable of your OS
  - The path should be `[project_path]/app/vendor/propel/propel1/generator/bin/`

#### (For XAMPP users only)
If you did not configure PEAR/PHING yet, please do it:

    pear config-set doc_dir C:\xampp\php\pear\docs
    pear config-set cfg_dir C:\xampp\php\pear\cfg
    pear config-set data_dir C:\xampp\php\pear\data
    pear config-set cache_dir C:\xampp\php\pear\cache
    pear config-set download_dir C:\xampp\php\pear\download
    pear config-set temp_dir C:\xampp\php\pear\temp
    pear config-set test_dir C:\xampp\php\pear\tests
    pear config-set www_dir C:\xampp\php\pear\www

Then:

    pear install phing/phing

### CONFIGURE DATABASE (PROPEL ORM / MYSQL)

- Create an empty database in MySQL with _utf8-general-ci_ for the default encoding
- Copy `db/build.dist.properies` to `db/build.properies`
- Edit it with your database name and credentials
- Copy `db/runtime-conf.dist.xml` to `db/runtime-conf.xml` and edit this area with correct values:

        <dsn>mysql:host=[HOST];dbname=[DB_NAME];port=[PORT]</dsn>
        <user>[USER]</user>
        <password>[PASS]</password>

- Edit `db/schema.xml` as you wish
  - More info: http://propelorm.org/Propel/reference/schema.html
  - **Do not forget to replace `[DATABASE_NAME]`** in `<database>` on the top of the file

- Go to the `db/` folder and run `propel-gen`
- Import `db/build/schema.sql` to your database

### CONFIGURE APPLICATION

- Copy `app/config.dist.php` to `app/config.php` and edit it (more info on the file).

## USAGE

- To create a new page, simply create the view `tpl/pages/[YOUR_PAGE].tpl` and the associated controller `controllers/[YOUR_PAGE].php`
- To create a new action, simply create: `actions/[YOUR_ACTION].php` including: `function action_[YOUR_ACTION]() {...}`
  - To use it, call the page with the parameter `action` set to your action's name
- The framework already includes JQuery 2 and Bootstrap 3, you can start coding in: `css/app.css` and `js/app.js`

**Enjoy! And feel free to report any bug or suggestion :)**
