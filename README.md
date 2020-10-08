
# Laravel Form Builder Package

Note: THIS PACKAGE MAY NOT B COMPATIBLE WITH LARAVEL 7 or 8. I am no longer maintaining this package so please use the code for reference on how to create a jquery form builder.

A [Laravel](https://laravel.com) package for creating a drag-and-drop form builder using the [JQuery Form Builder](https://formbuilder.online).

Demo: [http://demoform.jazmy.com/](http://demoform.jazmy.com/)

*Note: Features like email, registration and file uploads are disabled in the demo*

Screenshot:

![alt text](http://demoform.jazmy.com/img/formbuilderdemo_screenshot.jpg "Form Builder Screenshot")

The forms fields are saved as json and stored in your database. A member of your site can create, edit and delete forms. Forms belong to the users that created them and each form has a unique link that can be shared publicly.

The json version of the form can be used to render the form for users to fill.

Example Json Form:
```json
[{"type":"header","subtype":"h1","label":"Demo Form 01"},{"type":"paragraph","subtype":"p","label":"This demo form is a potluck sign-up sheet"},{"type":"text","label":"Name","className":"form-control","name":"name","subtype":"text"},{"type":"radio-group","label":"Food Category","name":"foodcategory","other":true,"values":[{"label":"Appetizer","value":"Appetizer"},{"label":"Beverage","value":"Beverage"},{"label":"Salad","value":"Salad"},{"label":"Main","value":"Main"},{"label":"Dessert","value":"Dessert"}]},{"type":"number","label":"How many will it serve","className":"form-control","name":"numberserved","min":"1","max":"50","step":"1"},{"type":"text","label":"Dish Name","className":"form-control","name":"dishname","subtype":"text"},{"type":"checkbox-group","label":"Dietary Restrictions","description":"Which of the following does your dish contain?","name":"dietaryrestrictions","values":[{"label":"Alcohol","value":"Alcohol"},{"label":"Carbs","value":"Carbs"},{"label":"Dairy","value":"Dairy"},{"label":"Egg","value":"Egg"},{"label":"Fish","value":"Fish"},{"label":"Gluten","value":"Gluten"}]},{"type":"textarea","label":"Comment","className":"form-control","name":"comment","subtype":"textarea"}]
```

Form permission options
 + Public - anyone can submit the form without needing to login
 + Private - only authenticated members of your site can access the form. Provide the option for users to edit their previous submissions.

## Requirements
+ Laravel 5.7
+ MySQL
+ [Laravel Authentication](https://laravel.com/docs/5.7/authentication) - php artisan make:auth

*If you are looking for a managed web host, with easy laravel site creation, then I highly recommend [Cloudways](https://www.cloudways.com/en/?id=45081). Cloudways will setup a laravel site and mysql database in minutes.*

## Dependencies Included with Package
+ jQuery UI - User interface actions built on jQuery. [View jQuery ui Documentation](https://jqueryui.com/)
+ jQuery Formbuilder -  Drag and drop full-featured form editing. [View jQuery Formbuilder Documentation](https://formbuilder.online)
+ clipboard.js - Copy text to clipboard. [View Clipboard Documentation](https://clipboardjs.com/)
+ parsley.js - JavaScript form validation library. [View Parsley Documentation](http://parsleyjs.org/)
+ moment.js - Parse, validate, manipulate, and display dates and times in JavaScript. [View Moment Documentation](https://momentjs.com/)
+ footable - A responsive table plugin built on jQuery and made for Bootstrap. [View FooTable Documentation](https://fooplugins.github.io/FooTable/)
+ sweetalert - A beautiful replacement for site error/warning/confirmation messages. [View SweetAlert Documentation](https://sweetalert.js.org/)

## Installation Instructions
This custom package takes a couple steps to install but I will try to make it as simple as possible.

### Step One:
Edit your composer.json file manually or simply type

```bash
composer require jazmy/jaz-form-builder
```

### Step Two:
Ensure you have all your dependencies installed

```bash
composer install
```

*Note: The package will automatically register itself using [Laravel's](https://laravel.com) package discovery feature for versions 5.6 and above. This means you do not need to update your config/app.php file.*

### Step Three:
We need to add the additional database tables so run the following command

```bash
php artisan migrate
```
### Step Four:
Create the form package's configuration file. This will place a formbuilder.php file in your config folder. In the configuration file you can change the url path for the package's routes, layout template to use and script / style output sections.

Run the following command:
```bash
php artisan vendor:publish --tag formbuilder-config
```
### Step Five:
Update your blade template file. In the default laravel install the template file is located here: /resources/views/layouts/app.blade.php

You need to add tags for the new styles and scripts
At the top of the blade file, just above the closing head tag:
```php
@stack('styles')
```

At the bottom of the blade file, just above the closing the closing body tag:
```php
@stack('scripts')
```
*Note: If you ever need to change which files are called using these @stack values, you can update the config file.*



### Step Six:
Publish the custom blade view files by running
```bash
php artisan vendor:publish --tag formbuilder-views
```
Publish the public assets by running
```bash
php artisan vendor:publish --tag formbuilder-public
```
Or you can publish everything at once with
```bash
php artisan vendor:publish --provider="jazmy\FormBuilder\FormBuilderServiceProvider"
```

### Step Seven:
In order to properly link to attachments, you need to run the storage:link command which makes the storage folder publicly accessibly

```bash
php artisan storage:link
```

## Accessing The Application
Ta Da! You did it!  Now to access the form application.
http://your.domain.com/form-builder/forms

To view submissions:
http://your.domain.com/form-builder/my-submissions

## Using The Trait
You can access forms and submissions that belong to a user in your application. To use the trait add a use statement to your user model class.

```php
use jazmy\FormBuilder\Traits\HasFormBuilderTraits;

class User extends Authenticatable
{
    use HasFormBuilderTraits;
}
```

You can now access the user's forms and submissions by running

```php
$user = User::first();

// get the user's forms
$user->forms;

// get the user's submissions
$user->submissions;

// or use static methods on the jazmy\FormBuilder\Models\Form class
$user_forms = Form::getForUser($user); // returns a paginated resultset

// the jazmy\FormBuilder\Models\Submission class also has a static method for getting the submissions
// that belong to a user
$my_submissions = Submission::getForUser($user); // returns a paginated resultset
```

## Using Events
The package dispatches a number of events when records are created or updated so that you can listen to these events and perform custom tasks in your application's logic

## Precautions
1. Make sure you have a table name users with a colum id {bigSignedInteger} in your database.
2. Once you have submission(s) on a form , dont attempt to edit the form again bacause it will break the display of earlier submissions 3. 

## Acknowledgments
Special Thanks to Farayola Oladele, one of the best Laravel programmers on Fiverr: https://www.fiverr.com/harristech He taught me so much and I highly recommend him for assistance on your Laravel projects.
