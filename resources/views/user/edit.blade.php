@extends('layouts.app')

@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit user</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('user.index') }}"> Back</a>
            </div>
        </div>
    </div>
   @include('partials.alerts.errors')


<form action="{{route('user.update',$task->id)}}" method="POST" enctype="multipart/form-data">

    {{ method_field('PATCH') }}


   <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">

          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                           <strong>Name</strong>

            
                                <input id="name" type="text" class="form-control" name="name" value="{{$task->name}}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                         
                        </div>

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                          <strong> username</strong>

                            
                                <input id="username" readonly type="text" class="form-control" name="username" value="{{$task->username}}" required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                      
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <strong> Password</strong>

                           
                                <input id="password" type="password" class="form-control" name="password" placeholder="Empty = password unchanged" value="">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                           
                        </div>

                        <div class="form-group">
                           <strong>Confirm Password</strong>
                                <input id="password-confirm" type="password" class="form-control" value="{{$task->password_confirmation}}" name="password_confirmation" >
                  
                        </div>

      <div class="form-group">
        <strong>Alamat:</strong>
        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="alamat" value="{{$task->alamat}}">
      </div>
      <div class="form-group">
        <strong>telepon:</strong>
        <input type="number" class="form-control" name="telepon" id="telepon" placeholder="telepon" value="{{$task->telepon}}">
      </div>


      <div class="form-group">
       <strong>Role:</strong>
       <select  class="form-control" id="role" name="role" >



        <option value="1" @if($task->role == 1) selected @endif > Admin </option>
        <option value="2" @if($task->role == 2) selected @endif  > Karyawan </option>

        <option value="3" @if($task->role == 3) selected @endif  > Owner </option>


      </select>

    </div>


    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" class="btn btn-primary">Submit</button>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>
  </div>

</form>

</div>
@endsection