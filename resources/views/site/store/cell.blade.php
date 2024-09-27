<div>
    <div>
        @if(isset($item['image']))
        <a href="/themes/{{$item['code']}}">
            <img class="card-img-top" src="{{$item['image']}}">
        </a>
        @endif
    </div>

    <div class="mt-2">
        <a href="/themes/{{$item['code']}}">
            @if(isset($item['title']))
                {{$item['title']}}
            @endif
        </a>
    </div>
</div>
