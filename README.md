# JinyPHP Theme for Laravel
`JinyPHP Theme`는 라라벨 프레임워크상에서 테마 레이아웃을 사용할 수 있도록 제공하는 확장 페키지 입니다. 

## 설치
컴포저를 이용하여 `theme`를 설치합니다.

```php
composer require jiny/theme
```

## 설정
환경설정을 패키지에서 복사하여 설치를 합니다. 다음과 같이 콘솔창에서 입력하세요.

```
php artisan vendor:publish --provider="Jiny\Theme\JinyThemeServiceProvider"
```



## 테마 만들기
먼저 라라벨 뷰 리소스를 관리하는 `resources/view`폴더에 새로운 `theme` 폴더를 생성합니다.
`theme`페키지는 `vendor/name` 형태로 복수의 테마를 관리 합니다. 

셈플 테마는 패키지의 소스의 `sample` 폴더를 참조합니다. 테마는 크게 몇개의 파일로 구성됩니다.
* app.blade.php => html 골격을 관리하는 파일입니다.
* layout.blade.php => 전체 공용으로 적용되는 레이아웃을 관리합니다.
* main.blade.php => 메인 컨덴츠 내용을 관리합니다.


## 사용방법
지니PHP 테마는 라라벨 컴포넌트 기술을 이용하여 테마를 관리합니다.  
블레이드 문법에서 `<x-theme>`테그를 이용하여 사이트의 외형을 일관적으로 유지 관리 가능합니다.

```html
<x-theme name="admin.sidebar">
내용...
</x-theme>
```


