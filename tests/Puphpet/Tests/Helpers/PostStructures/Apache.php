<?php

namespace Puphpet\Tests\Helpers\PostStructures;

class Apache implements PostStructuresInterface
{
    /**
     * @return array
     */
    public function getDefault()
    {
        return [
            'modules' => [
                'rewrite',
            ],
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
        return array_merge(
            $this->getDefault(),
            ['modules' => array()]
        );
    }

    /**
     * @return array
     */
    public function getComplete()
    {
        return [
            'modules' => [
                'rewrite',
                'actions',
            ],
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
