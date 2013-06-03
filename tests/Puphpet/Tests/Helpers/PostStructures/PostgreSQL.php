<?php

namespace Puphpet\Tests\Helpers\PostStructures;

class PostgreSQL implements PostStructuresInterface
{
    /**
     * @return array
     */
    public function getDefault()
    {
        return [
            'root'   => '',
            'dbuser' => [
                '1' => [
                    'privileges' => [
                        'ALL',
                    ],
                    'user'     => '',
                    'password' => '',
                    'dbname'   => '',
                    'host'     => 'localhost',
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
            'root'   => 'test123',
            'dbuser' => [
                '1' => [
                    'privileges' => [
                        'ALL',
                    ],
                    'user'     => 'testuser',
                    'password' => 'testpass',
                    'dbname'   => 'testdatabase',
                    'host'     => 'localhost',
                ],
                '2' => [
                    'privileges' => [
                        'SELECT',
                        'INSERT',
                        'UPDATE',
                    ],
                    'user'     => 'testuser2',
                    'password' => 'testpass2',
                    'dbname'   => 'testdatabase2',
                    'host'     => 'localhost2',
                ],
            ],
        ];
    }

    public function getInvalid()
    {
        //
    }
}
