<div class="pagetitle">
    <div class="d-flex">
        <h1>
            {{ $breadcrumbs['title'] }}
        </h1>
        <h5 class="w-100 text-center">
            SIMETRIS (SISTEM INFORMASI MEMO DAN SURAT MASUK TERINTEGRASI)
        </h5>
    </div>
    <nav>
        <ol class="breadcrumb">
            @foreach ($breadcrumbs['list'] as $breadcrumb)
                @if ($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] }}</li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
</div>
