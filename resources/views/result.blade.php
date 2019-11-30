<ul>
    <p>{{$film->title}}</p>
    <p>{{$film->year}}</p>
    <p>{{$film->plot}}</p>
    <img src="{{$film->poster}}"/>
    <ul>
    @foreach (json_decode($film->actors, true) as $actor)
        <li>{{$actor}}</li>
    @endforeach
    </ul>
</ul>
