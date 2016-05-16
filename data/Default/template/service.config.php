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
        'Need a Default Service Factory?', 
        'boolean', 
        true, 
        [    
            new Question(
                'Service Name?', 
                'Variable', 
                [
                    new Variable('{%SERVICE_NAME%}', 'Service'),
                ], 
                []
            ),
            new File(
                '{%SERVICE_NAME%}.php',
                '{%NAMESPACE%}/src/{%NAMESPACE%}/service/',
                __TMPL_DIR__ . '/src/Service/Service.tmpl',
                new Variable('{%NAMESPACE_CODE%}', 'namespace {%NAMESPACE%}\Service;'),   
                new Question(
                    'Need default Constructor?', 
                    'boolean', 
                    true,
                    [
                        new Variable('{%FUNCTIONS%}', file_get_contents(__TMPL_DIR__ . '/src/Service/method/__construct.tmpl'))
                    ]
                )
            ),
            new File(
                '{%SERVICE_NAME%}Factory.php',
                '{%NAMESPACE%}/src/{%NAMESPACE%}/Factory/Service/',
                __TMPL_DIR__ . '/src/Service/Service.tmpl',
                new Variable('{%NAMESPACE_CODE%}', 'namespace {%NAMESPACE%}\Factory\Service;'),
                new Variable('{%SERVICE_NAME%}', '{%SERVICE_NAME%}Factory'),
                new Variable('{%SERVICELOCATOR_INTERFACE%}', 'ServiceLocatorInterface'),
                new Variable('{%FUNCTIONS%}', file_get_contents(__TMPL_DIR__ . '/src/ServiceFactory/method/createService.tmpl'), null, null, PHP_EOL),
                new Variable('{%USE%}', 'use Zend\ServiceManager\FactoryInterface;',null,null,PHP_EOL),
                new Variable('{%USE%}', 'use Zend\ServiceManager\ServiceLocatorInterface;',null,null,PHP_EOL),
                new Variable('{%IMPLEMENT%}', 'FactoryInterface', null, null, ','.PHP_EOL.'    '),
                new Variable('{%IMPLEMENTS%}', ' implements {%IMPLEMENT%} ',null,null,'\R')
            )
        ]
    ),
];

