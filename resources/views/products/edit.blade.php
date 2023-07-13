@extends('layout')
@section('content')


<form class="mx-5" method="post" action="{{route('products.update',$product)}}">
    @csrf
    @method('PUT')
    {{-- put and post methods --}}
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" name="name" id="name" value="{{old('name',$product)}}">
    </div>
    @error('name')
    <div class="alert alert-danger">{{$message}}</div>

    @enderror
    <div class="form-group">
      <label for="description">Discription:</label>
      <textarea  class="form-control" name="description" id="description">{{old('description',$product )}}</textarea>
    </div>
    <div class="form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="type" @checked(old('type',$product)=='new' ||old('type')==null) value="new" >New
        </label>
      </div>
      <div class="form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="type" value="old" @checked(old('type',$product)=='old') >Old
        </label>
      </div>

    <div class="form-group form-check">
      <label class="form-check-label">
        <input name="status"

        @checked(old('status')=='on' )   class="form-check-input "  type="checkbox"> Status
      </label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>



@endsection
