@extends('layouts.app')
@section('content')

<div class="container mtb">

  <div class="row">
    <div class="col-lg-12 margin-tb">
      <div class="pull-left">
        <h2>Tambahkan user</h2>
      </div>
      <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('user.index') }}"> Back</a>
      </div>
    </div>
  </div>




  <form action="{{route('user.store') }}" method="POST" enctype="multipart/form-data">

   <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">

          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                           <strong>Name</strong>

            
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                         
                        </div>

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                          <strong> username</strong>

                            
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                      
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <strong> Password</strong>

                           
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                           
                        </div>

                        <div class="form-group">
                           <strong>Confirm Password</strong>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                  
                        </div>

      <div class="form-group">
        <strong>Alamat:</strong>
        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="alamat">
      </div>
      <div class="form-group">
        <strong>telepon:</strong>
        <input type="number" class="form-control" name="telepon" id="telepon" placeholder="telepon">
      </div>


      <div class="form-group">
       <strong>Role:</strong>
       <select  class="form-control" id="role" name="role">



        <option value="1"  > Admin </option>
        <option value="2"  > Karyawan </option>

        <option value="3"  > Owner </option>


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