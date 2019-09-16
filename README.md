UTMSTAT API CLIENT
==================

## API для телефоний

<-- смотрите вкладку Звонки

## Установка

Добавьте в композер пакет: 
```text
"utmstat/api-client-php": "dev-master"
```

Получите токен здесь: 
```text
https://utmstat.com/projects/api
```

## Использование

### Список заявок

```php
$token = 'hX_eSBo4XrJy98XKkDSJhfs';
$api = new UtmStatApiClient($token);
$filter = [
	'from' => '2018-09-02',
	'to' => '2018-09-08',
	'status_id' => 2
];

$leads = $api->leadsList($filter);
```

### Изменить статус заявки

#### Обновление по id заявки внутри UTMSTAT

```php
$token = 'hX_eSBo4XrJy98XKkDSJhfs';
$api = new UtmStatApiClient($token);
$lead = [
	'id' => 123,
	'status_id' => 1
];
$api->leadsUpdate($lead);
```

#### Обновление по id заявки из внешней CRM (RetailCRM)

```php
$token = 'hX_eSBo4XrJy98XKkDSJhfs';
$api = new UtmStatApiClient($token);
$lead = [
	'retail_crm_id' => 456,
	'status_id' => 1
];
$api->leadsUpdate($lead);
```

## Справочник

### Коды статусов заявок

1 - Новый

5 - В обработке

2 - Продано

3 - Отказ

4 - Треш

6 - Неизвестный

7 - Пропущеный звонок

8 - Тестовая
