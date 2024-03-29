<?php
namespace Bybzmt\Logger;

use Psr\Log\LoggerTrait;
use Psr\Log\LoggerInterface;

/**
 * 文件日志
 */
class Filelog implements LoggerInterface
{
    use LoggerTrait;

    protected $_ident;
    protected $_file;
    protected $_timeformat;

    public function __construct($ident, $file, $timeformat='Y-m-d\TH:i:s')
    {
        $this->_ident = $ident;
        $this->_file = $file;
        $this->_timeformat = $timeformat;

        $dir = dirname($file);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    public function log($level, \Stringable|string $message, array $context = array()) :void
    {
        error_log(sprintf(
            "%s %s %s %s%s\n",
            date($this->_timeformat),
            $level,
            $this->_ident,
            json_encode($message, JSON_UNESCAPED_UNICODE),
            $context ? json_encode($context, JSON_UNESCAPED_UNICODE) : ""
        ), 3, $this->_file);
    }
}
