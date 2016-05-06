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

namespace KryuuTemplateBuilder\Template;

use KryuuTemplateBuilder\Entity\PackageInterface;
use KryuuStdLib\FileSystem as Fsys;

/**
 * @project Ryuu-ZF2
 * @authors spawn
 * @encoding UTF-8
 * @date May 4, 2016 - 7:12:28 PM
 * @package *
 * @todo *
 * @depends *
 * @note *
 */

Class Installer
{
    private $dInstallPath = './data/KryuuTemplateBuilder/';
    
    public function install(PackageInterface $package)
    {
        if (!$package->getPath()) {
            $package->setPath($this->dInstallPath . uniqid() . '/');
        }
        Fsys::mkdir($package->getPath());
        foreach ($package->getFiles() as $path => $content) {
            Fsys::mkFileDir($package->getPath() . $path);
            file_put_contents($package->getPath() . $path, $content);
        }
        
        foreach ($package->getCommands() as $command) {
            echo shell_exec($command);
        }
    }
}
