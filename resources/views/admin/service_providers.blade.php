<h1>Service Providers</h1>

@foreach($providers as $provider)
    <p>{{ $provider->fname }} {{ $provider->lname }}</p>
@endforeach