<?php
namespace Bybzmt\Logger;

use Psr\Log\LoggerTrait;
use Psr\Log\LoggerInterface;

/**
 * PHP日志
 */
class PHPlog implements LoggerInterface
{
    use LoggerTrait;

    protected $_ident;

    public function __construct($ident)
    {
        $this->_ident = $ident;
    }

    public function log($level, \Stringable|string $message, array $context = array()) :void
    {
        error_log(sprintf(
            "%s %s %s %s%s\n",
            date('Y-m-d\TH:i:s'),
            $level,
            $this->_ident,
            json_encode($message, JSON_UNESCAPED_UNICODE),
            $context ? " ".json_encode($context, JSON_UNESCAPED_UNICODE) : ""
        ));
    }
}
