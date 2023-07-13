
@extends('layout')
@section('content')


<form class="mx-5" method="post" enctype="multipart/form-data" action="{{route('brands.update',$brand)}}">
    @csrf
    @method('Put')
    {{-- put and post methods --}}
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" name="name" id="name" value="{{old('name',$brand)}}">
    </div>
    @error('name')
    <div class="alert alert-danger">{{$message}}</div>

    @enderror

    <div class="form-group">
        <label for="image">Image:</label>



        <input type="file" accept="image/*" class="form-control
        @error('image') is-invalid @enderror"  name="image" id="image" value="{{old('image',$brand)}}">
        <img width='300' src="{{url('storage/'.$brand->image)}}" alt="">
      </div>
      @error('image')
      <div class="alert alert-danger">{{$message}}</div>

      @enderror

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>



@endsection

