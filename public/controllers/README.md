# Routes
## To register a route follow the next example:


$router = new Router();<br>
$routes = Array(<br>
    'Home' => new HomeController('GET', '/', 'home', 'HOME'),<br>
    '404' => new NotFoundController(null, null, null, null, array('msg' => '404 not found.')),<br>
    ...<br>
);<br>
$router->setRoutes($routes); <br>
$router->setRouter($router);<br>

## Here you need to follow the following structure:
### Example:
```'PageName' => new PageController('METHOD', 'ROUTE', 'TemplateName', 'PageTitle', array('dataKey' => 'Data Value here.'))```

### Explanation:
* PageName: Its just a convention to indentify your page.
* pageController: Its the controller of the page that will have the bussines logic of the requested page.
* METHOD: Could be something like ```[GET, POST, PUT, DELETE, ANY ...]``` or something else.
* TemplateName: Its the name or route/dir of the template in ```public/templates/views``` without the .twig at the end of the name.
* PageTitle: Will be the title of the page. Could be null and will takes the value of the twig template.
* array(): Its the data that you will pass from the controller to the template to render it.
* dataKey: The name that you will use to access to the data passed to the template.
* dataValue: The value that you will see when the page is rendered.
