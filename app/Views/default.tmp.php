@include 'default-layout'

@section('title') Ana Sayfa @endsection


@section('body')

    <h1>Ana Sayfa</h1>
    <form action="deneme" method="POST">
        @csrf
        <input type="text" name="text">
        <input type="text" name="text2">
        <button type="submit"> test </button>
    </form>
    <br><br><br><br><br>

    @foreach($users as $user)
    <p>{{$user['name']}}</p>
    @endforeach
@endsection
