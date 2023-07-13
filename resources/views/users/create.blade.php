@extends('layout')

@section('content')
    <div class="container-fluid">
        <h6> create user</h6>

        <form class="mx-5"
              enctype="multipart/form-data"
              method="post" action="{{route('users.store')}}">
            @csrf

            @isset($user)

                <input type="hidden" name="id" value="{{$user->id}}">
                <input type="hidden" name="old" value="{{$user->id}}">
            @endisset
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" value="{{old('name',$user??"")}}" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Enter name" id="name">

                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" value="{{old('email',$user??"")}}" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="Enter email" id="email">

                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" value="{{old('password')}}" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Enter password" id="password">

                @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" value="{{old('Phone',$user??"")}}" name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       placeholder="Enter phone" id="phone">

                @error('phone')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="role_id"> Role</label>
                <select class="form-control select2  @error('roles') is-invalid @enderror" name="roles"
                        id="role_id">
                    <option value="">select role</option>
                    @isset($user)
                    @foreach($user->roles as $role)
                    <span class="mx-1"> @php
                       $userRole= $role->name
                    @endphp </span>
                @endforeach
                @endisset

                    @foreach($roles as $role)
                        <option value="{{$role->name}}"
                            @isset($user)
                         @if($role->name==$userRole) selected @endif
                         @endisset

                            {{--                            @selected(old('brand_id',$user??"") == $role->name) --}}
                        >{{$role->name}}</option>
                    @endforeach

                </select>
                @error('roles')
                           <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" value="{{old('image',$product??"")}}"
                       accept="image/*"
                       name="image" class="form-control @error('image') is-invalid @enderror"
                       id="image">
                @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                @isset($user)

                <td><img width="100" src="{{url('storage/'.$user->image)}}"></td>
            @endisset

            </div>



            <div class="form-group form-check">
                <label class="form-check-label">
                    <input name="status"

                           @checked(old('status',$user??"") )

                           class="form-check-input" type="checkbox"> Status

                </label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
