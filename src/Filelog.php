<?php
namespace Bybzmt\Logger;

use Psr\Log\LoggerTrait;

/**
 * 文件日志
 */
class Filelog
{
    use LoggerTrait;

    protected $_ident;
    protected $_file;
    protected $_timeformat;

    public function __construct($ident, $file, $timeformat='Y-m-dTH:i:s')
    {
        $this->_ident = $ident;
        $this->_file = $file;
        $this->_timeformat = $timeformat;
    }

    public function log($level, $message, array $context = array())
    {
        error_log(sprintf(
            "%s %s %s %s%s",
            $this->_timeformat,
            $level,
            $this->_ident,
            json_encode($message, JSON_UNESCAPED_UNICODE),
            $context ? json_encode($context, JSON_UNESCAPED_UNICODE) : ""
        ), 3, $this->_file);
    }
}
