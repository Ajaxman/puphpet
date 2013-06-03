<?php

namespace Puphpet\Tests\Helpers\PostStructures;

class PHP implements PostStructuresInterface
{
    /**
     * @return array
     */
    public function getDefault()
    {
        return [
            'version' => [
                'php54' => '1',
            ],
            'modules' => [
                'composer' => [
                    'installed' => '1',
                ],
                'php'      => [
                    'php5-cli',
                    'php5-curl',
                    'php5-intl',
                    'php5-mcrypt',
                ],
                'pear'     => [
                    'installed' => '1',
                ],
                'xdebug'   => [
                    'installed'        => '1',
                    'remote_autostart' => '0',
                    'remote_port'      => '9000',
                ],
                'xhprof'   => [
                    'installed' => '1',
                ]
            ],
            'inilist' => [
                'php'    => [
                    'date.timezone' => 'America/Chicago',
                ],
                'custom' => 'display_errors = On,error_reporting = -1',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getBare()
    {
        return [
            'modules' => [
                'xdebug' => [
                    'remote_autostart' => '',
                    'remote_port'      => '',
                ]
            ],
            'inilist' => [
                'php'    => [
                    'date.timezone' => 'America/Chicago',
                ],
                'custom' => '',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getComplete()
    {
        return [
            'version' => [
                'php54' => '1',
            ],
            'modules' => [
                'composer' => [
                    'installed' => '1',
                ],
                'php'      => [
                    'php5-cli',
                    'php5-curl',
                    'php5-intl',
                    'php5-mcrypt',
                ],
                'pear'     => [
                    'installed' => '1',
                    'Auth_SASL2',
                    'OpenID',
                ],
                'pecl'     => [
                    'courierauth',
                    'krb5',
                ],
                'xdebug'   => [
                    'installed'        => '1',
                    'remote_autostart' => '0',
                    'remote_port'      => '9000',
                ],
                'xhprof'   => [
                    'installed' => '1',
                ]
            ],
            'inilist' => [
                'php'    => [
                    'date.timezone' => 'America/Chicago',
                ],
                'custom' => 'display_errors = On,error_reporting = -1',
            ],
        ];
    }

    public function getInvalid()
    {
        //
    }
}
