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
        <div class="container">
            <form method="POST" action="{{route('createProduct')}}" enctype="multipart/form-data">
{{--                TODO Добавить краткое описание              --}}
                <div class="form-group">
                    @csrf
                    Enter name:
                    <textarea class="form-control" id="text" name="name"></textarea>
                </div>
                <div class="form-group">
                    Enter short description:
                    <textarea class="form-control" id="text" name="descriptionSmall"></textarea>
                </div>
                <div class="form-group">
                    Enter description:
                    <textarea class="form-control" id="text" name="description"></textarea>
                </div>
                <div class="form-group">
                    Enter price:
                    <input class="form-control" type="number" min="1" name="price">
                </div>
                <div class="form-group">
                    Enter tags:
                    <input class="form-control" type="text" name="tags">
                </div>
                <div class="form-group">
                    You can add a picture:
                    <input type="file" name="img"/>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
@endsection
<script>
</script>
