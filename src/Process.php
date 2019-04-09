<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Jiny\Theme;

abstract class Process
{
    /**
     * 템플릿 메소드 패턴
     */
    final public function progress($html)
    {
        return $this->algorithm($this->Theme, $html);
    }

    /**
     * 알고리즘 정의
     */
    abstract protected function algorithm($theme, $html);

    /**
     * 
     */
}