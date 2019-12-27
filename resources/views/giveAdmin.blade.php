@extends('layouts.app')
@section('content')
    <button class="btn btn-info" onClick='location.href="{{ route('createProductForm') }}"'>Create new product</button>
    <button class="btn btn-info" onClick='location.href="{{ route('showComments') }}"'>Show comments</button>
    <button class="btn btn-info" onClick='location.href="{{ route('showProductStatistics') }}"'>Show Statistics</button>
    <button class="btn btn-info" onClick='location.href="{{ route('admin') }}"'>Show Products</button>
    <form method="GET" action="{{ route('filterUsers') }}">
        @csrf
        <div class="form-group col-2">
            @csrf
            Enter name:
            <div class="form-group">
                <input class="form-control" type="text" id="text" name="name">
            </div>
            <button type="submit" class="btn btn-info" >Search</button>
        </div>

    </form>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>E-mail</th>
            <th>Role</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->role}}</td>
                <td>
                    @if($user->id == \Illuminate\Support\Facades\Auth::id())
                        Cannot edit your own role
                    @else
                        @if($user->role != 'admin')
                            <form action="{{ route('giveAdmin') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{$user->id}}" name="id">
                                <button class="btn btn-info">Give Admin</button>
                            </form>
                        @else
                            <form action="{{ route('removeAdmin') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{$user->id}}" name="id">
                                <button class="btn btn-danger" type="submit">Remove Admin</button>
                            </form>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
