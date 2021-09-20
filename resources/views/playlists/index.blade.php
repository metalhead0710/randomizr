@extends('layouts.app')
@section('title')
    {{ __('Recent playlists') }}
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center">{{ __('Recent playlists') }}</h1>
                @include('layouts._partials.flash-message')
                <div class="btn-group" role="group">
                    {{ __('Available playlists:') }} {{ $available }}
                </div>
                <div class="btn-group float-right" role="group">
                    <a href="{{ route('playlist-layout') }}" type="button" class="btn btn-primary mb-3">{{ __('Generate playlist') }}</a>
                </div>
                <table id="product-table" class="table table-hover">
                    <thead>
                    <tr>
                        <th>{{ __('Actions') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Author') }}</th>
                        <th>{{ __('Created') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($playlists->count() === 0)
                        <tr>
                            <td colspan="4" class="cell-middle">
                                <div class="note note-info text-center">
                                    <h4>
                                        {{ __('No playlists yet...') }}
                                    </h4>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @foreach($playlists as $playlist)
                        <tr>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        {{ __('Actions') }}
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li class="dropdown-item">
                                            <a href="{{ route('playlist-edit', ['id' => $playlist->id ])}}">
                                                <i class="fa fa-edit">
                                                </i>
                                                {{ __('Edit') }}
                                            </a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a href="{{ route('files.download', ['id' => $playlist->file ])}}">
                                                <i class="fa fa-download">
                                                </i>
                                                {{ __('Download') }}
                                            </a>
                                        </li>
                                        <li class="dropdown-divider">
                                        </li>
                                        <li class="dropdown-item evil">
                                            <a href="#delete-modal" data-toggle='modal' title="Видалити" data-link="{{ route('playlist.delete', ['id' => $playlist->id]) }}" class="delete-file" >
                                                <i class="fa fa-times"></i>
                                                {{ __('Delete') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                {{$playlist->name}}
                            </td>
                            <td>
                                {{ $playlist->author->name }}
                            </td>
                            <td>
                                {{ $playlist->created_at->format('d/m/Y H:i:s') }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" class="text-center">
                            {{ $playlists->render('layouts._partials.pagination') }}
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
                    <h4 class="modal-title">{{ __('Delete playlist?') }}</h4>
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
            $('.delete-file').on('click', function() {
                let link = $(this).closest('a.delete-file'),
                    url = link.data('link');
                $('.delete-confirm').attr('href', url);
            });
        });
    </script>
@endsection
