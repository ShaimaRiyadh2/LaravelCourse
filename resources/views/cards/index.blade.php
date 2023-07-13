@extends('layout')
@section('content')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Cards</h1>
                    </div>

                    <div class="row">

                        @forelse($d as $item) 
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div 
                            @style([
                                'font-size:40px'
                                ])
                            @class(['border-left-primary'=>$loop->odd,
                            'card  shadow h-100 py-2',
                            'border-left-danger'=>$item['price']<40])
                            >
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               {{$loop->iteration}} {{$item['name']}}</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$  {{$item['price']}}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div> No data </div>
                        @endforelse
                    <!-- we can use foreach and after endforeach we use empty() and endempty -->
                        

                </div>
                <!-- /.container-fluid -->
@endsection
         