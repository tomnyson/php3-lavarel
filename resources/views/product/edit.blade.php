@extends('layout')
@section('content')
<div class="container">
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
        {{$error}}
    </div>
    <br />
    @endforeach
    <a href="{{route('categories.index')}}" class="btn btn-info">List</a>
    <h3>Sửa Danh mục</h3>
    <form method="post" action="{{route('categories.update', $category->id)}}">
        @csrf
        @method('PUT')
        <input class="form-control" placeholder="enter name" type="text" name="name" value="{{$category->name}}">
        <input class="form-control mt-3" placeholder="enter name" type="text" name="description" value="{{$category->description}}">
        <input type="submit" class="btn btn-primary mt-3" value="edit">
    </form>
</div>


@endsection