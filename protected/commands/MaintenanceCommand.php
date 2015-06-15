<?php
/**
 * Console command that can be used to toggle maintenance mode "on/off"
 * cd /proj/protected && yiic maintenance on 
 * cd /proj/protected && yiic maintenance off 
 */
class MaintenanceCommand extends CConsoleCommand
{
    const ON = 'on';
    const OFF = 'off';

    protected $allowedStatus = array(self::ON => true, self::OFF => false);
    protected $json;
    protected $path;

    public function init()
    {
        $this->path = dirname(__FILE__) . '/../..';
        
        if (file_exists($this->path . '/_mtce.json')) { // maintenance mode checker
            $this->json = json_decode(file_get_contents($this->path . '/_mtce.json'));
        } else {
            $this->json = array('app' => 'RJPH', 'status' => self::OFF);
        }
    }
    public function run($args)
    {
        $status = isset($args[0]) ? $args[0] : self::OFF;

        if (!in_array($status, array_keys($this->allowedStatus))) $status = self::OFF;

        $this->json->status = $this->allowedStatus[$status];

        $this->updateJsonFile();
        
        echo "{$this->json->app} maintenance mode has been set to {$status}" . PHP_EOL;
    }    
    protected function updateJsonFile()
    {
        file_put_contents($this->path . '/_mtce.json', json_encode($this->json));
    }
}