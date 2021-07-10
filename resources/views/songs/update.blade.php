@extends('layouts.app')
@section('title')
    {{ __('Edit the song') }}
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center">{{ __('Edit the song') }}</h1>
                <form action="{{ route('songs.update', ['id' => $song->id]) }}" class="form form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group{{ $errors->has('author') ? ' has-error' : ''}}">
                        <label for="author" class="control-label col-md-2">{{ __('Author') }}</label>
                        <div class="col-md-10">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input class="form-control" id="author" name="author" placeholder="{{ __('Author') }}" value="{{ $song->author }}">
                            @if($errors->has('author'))
                                <span class="help-block">{{$errors->first('author')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
                        <label for="name" class="control-label col-md-2">{{ __('Name') }}</label>
                        <div class="col-md-10">
                            <input class="form-control" id="name" name="name" placeholder="{{ __('Name') }}" value="{{$song->name}}">
                            @if($errors->has('name'))
                                <span class="help-block">{{$errors->first('name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('tempo') ? ' has-error' : ''}}">
                        <label for="title" class="control-label col-md-2">{{ __('Tempo') }}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" min="0" max="200" id="tempo" name="tempo" placeholder="{{ __('Tempo') }}" value="{{ $song->tempo }}">
                            @if($errors->has('tempo'))
                                <span class="help-block">{{$errors->first('tempo')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-10 col-md-offset-2">
                            <button type="submit" name="submit" class="btn btn-primary save">
                                <i class="fa fa-check"></i>
                                {{ __('Save') }}
                            </button>
                            <a href="{{route('songs')}}" class="btn btn-default">
                                <i class="fa fa-long-arrow-left"></i>
                                {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
