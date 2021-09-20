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
                <form action="{{ route('playlist-save') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $playlist->id ?? NULL }}">
                    <div class="btn-group float-right" role="group">
                        <button type="submit" name="action" class="btn btn-primary mb-3" value="save">{{ __('Save') }}</button>
                        <button type="submit" name="action" class="btn btn-outline-primary mb-3" value="export">{{ __('Export doc without save') }}</button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-row align-items-center">
                        <div class="col-sm-12 my-1">
                            <input type="Text" value="{{ $playlist->name ?? NULL }}" class="form-control" id="name" name="name" placeholder="{{ __('Playlist name') }}">
                            @if($errors->has('name'))
                                <span class="help-block">{{$errors->first('name')}}</span>
                            @endif
                        </div>
                    </div>

                    @foreach($data['sets'] as $i => $setItems)
                        <h3 class="text-center text-uppercase">
                            Set #{{ $i + 1 }}
                        </h3>
                        <table class="table table-hover sortable" id="set[{{ $i }}]">
                            <thead>
                            <tr>
                                <th></th>
                                <th>№</th>
                                <th>{{ __('Author') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Tempo') }}</th>
                            </tr>
                            </thead>
                            @foreach($setItems as $song)
                                <tr class="song-row">
                                    <input class="song-id" type="hidden" value="{{ $song->id }}">
                                    <td class="sort-control">
                                        <i class="fa fa-lg fa-arrows"></i>
                                    </td>
                                    <td class="sort-order">{{ $loop->iteration }}</td>
                                    <td>
                                        {{$song->author}}
                                    </td>
                                    <td>
                                        {{$song->name}}
                                    </td>
                                    <td>
                                        {{ $song->tempo }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endforeach
                    @if(isset($data['encore']))
                        <h3 class="text-center text-uppercase">
                            {{ __('Encore songs') }}
                        </h3>
                        <table class="table table-hover sortable" id="encore">
                            <thead>
                            <tr>
                                <th></th>
                                <th>№</th>
                                <th>{{ __('Author') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Tempo') }}</th>
                            </tr>
                            </thead>
                            @foreach($data['encore'] as $song)
                                <tr class="song-row">
                                    <input class="song-id" type="hidden" value="{{ $song->id }}">
                                    <td class="sort-control">
                                        <i class="fa fa-lg fa-arrows"></i>
                                    </td>
                                    <td class="sort-order">{{ $loop->iteration }}</td>
                                    <td>
                                        {{$song->author}}
                                    </td>
                                    <td>
                                        {{$song->name}}
                                    </td>
                                    <td>
                                        {{ $song->tempo }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                    @if(isset($data['unused']))
                        <h3 class="text-center text-uppercase">
                            {{ __('Unused songs') }}
                        </h3>
                        <table class="table table-hover sortable" id="unused">
                            <thead>
                            <tr>
                                <th></th>
                                <th>№</th>
                                <th>{{ __('Author') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Tempo') }}</th>
                            </tr>
                            </thead>
                            @foreach($data['unused'] as $song)
                                <tr class="song-row">
                                    <input class="song-id" type="hidden" value="{{ $song->id }}">
                                    <td class="sort-control">
                                        <i class="fa fa-lg fa-arrows"></i>
                                    </td>
                                    <td class="sort-order"></td>
                                    <td>
                                        {{$song->author}}
                                    </td>
                                    <td>
                                        {{$song->name}}
                                    </td>
                                    <td>
                                        {{ $song->tempo }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                    <div class="btn-group float-right" role="group">
                        <button type="submit" name="action" class="btn btn-primary mb-3" value="save">{{ __('Save') }}</button>
                        <button type="submit" name="action" class="btn btn-outline-primary mb-3" value="export">{{ __('Export doc without save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {
            var fixHelperModified = function (e, ul) {
                var $originals = ul.children();
                var $helper = ul.clone();
                $helper.children().each(function (index) {
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            }
            var updateIndex = function () {
                $('.song-row').each(function (i) {
                    var numberCell = $(this).find('.sort-order');
                    numberCell.text(i + 1);
                    var input = $(this).find('.song-id');
                    var table = input.closest('table');
                    var tableId = table.attr('id');
                    if (tableId === 'unused') {
                        input.removeAttr('name');
                        return;
                    }
                    var inputName = null;
                    if (tableId === 'encore') {
                        inputName = 'encore[]';
                    } else {
                        inputName = `${tableId}[]`;
                    }
                    input.attr('name', inputName);

                });
            }
            $('tbody').sortable({
                connectWith: ".sortable tbody",
                helper: fixHelperModified,
                handle: '.fa-arrows',
                stop: (e, ui) => {
                    updateIndex(e, ui);
                }
            }).disableSelection();
            $('form').submit(function (e) {
                var inputs = $('input.song-id');
                inputs.each(function (i) {
                    if ($(this).attr('name') == undefined && $(this).closest('table').attr('id') !== 'unused') {
                        alert('{{ __('Try to drag & drop songs.') }}');
                        e.preventDefault();
                        return false;
                    }
                })
            })
        });
    </script>
@endsection
