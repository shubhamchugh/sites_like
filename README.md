> **_Enable csv importer_**

```bash
SET GLOBAL local_infile=1;
```

> Import CSV File in MySql Database

```bash
LOAD DATA LOCAL INFILE 'posts' INTO TABLE source_domains
FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n'
(domain) set domain=domain ;
```

> Node Dependency Install

```bash
bash install.sh
```

> Deployment Script For Runcloud

```bash
git status
git reset --hard
git pull
COMPOSER_MEMORY_LIMIT=-1 composer update
php artisan migrate --seed
bash install.sh
```

alter-scrape
wappalyzer-scrape
ssl-scrape
alexa-scrape
seo-scrape
dns-scrape
ip-location-scrape
screenshot-scrape
