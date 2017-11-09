<?php
namespace Bybzmt\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * 日志工厂
 */
class Factory
{
    public static function getLogger(array $cfgs): LoggerInterface
    {
        $type = array_shift($cfgs);
        switch ($type) {
        case 'syslog':
            return new Syslog(...$cfgs);
        case 'file':
            return new Filelog(...$cfgs);
        case 'PHPlog':
            return new PHPlog(...$cfgs);
        case 'null':
            //直接抛弃
            return new NullLogger();
        default:
            throw new Exception("Undefined Logger Type:{$type}");
        }
    }
}
