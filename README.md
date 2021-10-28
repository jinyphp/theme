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

## 라이센스
지니PHP는 듀얼라이센스로 운영됩니다. 일반 라이센스는 GPL을 따릅니다. 본 소스를 다운로드 받고, 수정하여 사용할 수 있습니다.
다만, 수정후 동일한 조건으로 코드를 공개해 주셔야 합니다.

지니PHP 프로젝트에 후원사의 경우만, MIT 라이센스를 적용합니다.
기업에 맞게 수정하여 사용이 가능합니다.
