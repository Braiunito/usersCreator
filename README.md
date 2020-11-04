# Make Users


This is a project in full PHP and JS, without frameworks, all coded "by hand". And mounted in heroku with Amazon RDS as DB provider.
The link of the heroku app is [Click me to start make users!](https://make-users.herokuapp.com/).

The entry point of the aplication is the ```index.pxp``` file located at ```public/index.php```.
That calls ```app.php``` in ```public/libs/app.php```.

This application was built in a span of 5 hours per day from October 27 to November 4.
Was a challenge and was a success just working a total of 35Hs.

Most of the time was spent on define and develop the main structure or MVC pattern and tools (Core functions) to start the real development-app-work.

# Info:
* If you want to work locally, this project runs with Lando, see [Lando quick instalation guide](https://docs.lando.dev/basics/installation.html#hello-world) for more info to bring it up!
When you finally have lando, just copy the ```.env_example``` to ```.env``` and tap ```lando start``` on your console at ```.lando.yml``` level and hack away!
* For more technical details, you will find other *README's* files at some other levels of the project to guide yourself in the editing way!

# Summary:


### Implementations:
* 35 development hours.
* PHP for backend.
* Js, Css, Html for frontend.
* Basic CRUD features.
* Ajax logic.
* Search functionalitie.
* Pagination.
* Password encryption and storage.
* Session validation per actions.
* AWS management.
* Heroku as PASS management.
* Docker with Lando wrapper.
* SSL Security.

### Libraries:
* Bootstrap.
* Twig (template engine).
* Phroute.

#### Backlog:
* Change function comments to PHPDoc syntax.
* Add PHPUnit.
* Refactor functions location to improve MVC pattern.
* Refactor Js to have a main.js file and change procedural orientation to OOP.
* Improve form validations and modals to perform UX.
* Implement error managament in high risk functions.
* Implement WebSockets to reload in real.
* Finish the DB contingency functions.
* Find bugs and kill them! Thanks for reading!