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
use KryuuTemplateBuilder\Entity\Template\Variable;
use KryuuTemplateBuilder\Entity\Template\Shell;

return [
    new Question(
        'Module name',
        'varchar',
        [
            new Variable('{%MODULE_NAME%}', 'MyModule'),
        ],
        []
    ),
    new Question(
        'Author name',
        'varchar',
        [
            new Variable('{%AUTHOR_NAME%}', 'MyName'),
        ],
        []
    ),
    new Question(
        'Author alias',
        'varchar',
        [
            new Variable('{%AUTHOR_ALIAS%}', 'MyAlias'),
        ],
        []
    ),
    new Question(
        'Website',
        'varchar',
        [
            new Variable('{%WEBSITE%}', 'http://github.com/{%MyName%}'),
        ],
        []
    ),
    new Question(
        'Email',
        'varchar',
        [
            new Variable('{%EMAIL%}', '{%AUTHOR_ALIAS%}@somedomain.invalid'),
        ],
        []
    ),
    new Question(
        'Use license',
        'boolean',
        true,
        [
            new Variable(
                '{%LICENSE%}',
                file_get_contents(__DIR__ . '/../license/License.tmpl'),
                null
            ),
        ]
    ),
    new Variable('{%MODULE_PREFIX%}', 'Kryuu'),
    new Variable(
        '{%LC_NAMESPACE%}',
        '{%MODULE_NAME%}',
        null,
        [
            [
                'function'      => 'lcfirst',
                'subject'       => '{$subject}',
            ],[
                'function'      => 'str_replace',
                'search'        => ['-','_','.'],
                'replace'       => ' ',
                'subject'       => '{$subject}',
            ],[
                'function'      => 'ucwords',
                'subject'       => '{$subject}',
                'delimiters'    => ' \t\r\n\f\v',
            ],[
                'function'      => 'str_replace',
                'search'        => ' ', 
                'replace'       => '',
                'subject'       => '{$subject}',
            ],[
                'function'      => 'preg_replace',
                'pattern'       => '/(?<!^)((?<![[:upper:]])[[:upper:]]|[[:upper:]](?![[:upper:]]))/',
                'replace'       => '_$1',
                'subject'       => '{$subject}',
            ],[
                'function'      => 'strtolower',
                'subject'       => '{$subject}',
            ]
        ]
    ),
    new Variable(
        '{%VIEW_NAMESPACE%}',
        '{%MODULE_NAME%}',
        null,
        [
            [
                'function'      => 'lcfirst',
                'subject'       => '{$subject}',
            ],[
                'function'      => 'str_replace',
                'search'        => ['-','_','.'],
                'replace'       => ' ',
                'subject'       => '{$subject}',
            ],[
                'function'      => 'ucwords',
                'subject'       => '{$subject}',
                'delimiters'    => ' \t\r\n\f\v',
            ],[
                'function'      => 'str_replace',
                'search'        => ' ', 
                'replace'       => '',
                'subject'       => '{$subject}',
            ],[
                'function'      => 'preg_replace',
                'pattern'       => '/(?<!^)((?<![[:upper:]])[[:upper:]]|[[:upper:]](?![[:upper:]]))/',
                'replace'       => '-$1',
                'subject'       => '{$subject}',
            ],[
                'function'      => 'strtolower',
                'subject'       => '{$subject}',
            ]
        ]
    ),
    new Variable('{%NAMESPACE%}', '{%MODULE_PREFIX%}{%MODULE_NAME%}'),
    new Variable('{%NAMESPACE_CODE%}', 'namespace {%NAMESPACE%};'),
    new Variable('{%START_PHP%}', '<?php'),
    new Question(
        'Install after finishing',
        'boolean',
        true,
        [
            new Shell('echo "Lets do some installations"'),
        ]
    ),
];
