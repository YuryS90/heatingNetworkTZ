<?php

namespace Common;

use DI\DependencyException;
use DI\NotFoundException;
use ErrorException;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

trait CommonTrait
{
    private $container;

    public function __construct(\DI\Container $container)
    {
        $this->container = $container;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __get($name)
    {
        if (!$this->container->has($name)) {
            return null;
        }

        return $this->container->get($name);
    }

    public function __set($name, $value)
    {
        $this->container->set($name, $value);
    }

    /**
     * @throws ErrorException
     */
    public function dd(...$data)
    {
        $cloner = new VarCloner();

        $cloner->setMaxItems(-1);

        $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();

        foreach ($data as $var) {

            $data = $cloner->cloneVar($var);
            $dumper->dump($data);
        }
        exit;
    }
}