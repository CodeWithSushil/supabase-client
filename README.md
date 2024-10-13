![Supabase](https://getlogo.net/wp-content/uploads/2020/11/supabase-logo-vector.png)

![GitHub forks](https://img.shields.io/github/forks/Ashishkumbhar01/supabase-php?style=for-the-badge&logo=Github)
![GitHub License](https://img.shields.io/github/license/Ashishkumbhar01/supabase-php?style=for-the-badge)
[![GitHub Sponsors](https://img.shields.io/github/sponsors/Ashishkumbhar01?style=for-the-badge&logo=Github%20Sponsors&label=Support%20me)](https://github.com/sponsors/Ashishkumbhar01)
![GitHub Repo stars](https://img.shields.io/github/stars/CodeWithSushil/supabase-client?style=for-the-badge&logo=Github)
![GitHub Release](https://img.shields.io/github/v/release/Ashishkumbhar01/supabase-php?style=for-the-badge)
![Packagist Downloads](https://img.shields.io/packagist/dt/supabase-php/supabase-client?style=for-the-badge&logo=composer)

Supabase  client for PHP:
- Realtime database, Storage, Authentication and many more.
- When you creating your supabase table, make sure RLS (Row Level Security) option be [×] disable.
- If RLS are enable [✓] maybe you getting some error so you need to use `Auth class`.
Auth class coming soon.

### `Install`
* Install Supabase client for our project.
* Than we are require supabase-client by composer.

```bash
composer require supabase-php/supabase-client
```

### Config
Supabase client for PHP configuration with your php project/web Apps.

```php
use Supabase\Functions as Supabase;

// autoload the supabase class
require_once('vendor/autoload.php');

// config
$config = [
  'url' => $_ENV['SB_URL'],
  'apikey' => $_ENV['SB_APIKEY']
];

$client = new Supabase($config['url'], $config['apikey']);
```
if you did not have `.env` file so please create your `.env` file.

```bash
touch .env
```

if you create already your `.env` file then you will be derclare your enviroment variables names.

```bash
vi .env
```

```env
SB_URL=https://rurtighghurtuhouger.supabase.co
SB_API_KEY=utertu895tyut8trrvt8rtu8mutt84r548t894v98v5vtt6ut54uu85tu
```

### `getAllData()`
if you want to get all recorded data from your table when you saved the data then used `getAllData` function.

```php
$data = $client->getAllData('table name');
print_r($data);
```

### `getSingleData()`
if you need a specifics data from specifics columns then you used `getSingleData` function.

```php
$data = $client->getSingleData('table name', 'column name');
print_r($data);
```

### `postData()`
if you want to save your data to your table then used `postData` function.

```php
// posted data
$data = [
  'name' => 'PHP',
  'version' => '8.3'
];

$client->postData('table name', $data);
```

### `updateData()`
if you thinks something to be wrong or outdated so you will be changing that particular value from particular columns and also you updating all the data.
Then used `updateData` function.

```php
// updated data
$data = [
  'name' => 'PHP',
  'version' => '8.4'
];

$client->updateData('table name', 'id number', $data);
```

### `deleteData()`
if you want to Delete a specificed data from the table, then used `deleteData` function.
you needed the id number of table data.

```php
$client->deleteData('table name', 2 //id);
```

### `Pagination()`

```php
$client->pages('table name');
```

### `Filtering()`

```
$client->filter('table name', 1);
```

### `Matching()`

```php
$data = [
  'name' => 'PHP',
  'version' => '8.4'
];

$client->matchs('table name', $data);
```

### Authentication
* Auth Class coming soon.


### Storage
* storage class coming soon.
