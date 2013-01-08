<?php

namespace kcmerrill\utility;

class checkpoints
{
    private $name;
    private $base_dir;
    private $checkpoint_ext = '.ckpt';
    private $eol;
    public $checkpoints = array();

    public function __construct($name = 'checkpoint' , $base_dir = false)
    {
        $this->setName($name, false);
        $this->setBaseDir($base_dir, false);
        $this->eol = php_sapi_name() == 'cli' ? PHP_EOL : '<br />';
        $this->checkpoints = array();
    }

    public function setBaseDir($base_dir = false)
    {
        if ($base_dir) {
            $this->base_dir = rtrim($base_dir , DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        } else {
            $this->base_dir = getcwd()  .DIRECTORY_SEPARATOR;
        }
        if (!is_dir($this->base_dir . $this->getName())) {
            mkdir($this->base_dir . $this->getName(), 0777, TRUE);
        }
    }

    public function getBaseDir()
    {
        return $this->base_dir;
    }

    public function setName($name, $cleanup = true)
    {
        $this->name = is_string($name) ? rtrim($name, DIRECTORY_SEPARATOR) : 'checkpoint';
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFullFilePath($checkpoint)
    {
        return $this->getBaseDir() . $this->getName() . DIRECTORY_SEPARATOR . $checkpoint . $this->checkpoint_ext;
    }

    protected function execute($checkpoint, $closure)
    {
        $this->checkpoints[] = $closure;
        $file = $this->getFullFilePath($checkpoint);
        if (file_exists($file)) {
           echo 'Checkpoint ' . str_replace($this->checkpoint_ext, '', basename($file)) . ' exists!' . $this->eol;

           return true;
        }
        echo 'Executing ' . $this->getName() . '[' . $checkpoint . ']' . $this->eol;
        ob_start();
        $closure();
        $logs = ob_get_clean();
        file_put_contents($file, $logs);
    }

    public function __call($method, $params = array())
    {
        if (count($params) && $params[0] instanceof Closure) {
            throw new \InvalidArgumentException('Please supply a valid closure.');
        }
        $this->execute($method, $params[0]);
    }
}
