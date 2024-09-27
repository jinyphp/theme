<div>
    @if($row)
    <div class="d-flex justify-content-between">
        <div class="d-flex gap-2">
            <a href="javascript:history.back();">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                    <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z"/>
                </svg>
            </a>
            <h1 class="h3">{{$row->title}}</h1>
        </div>
        <div>
            <button wire:click="edit('{{$row->id}}')" class="btn btn-info">Edit</button>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-8">
            @if($row->image)
            <div>
                <img class="card-img-top" src="{{$row->image}}">
            </div>
            @endif

        </div>
        <div class="col-4">
            <p>
                {{$row->subtitle}}
            </p>

            <div class="d-flex justify-content-between py-2 border-bottom">
                <div>
                    author:
                </div>
                <div>
                    {{$row->author}}
                </div>
            </div>

            <div class="d-flex justify-content-between py-2 border-bottom">
                <div>
                    version:
                </div>
                <div>
                    {{$row->version}}
                </div>
            </div>

            <div class="d-flex justify-content-between py-2 border-bottom">
                <div>
                    category:
                </div>
                <div>
                    {{$row->category}}
                </div>
            </div>

            <div class="d-flex justify-content-between py-2 border-bottom">
                <div>
                    vote:
                </div>
                <div>
                    {{$row->vote}}
                </div>
            </div>

            <div class="d-flex justify-content-between py-2 border-bottom">
                <div>
                    reviews:
                </div>
                <div>
                    {{$row->reviews}}
                </div>
            </div>

            <div class="my-8">
                <button class="btn btn-primary gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                    </svg>
                    <span>
                        Download
                    </span>
                </button>
            </div>

        </div>
    </div>
    <div class="mt-4">
        <x-markdown>
            {{$row->content}}
        </x-markdown>
    </div>

    @else
    <div>
        등록되지 않는 테마 코드 입니다.
    </div>
    @endif

    <!-- 팝업 데이터 수정창 -->
    @if ($popupForm)
        @includeIf("jiny-wire-table::table_popup_forms.popup_forms")
    @endif
</div>
