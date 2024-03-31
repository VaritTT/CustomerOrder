## Setup 
Shopping Web Application sourcecode Demo

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

* download th_sarabun fonts
```php
$mpdf = new \Mpdf\Mpdf([
    'default_font_size' => 14,
    'default_font' => 'sarabun'
]);
```



