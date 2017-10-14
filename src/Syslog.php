<?php
namespace Bybzmt\Logger;

use Psr\Log\LoggerTrait;
use Psr\Log\LoggerInterface;

/**
 * syslog日志
 */
class Syslog implements LoggerInterface
{
    use LoggerTrait;

    protected $_facilitys = [
        "LOG_AUTH" => LOG_AUTH,
        "LOG_AUTHPRIV" => LOG_AUTHPRIV,
        "LOG_CRON" => LOG_CRON,
        "LOG_DAEMON" => LOG_DAEMON,
        "LOG_KERN" => LOG_KERN,
        "LOG_LOCAL0" => LOG_LOCAL0,
        "LOG_LOCAL1" => LOG_LOCAL1,
        "LOG_LOCAL2" => LOG_LOCAL2,
        "LOG_LOCAL3" => LOG_LOCAL3,
        "LOG_LOCAL4" => LOG_LOCAL4,
        "LOG_LOCAL5" => LOG_LOCAL5,
        "LOG_LOCAL6" => LOG_LOCAL6,
        "LOG_LOCAL7" => LOG_LOCAL7,
        "LOG_LPR" => LOG_LPR,
        "LOG_MAIL" => LOG_MAIL,
        "LOG_NEWS" => LOG_NEWS,
        "LOG_SYSLOG" => LOG_SYSLOG,
        "LOG_USER" => LOG_USER,
        "LOG_UUCP" => LOG_UUCP,
    ];

    protected $_prioritys = [
        "emergency" => LOG_EMERG,
        "alert" => LOG_ALERT,
        "critical" => LOG_CRIT,
        "error" => LOG_ERR,
        "warning" => LOG_WARNING,
        "notice" => LOG_NOTICE,
        "info" => LOG_INFO,
        "debug" => LOG_DEBUG,
    ];

    protected $_ident;
    protected $_facility;

    public function __construct($ident, $facility)
    {
        $this->_ident = $ident;
        $this->_facility = $facility;

        if (!isset($this->_facilitys[$facility])) {
            throw new Exception("Syslog facility: $facility Unavailability");
        }

        $facility_int = $this->_facilitys[strtoupper($facility)];

        openlog($ident, LOG_ODELAY, $facility_int);
    }

    public function __destruct()
    {
        closelog();
    }

    public function log($level, $message, array $context = array())
    {
        $priority = $this->_prioritys[$level];

        $msg = json_encode($message, JSON_UNESCAPED_UNICODE);
        if ($context) {
            $msg .= json_encode($context, JSON_UNESCAPED_UNICODE);
        }

        syslog($priority, $msg);
    }
}
