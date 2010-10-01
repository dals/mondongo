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

namespace Mondongo\Tests\Type;

use Mondongo\Tests\PHPUnit\TestCase;
use Mondongo\Type\RawType;

class RawTypeTest extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function testToMongo($value)
    {
        $type = new RawType();
        $this->assertSame($value, $type->toMongo($value));
    }

    /**
     * @dataProvider provider
     */
    public function testToPHP($value)
    {
        $type = new RawType();
        $this->assertSame($value, $type->toPHP($value));
    }

    /**
     * @dataProvider provider
     */
    public function testToMongoInString($value)
    {
        $type = new RawType();
        $function = $this->getTypeFunction($type->toMongoInString());

        $this->assertSame($value, $function($value));
    }

    /**
     * @dataProvider provider
     */
    public function testToPHPInString($value)
    {
        $type = new RawType();
        $function = $this->getTypeFunction($type->toPHPInString());

        $this->assertSame($value, $function($value));
    }

    public function provider()
    {
        return array(
            array(array('foo' => 'bar')),
            array(new \DateTime()),
        );
    }
}
