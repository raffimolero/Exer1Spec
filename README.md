# from bad php to worse php

![image of the home page](_/home%20page.png)

This is a project designed to comply with some really weird specification set for a school project.
Apparently we weren't allowed to use the latest PHP features and had to use PHP print statements to print out HTML,
instead of just putting the PHP inside of the HTML like it was designed to do from the very moment it was created.

So, out of sheer spite, I decided to create a very extremely rushed framework/build system that takes a file structure of .php files with templates and styles,
and compiles them into a set of .html and .php files structured the same way as the folder structure inside of `Exer1Spec/php/views/**`.

please install Git, WSL and Docker Desktop before running this command to clone the repository:

    git clone https://github.com/raffimolero/Exer1Spec.git
    cd Exer1Spec

After that, if you're on Windows:

- run the Docker Desktop application
- `./run`

If you're on Linux/Mac:

- `./run.sh`

This should automatically compile the Weird PHP into the Worses PHP and run the server.
Once it's done, simply follow the link printed in the terminal.

It also bundles the whole project into `target/$OUTNAME.zip` for school project submission convenience.

You can configure the port and the output filename in the `.env` file.
Currently, it has `PORT=8000` and `OUTNAME=targetname` so the link will be http://localhost:8000/targetname/

i'm convinced this program is actual black magic. like, i haven't seen anything more arcane than this.

harry potter says expelliarmus. i say `Windows -> Batch -> Docker -> weird php -> worse php`. we are not the same.

- The `molero/` folder contains the Exercise 1 project, which was compiled some time ago.
- The `php/` folder contains the rest of the code used to compile the `target/$OUTNAME/` directory. It includes:
  - `assets/`: Stores/caches the assets downloaded in each php file, such as `php/img.php`.
  - `models/`: Stores initial unformatted csv data
    - `models/csv.php`: contains a global `$model_maps` variable that is capable of transforming the columns of an input `.csv`.
      For example, it's currently set to take `products.csv`, download an image from the specified URL column, and remove the URL column before it's compiled.
  - `styles/`: Stores CSS files.
  - `templates/`: Contains all the PHP templates that can be used in each of the views.
    - Each `foo.php` file name is globally available can be used as a template in all views and other templates.
      - You can render a template to `string` with `view('foo', [prop1 => value, prop2 => value])`
      - Unfortunately if you want to render the body/children of a template, you'll have to record it with `<?php ob_start(); ?>` and `<?php $body = ob_get_clean(); ?>` beacuse php.
      - `foo.php` will have `$prop1` and `$prop2` available within the file.
    - PHP files in subdirectories are passed as props to the parent PHP file if their name starts with a $.
      - For instance, if you have `foo.php` and a `foo/$bar.php`, then the contents of `$bar.php` will be available as `$bar` inside of `foo.php` as if you had called `view('foo', [bar => 'the contents of foo/$bar.php'])`
  - `views/`: Contains the folder and file structure to follow when building the target application, with some quirks:
    - most files and folders will be copied verbatim. Makes you wonder why I have a separate `styles/` folder.
    - `.php` files that start with `<!DOCTYPE html>` will be rendered into `.html`.
    - `.php` files that start with `<?php ?> will be rendered, but the file extension will be kept as `.php`.
  - Files that are _not_ part of the framework:
    - everything inside of `assets/`, `styles/`, and `views/`: explained earlier
    - everything inside of `models/` except `models/csv.php`
      - You can modify `$model_maps` manually inside of `csv.php` (I haven't built a way to add something like `products.php` into `$model_maps`)
    - everything inside of `templates/` except `js.php`
      - `js.php` was definitely a very quirky and definitely a last-minute addition.
      - Usage: `view('js', ['script' => '<script> /* code */ </script>', 'path' => 'foo.js'])`
      - Output: `foo.js` containing just the bare `/* code */` - including comments - but without the script tags.
      - Quirks: the string `<script>` will be deleted even if inside a string
      - This is used to render one singular `$script.php` file in the whole project. Go figure.
    - `.prettierrc`: The outputted html, css, and js in the target directory are all formatted according to this file
  - Files that are part of the framework:
    - `build.php`
    - `img.php` (`php/img.php`, not `php/templates/img.php`)
    - `init.php`
    - `io.php`
    - `php.ini`
    - `rebuild.sh`
    - `util.php`
