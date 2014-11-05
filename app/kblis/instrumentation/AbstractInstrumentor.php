<?php
namespace KBLIS\Instrumentation;
 
abstract class AbstractInstrumentor implements InstrumentorInterface
{
    protected $ip;
    protected $host;
 
    public function __construct($ip, $hostname = null) {
        if ($ip !== null) {
            $this->setIP($ip);
        }
        if ($host !== null) {
            $this->setHost($host);
        }
    }
 
    public function setIP($id) {
        $this->checkIP($id);
        $this->id = $id;
        return $this;    
    }
 
    public function setHost($host) {
        $this->checkHost($host);
        $this->host = $host;
        return $this;    
    }
 
    protected function checkHost($value) {
        if (!preg_match('/^[a-z0-9_-]+$/', $value)) {
            throw new InvalidArgumentException(
                "This hostname is invalid.");
        }
    }
 
    protected function checkIP($value) {
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException(
                "The ip address is invalid.");
        }
    }
}