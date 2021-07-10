@extends('layouts.app')
@section('title')
    {{ __('Available songs') }}
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center">{{ __('Available songs') }}</h1>
                @include('layouts._partials.flash-message')
                <div class="btn-group" role="group">
                    {{ __('Available songs:') }} {{ $available }}
                </div>
                <div class="btn-group float-right" role="group">
                    <a href="{{ route('songs.add') }}" type="button" class="btn btn-primary mb-3">{{ __('Add a song') }}</a>
                </div>
                <table id="product-table" class="table table-hover">
                    <thead>
                    <tr>
                        <th>{{ __('Actions') }}</th>
                        <th>{{ __('Author') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Tempo') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($songs->count() === 0)
                        <tr>
                            <td colspan="4" class="cell-middle">
                                <div class="note note-info text-center">
                                    <h4>
                                        {{ __('No songs yet...') }}
                                    </h4>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @foreach($songs as $song)
                        <tr>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        {{ __('Actions') }}
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li class="dropdown-item">
                                            <a href="{{ route('songs.edit', ['id' => $song->id ])}}">
                                                <i class="fa fa-edit">
                                                </i>
                                                {{ __('Edit') }}
                                            </a>
                                        </li>
                                        <li class="dropdown-divider">
                                        </li>
                                        <li class="dropdown-item evil">
                                            <a href="#delete-modal" data-toggle='modal' title="Видалити" data-link="{{ route('songs.delete', ['id' => $song->id]) }}" class="delete-song" >
                                                <i class="fa fa-times"></i>
                                                {{ __('Delete') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
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
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" class="text-center">
                            {!! $songs->links('layouts._partials.pagination') !!}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div style="display: none;" class="modal fade" id="delete-modal" role="dialog" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header borderless">
                    <h4 class="modal-title">{{ __('Delete song?') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <a class="btn btn-danger delete-confirm">
                        {{ __('Yes') }}
                    </a>
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">
                        {{ __('No') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            $('.delete-song').on('click', function() {
                let link = $(this).closest('a.delete-song'),
                    url = link.data('link');
                $('.delete-confirm').attr('href', url);
            });
        });
    </script>
@endsection
