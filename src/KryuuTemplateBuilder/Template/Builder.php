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

use KryuuTemplateBuilder\Entity\Template\File;
use KryuuTemplateBuilder\Entity\Template\TemplateInterface;
use KryuuTemplateBuilder\Entity\Template\GroupInterface;
use KryuuTemplateBuilder\Entity\Template\VariableInterface;
use KryuuTemplateBuilder\Entity\Template\QuestionInterface;
use KryuuTemplateBuilder\Entity\Template\FileInterface;
use KryuuTemplateBuilder\Entity\Template\ShellInterface;
use KryuuTemplateBuilder\Entity\Build;
use KryuuTemplateBuilder\Entity\Package;
use Zend\Stdlib\ArrayUtils;

/**
 * @project Ryuu-ZF2
 * @authors spawn
 * @encoding UTF-8
 * @date Apr 7, 2016 - 12:21:29 AM
 * @package *
 * @todo *
 * @depends *
 * @note *
 */

class Builder
{    
    private $build = null;
    private $buildStack = [];
    private $current = null;
    
    /**
     * 
     * @param TemplateInterface $template
     * @return BuildInterface;
     */
    public function build(TemplateInterface $template)
    {
        $this->build = new Build();
        
        $this->current = $this->build;
             
        $this->reader($template);
        
        $files = $this->insertVariables();
        
        $commands = $this->build->getShellCommands()->toArray();
        
        $package = new Package();
        $package->setFiles($files);
        $package->setCommands($commands);
        
        return $package;
    }
    
    private function reader($contents)
    {
        $contents = is_array($contents) ? $contents : [$contents];
        foreach ($contents as $content) {
            if ($content instanceof TemplateInterface) {
                $this->reader($content->getAll());
            } elseif ($content instanceof GroupInterface) {
                $this->reader($content->getAll());
            } elseif ($content instanceof QuestionInterface) {
                $this->readQuestion($content);
            } elseif ($content instanceof VariableInterface) {
                $this->readVariable($content);
            } elseif ($content instanceof FileInterface) {
                $this->readFile($content);
            } elseif ($content instanceof ShellInterface) {
                $this->readShellCommand($content);
            }
        }
    }
    
    private function readQuestion(QuestionInterface $question)
    {
        $default = $question->getDefault();
        if ($question->getType() == 'boolean') {
            if ($default == true) {
                $this->reader($question->getTemplates());
            }
        } else {
            if (empty($question->getTemplates())) {
                $this->reader($default);
            } else {
                $this->reader($question->getTemplates());
            }
        }
    }
    
    private function readVariable(VariableInterface $variable)
    {
        $content = $variable->getContent();
        $alter = $variable->getAlter();
        if (preg_match('/\{%[A-Z_]+%\}/', $content)) {
            $content = $this->replacements(
                    $this->getSearchArray(),
                    $this->getReplaceArray(), 
                    $content
                );
        }
        $cleanContent = $this->alterVar($content, $alter);
        $this->current->addVariable($cleanContent, $variable->getName(), $variable->getDelimiter());
    }
    
    private function readFile(FileInterface $file)
    {
        $this->buildStack[] = $this->current;
        $this->current = new File();
        $this->build->addFile($this->current);
        $this->current->setName($this->replacements(
                $this->getSearchArray(), 
                $this->getReplaceArray(), 
                $file->getName()
        ));
        $this->current->setPath($this->replacements(
                $this->getSearchArray(), 
                $this->getReplaceArray(), 
                $file->getPath()
        ));
        $this->current->setContent($file->getContent());
        end($this->buildStack);
        $parent = prev($this->buildStack);
        if ($parent instanceof File) {
            foreach ($parent->getVariables() as $variable) {
                $this->reader($variable);
            }
        }
        foreach($file->getVariables() as $variable) {
            $this->reader($variable);
        }
        if ($parent instanceof File) {
            end($this->buildStack);
            unset($this->buildStack[key($this->buildStack)]);
            $this->current = $parent;
        } else {
            $this->buildStack = [];
            $this->current = $this->build;
        }
    }
    
    private function readShellCommand(ShellInterface $shell)
    {
        $commands = $shell->getCommands()->toArray();
        foreach ($commands as $command) {
            $this->build->addShellCommand(
                    $this->replacements(
                            $this->getSearchArray(), 
                            $this->getReplaceArray(), 
                            $command)
                    );
        }
    }
    
    private function alterVar($content, $alters)
    {
        if (!empty($alters)) {
            foreach ($alters as $alter) {
                $function = $alter['function'];
                $alter['subject'] = $content;
                unset($alter['function']);
                $params = $this->mergeParam($alter);
                $code = '$content = ' . $function . '(' . implode(', ', $params) . ');';
                eval($code);
            }
        }
        
        return $content;
    }
    
    private function mergeParam($params)
    {
        $cleanParams = [];
        foreach ($params as $param) {
            if (is_array($param)) {
                $cleanParams[] = var_export($param, true);
            } else {
                $cleanParams[] = '\'' . addslashes($param) . '\'';
            }
        }
        
        return $cleanParams;
    }
    
    private function insertVariables()
    {
        $files = [];
        foreach ($this->build->getFiles() as $file) {
            $this->current = $file;
            $filePath = $file->getPath() . $file->getName();
            
            $files[$filePath] = $this->replacements(
                    $this->getSearchArray(), 
                    $this->getReplaceArray(), 
                    $file->getContent()
                );
        }
        
        return $files;
    }
    
    private function replacements($search, $replace, $content)
    {
        $content = str_replace($search, $replace, $content);
        preg_match_all('/(?P<var>\{%[A-Z_]+%\})/', $content, $matches);
        if (isset($matches['var'])) {
            foreach ($matches['var'] as $var) {
                if (!in_array($var, $search)) {
                    $search[] = $var;
                    $replace[] = '';
                }
            }
        }
        if (preg_match('/\{%[A-Z_]+%\}/', $content)) {
            return $this->replacements($search, $replace, $content);
        }
        
        return $content;
    }
    
    private function getSearchArray()
    {   
        $replace = ArrayUtils::merge($this->build->getVariables()->toArray(),
                $this->current->getVariables()->toArray());
        return array_keys($replace);
    }
    
    private function getReplaceArray()
    {
        $tmp = ArrayUtils::merge($this->build->getVariables()->toArray(), 
                $this->current->getVariables()->toArray());
        return $tmp;
    }
}
