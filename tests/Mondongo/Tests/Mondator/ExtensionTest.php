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

namespace Mondongo\Tests\Mondator;

use Mondongo\Tests\PHPUnit\TestCase;
use Mondongo\Mondator\Definition\Container;
use Mondongo\Mondator\Extension;

class ExtensionTesting extends Extension
{
    protected $options = array(
        'foo' => 'bar',
        'bar' => 'foo',
    );

    protected function doProcess()
    {
    }
}

class ExtensionTest extends TestCase
{
    public function testConstructorOptions()
    {
        $extension = new ExtensionTesting();
        $this->assertSame(array('foo' => 'bar', 'bar' => 'foo'), $extension->getOptions());

        $extension = new ExtensionTesting(array('foo' => 'foobar'));
        $this->assertSame(array('foo' => 'foobar', 'bar' => 'foo'), $extension->getOptions());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorOptionNotExists()
    {
        new ExtensionTesting(array('foobar' => 'barfoo'));
    }

    public function testHasOption()
    {
        $extension = new ExtensionTesting();
        $this->assertTrue($extension->hasOption('foo'));
        $this->assertFalse($extension->hasOption('foobar'));
    }

    public function testSetOption()
    {
        $extension = new ExtensionTesting();
        $extension->setOption('foo', 'barfoo');
        $this->assertEquals('barfoo', $extension->getOption('foo'));
        $this->assertEquals('foo', $extension->getOption('bar'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetOptionNotExists()
    {
        $extension = new ExtensionTesting();
        $extension->setOption('foobar', 'barfoo');
    }

    public function testGetOptions()
    {
        $extension = new ExtensionTesting();
        $this->assertSame(array('foo' => 'bar', 'bar' => 'foo'), $extension->getOptions());
    }

    public function testGetOption()
    {
        $extension = new ExtensionTesting();
        $this->assertEquals('bar', $extension->getOption('foo'));
        $this->assertEquals('foo', $extension->getOption('bar'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetOptionNotExists()
    {
        $extension = new ExtensionTesting();
        $extension->getOption('foobar');
    }
}