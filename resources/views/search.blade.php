<html>
<body>
    <form action="{{route('search')}}" method="post">
        @csrf
        <input type="text" name="title"/>
        <input type="submit" value="search"/>
    </form>
    @foreach ($films as $film)
        <img src="{{$film->poster}}"/>
    @endforeach
</body>
</html>
