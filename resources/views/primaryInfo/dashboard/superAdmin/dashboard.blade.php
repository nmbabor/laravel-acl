@extends('layouts.app')
@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a> Dashboard </a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                <?php
                $color = ['yellow','green','red','blue'];
                $c=0;
                ?>
                @foreach($allCompany as $company)

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                        <!-- Modal -->
                                        <div class="modal fade" id="company-{{$company->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">  Information </h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="list-group">
                                                            <li class="list-group-item"><b> Company Name : </b>{{$company->company_name}} </li>
                                                            <li class="list-group-item"><b> Address : </b>{{$company->address}} </li>
                                                            <li class="list-group-item"><b>Shipping Address : </b>{{$company->shipping_address}} </li>
                                                            <li class="list-group-item"><b>Mobile Number : </b>{{$company->mobile_no}} </li>
                                                            <li class="list-group-item"><b>Email : </b>{{$company->email}} </li>
                                                            <li class="list-group-item">  <b> Logo : </b>
                                                                <img src="{{asset($company->logo)}}" alt="{{$company->company_name}}">  <b> Favicon : </b>
                                                                <img src="{{asset($company->favicon)}}" alt="{{$company->company_name}}"></li>
                                                        </ul>
                                                        <li class="list-group-item">
                                                            <b> Modules : </b>

                                                            @foreach($company->modules as $key => $module)
                                                                {{($key>0)?', ':''}} {{$module->menu->name}}
                                                            @endforeach
                                                        </li>
                                                        </ul>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <h6 class="text-muted m-b-0">{{$company->company_name}}</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <a title="Click for show details" data-toggle="modal"href="#company-{{$company->id}}">
                                @if($company->favicon!=null)
                                    <img src="{{asset($company->favicon)}}" class="img-responsive">
                                    @else
                                    <i class="feather icon-file-text f-28"></i>
                                    @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-c-{{$color[$c]}}">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0"> {{$company->company_name}} </p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php
                        $c++;
                        if($c>3){
                            $c=0;
                        }
                    ?>
                @endforeach
            </div>

            <!-- project and updates end -->
        </div>
        <!-- [ page content ] end -->
    </div>

@endsection