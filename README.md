# Datafari

Datafari integration for Nextcloud (v15) with Dashboard App (https://github.com/nextcloud/dashboard/ --> install it before)
DO NOT USE THIS APP IN PRODUCTION : this app is a prototype ;)

YOU NEED:
- make tests
- fork and adapt

LICENSE : MIT

Place this app in **nextcloud/apps/**

## Install

- Install Nextcloud
- Install Dashboard (https://github.com/nextcloud/dashboard/)
- Activate Dashboard App (in Settings / Applications)
- Clone this repo in nextcloud/apps directory and rename it in 'datafari')
- Activate Datafari App (in Settings / Applications)
- Enjoy ;)

## Building the app (not mandatory !)

The app can be built by using the provided Makefile by running:

    make

This requires the following things to be present:
* make
* which
* tar: for building the archive
* curl: used if phpunit and composer are not installed to fetch them from the web
* npm: for building and testing everything JS, only required if a package.json is placed inside the **js/** folder

The make command will install or update Composer dependencies if a composer.json is present and also **npm run build** if a package.json is present in the **js/** folder. The npm **build** script should use local paths for build systems and package managers, so people that simply want to build the app won't need to install npm libraries globally, e.g.:

**package.json**:
```json
"scripts": {
    "test": "node node_modules/gulp-cli/bin/gulp.js karma",
    "prebuild": "npm install && node_modules/bower/bin/bower install && node_modules/bower/bin/bower update",
    "build": "node node_modules/gulp-cli/bin/gulp.js"
}
```


## Publish to App Store

First get an account for the [App Store](http://apps.nextcloud.com/) then run:

    make && make appstore

The archive is located in build/artifacts/appstore and can then be uploaded to the App Store.

## Running tests
You can use the provided Makefile to run all tests by using:

    make test

This will run the PHP unit and integration tests and if a package.json is present in the **js/** folder will execute **npm run test**

Of course you can also install [PHPUnit](http://phpunit.de/getting-started.html) and use the configurations directly:

    phpunit -c phpunit.xml

or:

    phpunit -c phpunit.integration.xml

for integration tests

## Datafari

### First Request

Parameters
-----------

```
fl: title,url,id,extension,preview_content, nbLikes:field(nbLikes)
facet: true
q: test
rows: 10
facet.field: {!ex=extension}extension
facet.field: {!ex=entity_person}entity_person
facet.field: {!ex=entity_phone_present}entity_phone_present
facet.field: {!ex=entity_special_present}entity_special_present
facet.field: {!ex=language}language
facet.field: {!ex=source}source
facet.query: {!key=Moins%20de%20un%20mois}last_modified:[NOW-1MONTH TO NOW]
facet.query: {!key=Moins%20de%20un%20an}last_modified:[NOW-1YEAR TO NOW]
facet.query: {!key=Moins%20de%20cinq%20ans}last_modified:[NOW-5YEARS TO NOW]
facet.query: {!key=Moins%20de%20100ko}original_file_size:[0 TO 102400]
facet.query: {!key=De%20100ko%20%C3%A0%2010Mo}original_file_size:[102400 TO 10485760]
facet.query: {!key=Plus%20de%2010Mo}original_file_size:[10485760 TO *]
id: cbc4df7a-56d7-4a4f-8320-87be6b3819e0
sort: score desc
q.op: AND
spellcheck.collateParam.q.op: AND
wt: json
json.wrf: jQuery18109890949960586746_1547133511537
_: 1547133512081
```

### With 'Type = pdf' selected

```
....
fq: {!tag=language}(language:en OR language:fr )
fq: {!tag=source}(source:file )

```
