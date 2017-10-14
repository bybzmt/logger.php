<?php

class BasicTest extends PHPUnit_Framework_TestCase
{
    protected $content;
    protected $tmpfile;

    protected function setUp()
    {
        $this->content = 'this time is: ' . date('Y-m-d H:i:s');

        $this->tmpfile = tempnam(sys_get_temp_dir(), 'test_');
    }

    protected function tearDown()
    {
        @unlink($this->tmpfile);
    }

    public function testFile()
    {
        $log = new \Bybzmt\Logger\Filelog('filelog', $this->tmpfile);

        $log->info($this->content);
    }

    public function testSyslog()
    {
        $log = new \Bybzmt\Logger\Syslog('syslog', 'LOG_LOCAL0');

        $log->info($this->content);
    }
}
