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
        'create Module.php file?', 
        'boolean', 
        true, 
        [
            new Question(
                'support for the old autoloaders?', 
                'boolean', 
                true, 
                [
                    new Variable('{%MODULE_FILE_PATH%}', '/src/{%NAMESPACE%}/'),
                    new File(
                        'Module.php',
                        '{%NAMESPACE%}/',
                        __TMPL_DIR__ . '/src/Module/ModuleNew.tmpl'
                    ),
                ]
            ),
            new File(
                'Module.php',                    
                '{%NAMESPACE%}/{%MODULE_FILE_PATH%}/',
                __TMPL_DIR__ . '/src/Module/Module.tmpl',
                new Variable('{%NAMESPACE_CODE%}', 'namespace {%NAMESPACE%};'),
                new Question(
                    'Need onBootstrap?', 
                    'boolean', 
                    true, 
                    [
                        new Variable('{%MODULE_FUNCTIONS%}', file_get_contents(__TMPL_DIR__ . '/src/Module/method/onBootstrap.tmpl'), null, null, PHP_EOL),
                        new Variable('{%USE%}', 'use Zend\Mvc\MvcEvent;',null,null,PHP_EOL)
                    ]
                ),
                new Question(
                    'Need getAutoloaderConfig?', 
                    'boolean', 
                    true, 
                    [
                        new Variable('{%MODULE_FUNCTIONS%}', file_get_contents(__TMPL_DIR__ . '/src/Module/method/getAutoloaderConfig.tmpl'), null, null, PHP_EOL),
                        new Variable('{%USE%}', 'use Zend\ModuleManager\Feature\AutoloaderProviderInterface;',null,null,PHP_EOL),
                        new Variable('{%IMPLEMENT%}', 'AutoloaderProviderInterface', null, null, ','.PHP_EOL.'    '),
                        new Variable('{%IMPLEMENTS%}', ' implements {%IMPLEMENT%}',null,null,'\R')
                    ]
                ),
                new Question(
                    'Need getConfig?', 
                    'boolean', 
                    true, 
                    [
                        new Variable('{%MODULE_FUNCTIONS%}', file_get_contents(__TMPL_DIR__ . '/src/Module/method/getConfig.tmpl'), null, null, PHP_EOL),
                        new Variable('{%USE%}', 'use Zend\ModuleManager\Feature\ConfigProviderInterface;',null,null,PHP_EOL),
                        new Variable('{%IMPLEMENT%}', 'ConfigProviderInterface', null, null, ','.PHP_EOL.'    '),
                        new Variable('{%IMPLEMENTS%}', ' implements {%IMPLEMENT%} ',null,null,'\R')
                    ]
                ),
                new Question(
                    'Need getServiceConfig?', 
                    'boolean', 
                    false, 
                    [
                        new Variable('{%MODULE_FUNCTIONS%}', file_get_contents(__TMPL_DIR__ . '/src/Module/method/getServiceConfig.tmpl'), null, null, PHP_EOL),
                        new Variable('{%USE%}', 'use Zend\ModuleManager\Feature\ServiceProviderInterface;',null,null,PHP_EOL),
                        new Variable('{%IMPLEMENT%}', 'ServiceProviderInterface', null, null, ','.PHP_EOL.'    '),
                        new Variable('{%IMPLEMENTS%}', ' implements {%IMPLEMENT%} ',null,null,'\R')
                    ]
                ),
                new Question(
                    'Need getViewHelperConfig?', 
                    'boolean', 
                    false, 
                    [
                        new Variable('{%MODULE_FUNCTIONS%}', file_get_contents(__TMPL_DIR__ . '/src/Module/method/getViewHelperConfig.tmpl'), null, null, PHP_EOL),
                        new Variable('{%USE%}', 'use Zend\ModuleManager\Feature\ViewHelperProviderInterface;',null,null,PHP_EOL),
                        new Variable('{%IMPLEMENT%}', 'ViewHelperProviderInterface', null, null, ','.PHP_EOL.'    '),
                        new Variable('{%IMPLEMENTS%}', ' implements {%IMPLEMENT%} ',null,null,'\R')
                    ]
                ),
                new Question(
                    'Need getConsoleBanner?', 
                    'boolean', 
                    false, 
                    [
                        new Variable('{%MODULE_FUNCTIONS%}', file_get_contents(__TMPL_DIR__ . '/src/Module/method/getConsoleBanner.tmpl'), null, null, PHP_EOL),
                        new Variable('{%USE_CONSOLE%}', 'use Zend\Console\Adapter\AdapterInterface as Console;',null,null,'\R'),
                        new Variable('{%USE%}', 'use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;',null,null,PHP_EOL),
                        new Variable('{%IMPLEMENT%}', 'ConsoleBannerProviderInterface', null, null, ','.PHP_EOL.'    '),
                        new Variable('{%IMPLEMENTS%}', ' implements {%IMPLEMENT%} ',null,null,'\R')
                    ]
                ),
                new Question(
                    'Need getConsoleUsage?', 
                    'boolean', 
                    false, 
                    [
                        new Variable('{%MODULE_FUNCTIONS%}', file_get_contents(__TMPL_DIR__ . '/src/Module/method/getConsoleUsage.tmpl'), null, null, PHP_EOL),
                        new Variable('{%USE_CONSOLE%}', 'use Zend\Console\Adapter\AdapterInterface as Console;',null,null,'\R'),
                        new Variable('{%USE%}', 'use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;',null,null,PHP_EOL),
                        new Variable('{%IMPLEMENT%}', 'ConsoleUsageProviderInterface', null, null, ','.PHP_EOL.'    '),
                        new Variable('{%IMPLEMENTS%}', ' implements {%IMPLEMENT%} ',null,null,'\R')
                    ]
                ),
                    
                new Variable('{%USE%}', '{%USE_CONSOLE%}',null,null,PHP_EOL)
            ),
        ]
    ),
];
