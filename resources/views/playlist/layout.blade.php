@extends('layouts.app')
@section('title')
    {{ __('Create playlist') }}
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center">{{ __('Create playlist') }}</h1>
                @include('layouts._partials.flash-message')
                <form action="{{ route('playlist-randomize') }}" class="form form-horizontal" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-row align-items-center">
                        <div class="col-sm-3 my-1">
                            <label for="sets">{{ __('Set amount') }}</label>
                            <input type="number" value="{{ old('sets') ?? 2 }}" class="form-control" id="sets" name="sets" placeholder="{{ __('Set amount') }}">
                            @if($errors->has('sets'))
                                <span class="help-block">{{$errors->first('sets')}}</span>
                            @endif
                        </div>
                        <div class="col-sm-3 my-1">
                            <label for="per_set">{{ __('Songs per set') }}</label>
                            <input type="number" value="{{ old('per_set') ?? 10 }}" class="form-control" name="per_set" id="per_set" placeholder="{{ __('Songs per set') }}">
                            @if($errors->has('per_set'))
                                <span class="help-block">{{$errors->first('per_set')}}</span>
                            @endif
                        </div>
                        <div class="col-auto mt-4">
                            <div class="form-check">
                                <input class="form-check-input" name="encore" type="checkbox" id="encore">
                                <label class="form-check-label" for="encore">
                                    {{ __('Encore') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3 mt-4">
                            <button type="submit" class="btn btn-primary">{{ __('Generate') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
