<div class="pagetitle">
    <h1>{{ $breadcrumbs['title'] }}</h1>
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
