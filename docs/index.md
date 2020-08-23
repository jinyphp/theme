# jinyTheme

테마객체 생성

```php
$Theme = new \Jiny\Theme\Theme;
```

헬퍼함수를 통한 객체 생성 및 설정

```php
$Theme = \jiny\theme()->setName($name)->setPath();
```

## 레이아웃 읽기

### layout 파일
레이아웃 html 파일을 읽어 옵니다.
기본적으로 `layout.html` 파일을 읽어 옵니다.

```php
$Theme->layout()->load();
```

만일 다른 파일을 읽어올려고 할때,
```php
$Theme->layout()->load("파일명");
```


### 빈 레이아웃
비어있는 html 레이아웃 파일을 반환합니다. 매개변수로 언어를 설정할 수 있습니다.

```php
$Theme->layout()->empty("ko");
```


### 레이아웃에 값 적용하기

```php
echo \jiny\theme([
    'site'=>"aaaa",
    'function'=>"어드민메뉴",
    'setting'=>"설정"
    ]);
```

`{{키}}` 값형태로 입력된 코드를, 전달되는 배열 인자값으로 변경하여 출력합니다.

### 레이아웃 동적 변경하기
기본적인 레이아웃은 테마에 설정된 값입니다.

특정 페이지만, 별도의 레이아웃을 적용하고자 할 경우에는 2번째 인자값을 사용합니다.

```php
echo \jiny\theme([
    'site'=>"aaaa",
    'function'=>"어드민메뉴",
    'setting'=>"설정"
    ],
    "jiny/layout2");
```
    

