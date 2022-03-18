@extends('admin.layout.master')
@section('title', 'About')
@php $p='frontend'; $sm="about" @endphp
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">About</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">about</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('about.update', $about->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row justify-content-center">
                                    <div class="form-group col-sm-12">
                                        <label for="title">Title<span class="t_r">*</span></label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"  value="{{ $about->title }}" placeholder="Enter Product Name" required>
                                        @error('title')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="texts">Info<span class="t_r">*</span></label>
                                        <textarea class="form-control t @error('texts') is-invalid @enderror" name="texts" id="editor">{!! $about->texts !!}</textarea>
                                        @error('texts')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div align="center" class="mr-auto card-action">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layout.footer')
</div>

@include('sweetalert::alert')
@push('custom_scripts')
<script>
    // ClassicEditor
    //     .create( document.querySelector( '#editor' ) )
    //     .catch( error => {
    //         console.error( error );
    //     });
    ClassicEditor
    .create( document.querySelector( '#editor' ), {
        removePlugins: [  ],
        toolbar: ['Heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' , 'Link']
    } )
    .catch( error => {
        console.log( error );
    });
</script>
@endpush
@endsection

