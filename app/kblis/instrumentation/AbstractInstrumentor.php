<?php
namespace KBLIS\Instrumentation;
 
abstract class AbstractInstrumentor implements InstrumentorInterface
{
    protected $ip;
    protected $hostname;
 
    public function __construct($ip, $hostname = null) {
        if ($ip !== null) {
            $this->setIP($ip);
        }
        if ($hostname !== null) {
            $this->setHost($hostname);
        }
    }
 
    public function setIP($id) {
        $this->checkIP($id);
        $this->id = $id;
        return $this;    
    }
 
    public function setHost($hostname) {
        $this->checkHost($hostname);
        $this->hostname = $hostname;
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