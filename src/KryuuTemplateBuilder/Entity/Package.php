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

namespace KryuuTemplateBuilder\Entity;

use Doctrine\Common\Collections\ArrayCollection as Collection;

/**
 * @project Ryuu-ZF2
 * @authors spawn
 * @encoding UTF-8
 * @date May 4, 2016 - 6:26:01 AM
 * @package *
 * @todo *
 * @depends *
 * @note *
 */

Class Package implements PackageInterface
{    
    private $files;
    
    private $commands;
    
    private $path;
    
    public function __construct()
    {
        $this->files = new Collection();
        $this->commands = new Collection();
    }
    
    public function getFiles()
    {
        return $this->files;
    }

    public function getCommands()
    {
        return $this->commands;
    }
    
    public function getPath()
    {
        return $this->path;
    }

    public function setFiles($files)
    {
        if ($files instanceof Collection) {
            $this->files = $files;
        } elseif (is_array($files)) {
            foreach ($files as $path => $content) {
                $this->files->set($path, $content);
            }
        }
        return $this;
    }

    public function setCommands($commands)
    {
        if ($commands instanceof Collection) {
            $this->commands = $commands;
        } elseif (is_array($commands)) {
            foreach ($commands as $key => $command) {
                $this->commands->set($key, $command);
            }
        }
        return $this;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }



}
