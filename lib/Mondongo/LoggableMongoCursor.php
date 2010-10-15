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
 * A loggable MongoCursor.
 *
 * @package Mondongo
 * @author  Pablo Díez Pascual <pablodip@gmail.com>
 */
class LoggableMongoCursor extends \MongoCursor
{
    protected $dbName;

    protected $collectionName;

    protected $loggerCallable;

    /**
     * Constructor.
     */
    public function __construct(\Mongo $connection, $ns, array $query = array(), array $fields = array())
    {
        parent::__construct($connection, $ns, $query, $fields);

        list($this->dbName, $this->collectionName) = explode('.', $ns);
    }

    /**
     * Set the logger callable.
     *
     * @param mixed $loggerCallable A PHP callable.
     *
     * @return void
     */
    public function setLoggerCallable($loggerCallable)
    {
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

    /*
     * log.
     */
    protected function log(array $log)
    {
        if ($this->loggerCallable) {
            call_user_func($this->loggerCallable, array_merge(array(
                'database'   => $this->dbName,
                'collection' => $this->collectionName,
            ), $log));
        }
    }

    /*
     * limit.
     */
    public function limit($num)
    {
        $this->log(array(
            'limit' => 1,
            'num'   => $num,
        ));

        parent::limit($num);
    }

    /*
     * skip.
     */
    public function skip($num)
    {
        $this->log(array(
            'skip' => 1,
            'num'  => $num,
        ));

        parent::skip($num);
    }

    /*
     * sort.
     */
    public function sort(array $fields)
    {
        $this->log(array(
            'sort'   => 1,
            'fields' => $fields,
        ));

        parent::sort($fields);
    }
}
