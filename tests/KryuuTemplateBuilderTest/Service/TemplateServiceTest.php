<?php

/* 
 * @license The Ryuu Technology License
 * 
 * Copyright 2014 Ryuu Technology by
 * KatsuoRyuu <anders-github@drake-development.org>.
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * Ryuu Technology shall be visible and readable to anyone using the software
 * and shall be written in one of the following ways: 竜技術, Ryuu Technology
 * or by using the company logo.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * 
 * @link https://github.com/KatsuoRyuu/
 */

namespace KryuuTemplateBuilderTest\Service;

use PHPUnit_Framework_TestCase;
use KryuuTemplateBuilderTest\Bootstrap;
use KryuuTemplateBuilder\Entity\Template\TemplateInterface as TemplateInterface;
use KryuuTemplateBuilder\Template\Builder;

/**
 * @project Ryuu-ZF2
 * @authors shikama
 * @encoding UTF-8
 * @date 2016/03/13 - 0:14:36
 * @package *
 * @todo *
 * @note *
 */

class TemplateServiceTest extends PHPUnit_Framework_TestCase
{
    CONST IFACE_TEMPLATE = 'KryuuTemplateBuilder\Entity\Template\TemplateInterface';
    CONST IFACE_PACKAGE = 'KryuuTemplateBuilder\Entity\PackageInterface';
    
    private $services = [
            'template' => [   
                'alias' => 'template-builder',
                'instance' => 'KryuuTemplateBuilder\Service\TemplateService',
            ]
        ];
    
    /**
     * Scans service manager configuration, returning all services created by factories and invokables
     * @return array
     */
    public function provideServiceList()
    {
        return [$this->services];
    }
    
    /**
     * @return array
     */
    public function provideService()
    {
        $sm = Bootstrap::getServiceManager();
        // test if correct instance is created
        $services[] = [$sm->get($this->services['template']['alias'])];
        return $services;
    }

    /**
     * @dataProvider provideServiceList
     */
    public function testServiceAvailable($service)
    {
        $sm = Bootstrap::getServiceManager();
        // test if service is available in SM
        $this->assertTrue($sm->has($service['alias']));
        // test if correct instance is created
        $this->assertInstanceOf($service['instance'], $sm->get($service['alias'])); 
    }
    
    /**
     * @depends testServiceAvailable
     * @dataProvider provideService
     */
    public function testGetTemplateList($service)
    {
        $templateList = $service->getTemplateList();
        foreach ($templateList as $template) {
            $this->assertInternalType('string', $template);
        }
    }
    
    /**
     * @depends testServiceAvailable
     * @dataProvider provideService
     */
    public function testGetTemplate($service)
    {
        $templateList = $service->getTemplateList();
        foreach ($templateList as $template) {
            $tmp = $service->getTemplate($template);
            $this->assertInstanceOf(self::IFACE_TEMPLATE, $tmp);
            
        }
    }
    
    /**
     * @dataProvider provideService
     */
    public function testTemplateBuilding($service)
    {
        $templateList = $service->getTemplateList();
        $this->assertGreaterThan(0, count($templateList));
        $templateName = $templateList[0];
        $template = $service->getTemplate($templateName);
        $this->assertInstanceOf(self::IFACE_TEMPLATE, $template);
        $package = $service->buildTemplate($template);
        $this->assertInstanceOf(self::IFACE_PACKAGE, $package);
    }
    
    /**
     * 
     * @dataProvider provideService
     */
    public function testInstall($service)
    {
        $templateList = $service->getTemplateList();
        $this->assertGreaterThan(0, count($templateList));
        $templateName = $templateList[0];
        $template = $service->getTemplate($templateName);
        $this->assertInstanceOf(self::IFACE_TEMPLATE, $template);
        $package = $service->buildTemplate($template);
        $this->assertInstanceOf(self::IFACE_PACKAGE, $package);
        $service->install($package);
        foreach ($package->getFiles() as $path => $content) {
            $this->assertTrue(file_exists($package->getPath() . $path));
            $this->assertEquals($content, file_get_contents($package->getPath() . $path));
        }
    }
}
