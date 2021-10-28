<?php
namespace Jiny\Theme;

class Tag
{
    public $tagname;
    public $dom = [];
    public $item = [];
    public $pos;
    public $next;
    public $len;
    public $text;
    public $attr = [];
    public $pare = false;
}