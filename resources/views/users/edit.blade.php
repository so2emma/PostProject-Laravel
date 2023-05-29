@extends('layouts.app')

@section('content')
    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data"
        class="form-horizontal">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-4">
                <img src="{{ $user->image ? $user->image->url() : '' }}" class="img-thumbnail avatar" alt="...">
                <div class="card mt-4">
                    <div class="card-body">
                        <h6>{{ __('Upload a different photo') }}</h6>
                        <input class="form-control-file" type="file" name="avatar" />
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="mb-3">
                    <label for="name">{{ __('Name:') }}</label>
                    <input type="text" value="" class="form-control" name="name">
                </div>

                <div class="mb-3">
                    <label for="name">{{ __('Language:') }}</label>
                    <select class="form-control" name="locale" id="">
                        @foreach (App\Models\User::LOCALES as $locale  => $label)
                            <option value="{{ $locale }}" {{ $user->locale == $locale ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <x-errors></x-errors>
                <div class="mb-3">
                    <input class="btn btn-primary" type="submit" value="save changes">
                </div>
            </div>
        </div>
    </form>
@endsection
