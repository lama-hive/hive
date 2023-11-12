<?php

declare(strict_types=1);

namespace Lamahive\Hive\Modules\Empty\Setup;

use Lamahive\Hive\Framework\Routing\Route;

return [
    new Route('get','/', \Lamahive\Hive\Modules\Empty\Controller\IndexController::class, 'index')
];
