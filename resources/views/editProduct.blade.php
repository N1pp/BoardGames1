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
            <form method="POST" action="{{route('editProduct')}}" enctype="multipart/form-data">
                {{--                TODO Добавить краткое описание              --}}
                <div class="form-group">
                    @csrf
                    Edit name:
                    <textarea class="form-control" id="text" name="name">{{$product->name}}</textarea>
                </div>
                <div class="form-group">
                    Edit description:
                    <textarea class="form-control" id="text" name="description">{{$product->description}}</textarea>
                </div>
                <div class="form-group">
                    Edit short description:
                    <textarea class="form-control" id="text" name="descriptionSmall">{{$product->descriptionSmall}}</textarea>
                </div>
                <div class="form-group">
                    Edit price:
                    <input class="form-control" type="number" name="price" min="1" value="{{$product->price}}">
                </div>
                <div class="form-group">
                    Edit tags:
                    <?php
                    $str = null;
                    foreach ($product->tags as $tag) {
                        $str = $str . $tag->value . ' ,';
                    }
                    ?>
                    <input class="form-control" type="text" name="tags" value="{{$str}}">
                </div>
                <input type="hidden" value="{{$product->id}}" name="id">
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
        </div>
    </div>
@endsection
<script>
</script>
