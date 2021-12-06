# JinyPHP Theme for Laravel
`JinyPHP Theme`는 라라벨 프레임워크상에서 테마 레이아웃을 사용할 수 있도록 제공하는 확장 페키지 입니다. 
`theme`페키지는 `resources/view/theme`폴더를 만들고, `vendor/name` 형태로 테마를 관리 합니다. 

## 설치
컴포저를 이용하여 `theme`를 설치합니다.

```php
composer require jiny/theme
```

## 사용방법
지니PHP 테마는 라라벨 컴포넌트 기술을 이용하여 테마를 관리합니다. 블레이드 문법에서 `<x-theme>`테그를 이용하여
사이트의 외형을 일관적으로 유지 관리 가능합니다.

```html
<x-theme theme="admin.sidebar">
내용...
</x-theme>
```


