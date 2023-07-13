
  @extends('layout')
@section('content')


<form class="mx-5" method="post" enctype="multipart/form-data" action="{{route('brands.store')}}">
    @csrf
    {{-- put and post methods --}}
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" name="name" id="name" value="{{old('name')}}">
    </div>
    @error('name')
    <div class="alert alert-danger">{{$message}}</div>

    @enderror

    <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror"  name="image" id="image" value="{{old('image')}}">
      </div>
      @error('image')
      <div class="alert alert-danger">{{$message}}</div>

      @enderror

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>



@endsection

