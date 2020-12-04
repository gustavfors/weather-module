Weather Module (kmom04)
==================================

### Installation

```
composer require gufo/weather-module
```

### Configuration

```
rsync -av ./vendor/gustavfors/weather-module/config ./
```

### API Keys

For the module to work you need two api keys one for the ip service and one for the weather service.

inside ./config create two new files "ipapi.txt" and "weatherapi.txt"

and place your api keys inside those files.

### views

In config/view.php add

```
ANAX_INSTALL_PATH . "/vendor/gustavfors/weather-module/view"
```

to the paths array

### Styles

```
rsync -av ./vendor/gustavfors/weather-module/css ./htdocs/css
```

inside ./config/page.php add 

```
"https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css",
"css/custom.css"
```

to the stylesheets array