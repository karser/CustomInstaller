CustomInstaller
===============
This installer for composer packages allows you to specify custom install path per package in Symfony2.
Inspired by [this](https://github.com/composer/installers/pull/30) discussion.
## Installation
Add the code in your composer.json:

```js
{
    "require": {
        "karser/custom-installer": "dev-master"
    }
}
```


Now tell composer to download the library by running the command:

``` bash
$ php ./composer.phar update
```

## Usage
```js
    "extra": {
        "installer-paths": {
            "src/": ["karser/*-bundle"]
        }
    }
```
