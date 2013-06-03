<?php

namespace Puphpet\Tests\Helpers\PostStructures;

class Box implements PostStructuresInterface
{
    /**
     * @return array
     */
    public function getDefault()
    {
        return [
            'url'           => 'http://files.vagrantup.com/precise64.box',
            'name'          => 'precise64',
            'ip'            => '192.168.56.101',
            'memory'        => '1024',
            'port_forward'  => [
                'host'  => '',
                'guest' => '',
            ],
            'foldertype'    => 'default',
            'synced_folder' => [
                'source' => './',
                'target' => '/var/www',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getBare()
    {
        return $this->getDefault();
    }

    /**
     * @return array
     */
    public function getComplete()
    {
        return array_merge(
            $this->getDefault(),
            ['port_forward' =>
                [
                    'host'  => 8080,
                    'guest' => 80
                ]
            ]
        );
    }

    public function getInvalid()
    {
        //
    }
}
