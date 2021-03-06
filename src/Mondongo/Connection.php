<?php

/*
 * Copyright 2010 Pablo Díez Pascual <pablodip@gmail.com>
 *
 * This file is part of Mondongo.
 *
 * Mondongo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Mondongo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Mondongo. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Mondongo;

/**
 * Connection.
 *
 * @package Mondongo
 * @author  Pablo Díez Pascual <pablodip@gmail.com>
 */
class Connection
{
    protected $server;
    protected $database;
    protected $options;

    protected $loggerCallable;
    protected $logDefault;

    protected $mongo;
    protected $mongoDB;

    /**
     * Constructor.
     *
     * @param string $server   The server.
     * @param string $database The database name.
     * @param string $options  The \Mongo options.
     *
     * @return void
     */
    public function __construct($server, $database, array $options = array())
    {
        $this->server   = $server;
        $this->database = $database;
        $this->options  = $options;
    }

    /**
     * Set the logger callable.
     *
     * @param mixed $loggerCallable The logger callable.
     *
     * @throws \RuntimeException When the connection has the Mongo already.
     */
    public function setLoggerCallable($loggerCallable = null)
    {
        if (null !== $this->mongo) {
            throw new \RuntimeException('The connection has already Mongo.');
        }

        $this->loggerCallable = $loggerCallable;
    }

    /**
     * Returns the logger callable.
     *
     * @return mixed The logger callable.
     */
    public function getLoggerCallable()
    {
        return $this->loggerCallable;
    }

    /**
     * Set the log default.
     *
     * @param array $logDefault The log default.
     *
     * @throws \RuntimeException When the connection has the Mongo already.
     */
    public function setLogDefault(array $logDefault)
    {
        if (null !== $this->mongo) {
            throw new \RuntimeException('The connection has already Mongo.');
        }

        $this->logDefault = $logDefault;
    }

    /**
     * Returns the log default.
     *
     * @return array|null The log default.
     */
    public function getLogDefault()
    {
        return $this->logDefault;
    }

    /**
     * Returns the mongo connection object.
     *
     * @return \Mongo The mongo collection object.
     */
    public function getMongo()
    {
        if (null === $this->mongo) {
            if (null !== $this->loggerCallable) {
                $this->mongo = new \Mondongo\Logger\LoggableMongo($this->server, $this->options);
                $this->mongo->setLoggerCallable($this->loggerCallable);
                if (null !== $this->logDefault) {
                    $this->mongo->setLogDefault($this->logDefault);
                }
            } else {
                $this->mongo = new \Mongo($this->server, $this->options);
            }
        }

        return $this->mongo;
    }

    /**
     * Returns the database object.
     *
     * @return \MongoDB The database object.
     */
    public function getMongoDB()
    {
        if (null === $this->mongoDB) {
            $this->mongoDB = $this->getMongo()->selectDB($this->database);
        }

        return $this->mongoDB;
    }
}
