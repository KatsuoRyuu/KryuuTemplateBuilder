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
        'Add default PHPUnit testing facilities?', 
        'boolean', 
        true, 
        [
            new Variable(
                '{%CONFIG_INCLUDE%}', 
                '    \'bjyauthorize\' => include(\'bjyauthorize.config.php\')', 
                null, 
                null
            ),
            new Variable(
                '{%NAMESPACE_TEST%}', 
                '{%NAMESPACE%}Test', 
                null, 
                null
            ),
            new Variable(
                '{%NAMESPACE_TEST_CODE%}', 
                'namespace {%NAMESPACE_TEST%};', 
                null, 
                null
            ),
            new File(
                'Bootstrap.php',
                '{%NAMESPACE%}/tests/',
                __TMPL_DIR__ . '/tests/Bootstrap.tmpl'
            ),
            new File(
                'ModuleDeps.php',
                '{%NAMESPACE%}/tests/',
                __TMPL_DIR__ . '/tests/ModuleDeps.tmpl'
            ),
            new File(
                'phpunit.xml',
                '{%NAMESPACE%}/tests/',
                __TMPL_DIR__ . '/tests/phpunit.xml'
            ),
            new File(
                'config.local.php',
                '{%NAMESPACE%}/tests/config/module/',
                __TMPL_DIR__ . '/tests/config/module/config.local.tmpl'
            ),
        ]
    ),
];
