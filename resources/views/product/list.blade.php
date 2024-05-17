@extends('layout')
@section('content')
<div class="container">
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <a href="{{route('products.create')}}" class="btn btn-success mb-3">Create</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $prod)
            <tr>
                <th scope="row">{{$prod->id}}</th>
                <td>{{$prod->name}}</td>
                <td>{{$prod->price}}</td>
                <td><img src="#" class="img-thumbnail" width="100px" /></td>
                <td>
                    <form method="post" action="{{route('products.destroy',[$prod->id])}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">delele</button>
                    </form>
                    <a href="{{route('products.edit',[$prod->id])}}" class="btn btn-info">Edit</a>
                </td>
            </tr>
        </tbody>
        @endforeach
    </table>
    {{$products->onEachSide(5)->links()}}
</div>

@endsection