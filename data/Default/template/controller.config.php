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

namespace KryuuTemplateBuilder;

use KryuuTemplateBuilder\Entity\Template\Question;
use KryuuTemplateBuilder\Entity\Template\File;
use KryuuTemplateBuilder\Entity\Template\Variable;

return [
    new Question(
        'Add a standard controller and factory?', 
        'boolean', 
        true, 
        [
            new Question(
                'Please enter the controller name', 
                'variable', 
                [
                    new Variable('{%CONTROLLER_NAME%}', 'IndexController'),
                ], 
                []
            ),
            new File(
                '{%CONTROLLER_NAME%}.php',
                '{%NAMESPACE%}/src/{%NAMESPACE%}/Controller/',
                __TMPL_DIR__ . '/src/DefaultController/DefaultController.tmpl',
                new Variable('{%NAMESPACE_CODE%}', 'namespace {%NAMESPACE%}\Controller;'),
                new Variable('{%USE%}', 'use Zend\Mvc\Controller\AbstractActionController;'),
                new Variable('{%EXTEND%}', 'AbstractActionController'),
                new Variable('{%EXTENDS_CODE%}', ' extends {%EXTEND%}')
            ),
            new File(
                '{%CONTROLLER_NAME%}Factory.php',                    
                '{%NAMESPACE%}/src/{%NAMESPACE%}/Controller/',
                __TMPL_DIR__ . '/src/DefaultControllerFactory/DefaultController.tmpl',
                new Variable('{%NAMESPACE_CODE%}', 'namespace {%NAMESPACE%}\Controller;'),
                new Variable('{%CONTROLLER_FACTORY_NAME%}', '{%CONTROLLER_NAME%}Factory'),
                new Variable('{%USE%}', 'use Zend\ServiceManager\FactoryInterface;'),
                new Variable('{%USE%}', 'use Zend\ServiceManager\ServiceLocatorInterface;'),
                new Variable('{%IMPLEMENT%}', 'FactoryInterface'),
                new Variable('{%IMPLEMENTS_CODE%}', ' implements {%IMPLEMENT%}'),
                new Variable('{%FUNCTIONS%}', file_get_contents(__TMPL_DIR__ . '/src/DefaultControllerFactory/method/createService.tmpl'))
            ),
        ]
    ),
];
