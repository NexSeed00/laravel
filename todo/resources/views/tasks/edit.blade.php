@extends('layouts.app')

@section('content')
    <div class="row mt-4 px-4">
        <div class="col-12">
            <form action="{{ route('task.update', ['task' => $task->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" id="title" value="{{  old('title', $task->title) }}">
                    @if ($errors->has('title'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="contents">Contents</label>
                    <textarea class="form-control {{ $errors->has('contents') ? 'is-invalid' : '' }}" name="contents" id="contents" cols="30" rows="10">{{  old('contents', $task->contents) }}</textarea>
                    @if ($errors->has('contents'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('contents') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                        @if ($errors->has('image'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>
                    <img src="{{ asset($task->image_at) }}" class="card-img-top img-size" alt="...">
                </div>
                <input type="hidden" name="id" value="{{ $task->id }}">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">UPDATE</button>
                </div>
            </form>
        </div>
    </div>
@endsection
