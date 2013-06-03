<?php

namespace Puphpet\Tests\Helpers\PostStructures;

class Nginx implements PostStructuresInterface
{
    /**
     * @return array
     */
    public function getDefault()
    {
        return [
            'vhosts'  => [
                1 => [
                    'servername'    => 'awesome.dev',
                    'serveraliases' => '',
                    'docroot'       => '/var/www/',
                    'port'          => '80',
                    'envvars'       => '',
                ],
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
        return [
            'vhosts'  => [
                1 => [
                    'servername'    => 'awesome.dev',
                    'serveraliases' => 'www.awesome.dev,test.awesome.dev',
                    'docroot'       => '/var/www/awesome.dev',
                    'port'          => '80',
                    'envvars'       => 'IS_TEST yes,IS_AWESOME yes',
                ],
                2 => [
                    'servername'    => 'foo.dev',
                    'serveraliases' => 'www.foo.dev,test.foo.dev',
                    'docroot'       => '/var/www/foo.dev',
                    'port'          => '80',
                    'envvars'       => 'IS_TEST yes,IS_AWESOME yes',
                ]
            ],
        ];
    }

    public function getInvalid()
    {
        //
    }
}
