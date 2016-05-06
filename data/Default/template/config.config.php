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
    new File(
        'module.config.php',
        '{%NAMESPACE%}/config/',
        __TMPL_DIR__ . '/config/module.config.tmpl'
    ),
    new Question(
        'Add BjyAuthorize', 
        'boolean', 
        true, 
        [
            new Variable(
                '{%CONFIG_INCLUDE%}', 
                '    \'bjyauthorize\' => include(\'bjyauthorize.config.php\')', 
                null, 
                null
            ),
            new File(
                'bjyauthorize.config.php',
                '{%NAMESPACE%}/config/',
                __TMPL_DIR__ . '/config/bjyauthorize.config.tmpl'
            )
            
        ]
    ),
    new Question(
        'Add Router', 
        'boolean', 
        true, 
        [
            new Variable(
                '{%CONFIG_INCLUDE%}', 
                '    \'router\' => include(\'router.config.php\')', 
                null, 
                null
            ),
            new File(
                'router.config.php',
                '{%NAMESPACE%}/config/',
                __TMPL_DIR__ . '/config/router.config.tmpl'
            )
            
        ]
    ),
    new Question(
        'Add Navigation', 
        'boolean', 
        true, 
        [
            new Variable(
                '{%CONFIG_INCLUDE%}', 
                '    \'navigation\' => include(\'navigation.config.php\')', 
                null, 
                null
            ),
            new File(
                'navigation.config.php',
                '{%NAMESPACE%}/config/',
                __TMPL_DIR__ . '/config/navigation.config.tmpl'
            )
            
        ]
    ),
    new Question(
        'Add Service Manager', 
        'boolean', 
        true, 
        [
            new Variable(
                '{%CONFIG_INCLUDE%}', 
                '    \'service_manager\' => include(\'servicemanager.config.php\')', 
                null, 
                null
            ),
            new File(
                'servicemanager.config.php',
                '{%NAMESPACE%}/config/',
                __TMPL_DIR__ . '/config/servicemanager.config.tmpl'
            )
            
        ]
    ),
    new Question(
        'Add Controller', 
        'boolean', 
        true, 
        [
            new Variable(
                '{%CONFIG_INCLUDE%}', 
                '    \'controller\' => include(\'controller.config.php\')', 
                null, 
                null
            ),
            new File(
                'controller.config.php',
                '{%NAMESPACE%}/config/',
                __TMPL_DIR__ . '/config/controller.config.tmpl'
            )
            
        ]
    ),
    new Question(
        'Add Console', 
        'boolean', 
        true, 
        [
            new Variable(
                '{%CONFIG_INCLUDE%}', 
                '    \'console\' => include(\'console.config.php\')', 
                null, 
                null
            ),
            new File(
                'console.config.php',
                '{%NAMESPACE%}/config/',
                __TMPL_DIR__ . '/config/console.config.tmpl'
            )
            
        ]
    ),
    new Question(
        'Add View Manager', 
        'boolean', 
        true, 
        [
            new Variable(
                '{%CONFIG_INCLUDE%}', 
                '    \'view_manager\' => include(\'viewmanager.config.php\')', 
                null, 
                null
            ),
            new File(
                'viewmanager.config.php',
                '{%NAMESPACE%}/config/',
                __TMPL_DIR__ . '/config/viewmanager.config.tmpl'
            )
            
        ]
    ),
    new Question(
        'Add View Helper', 
        'boolean', 
        true, 
        [
            new Variable(
                '{%CONFIG_INCLUDE%}', 
                '    \'view_helper\' => include(\'viewhelper.config.php\')', 
                null, 
                null
            ),
            new File(
                'viewhelper.config.php',
                '{%NAMESPACE%}/config/',
                __TMPL_DIR__ . '/config/viewhelper.config.tmpl'
            )
            
        ]
    )
];
