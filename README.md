# [PHP](https://www.php.net/)
## Shopping Web Application sourcecode Demo
Web application for shopping

* hash algorithm argon2id from PHP and salting

* sessions in PHP to authorize

* Mpdf to export reports and invoice PDFs

* MySQL Database

## Setup 

## Setup 
1.Download composer from https://getcomposer.org

2.Using Mpdf to create PDF (Report, Invoice)

```bash
composer require mpdf/mpdf
```

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->Output();
```
* download th_sarabun fonts and put files into /vendor/mpdf/mpdf/ttfonts
* setting this in /vendor/mpdf/mpdf/src/Config/FontVariables.php by add

```php

'fontdata' => [
				"sarabun" => [
					'R' => "THSarabun.ttf",
					'B' => "THSarabun-Bold.ttf",
					'I' => "THSarabun-Italic.ttf",
					'BI' => "THSarabun-BoldItalic.ttf",
					'useOTL' => 0x00,
					'useKashida' => 75,
				],
],
```

```php
$mpdf = new \Mpdf\Mpdf([
    'default_font_size' => 14,
    'default_font' => 'sarabun'
]);
```






