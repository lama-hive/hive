<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Utils;

use DateTimeImmutable;
use Exception;
use Lamahive\Hive\Framework\Core\Exception\CoreException;

class Clock
{
    /**
     * @throws CoreException
     */
    public function getUtcDateTime(): DateTimeImmutable
    {
        try {
            return new DateTimeImmutable('now', new \DateTimeZone('UTC'));
        } catch (Exception $e) {
            throw new CoreException('An error occurred while getting the UTC date and time.', 0, $e);
        }
    }
}
