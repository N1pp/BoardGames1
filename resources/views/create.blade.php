@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="content">
        <form method="POST" action="{{route('createProduct')}}" enctype="multipart/form-data">
            <div class="form-group">
                @csrf
                Введите название:
                <input class="form-control" type="text" name="name">
            </div>
            <div class="form-group">
                Введите описание:
                <input class="form-control" type="text" name="description">
            </div>
            <div class="form-group">
                Введите цену:
                <input class="form-control" type="text" name="price">
            </div>
            <div class="form-group">
                Введите желаемые теги:
                <input class="form-control" type="text" name="tags">
            </div>
            <div class="form-group">
                Можете добавить картинку:
                <input type="file" name="img[]" multiple/>
            </div>
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>
    </div>
@endsection
