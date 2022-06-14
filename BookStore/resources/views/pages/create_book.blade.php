@extends('layouts.main-layout')
@section('css', '/css/create_book.css')
@section('tittle', 'Add Page')

@section('content')

    <section class="vh-100 text-center mt-3">
        <div class="flex-shrink-0">
            <img src="../images/book.png"
                 alt="Generic placeholder image" class="img-fluid"
                 style="width: 100px; border-radius: 10px;" />
        </div>
        <div class="container py-3 h-100">
            <div class="row justify-content-center align-items-center h-100">

                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <div class="text-center">
                                <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Add your book</h3>
                            </div>
                            <form action="{{ route('book.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                            <input type="text" id="bookName" name="bookName" placeholder="Book name" class="form-control form-control-lg {{ $errors->first('bookName') ? 'border-danger' : ''}}" />
                                            <label class="form-label" for="bookName">{{ $errors->first('bookName') }}</label>
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">$</span>
                                                </div>
                                                <input type="number" id="price" name="price" class="form-control form-control-lg {{ $errors->first('price') ? 'border-danger' : ''}}" placeholder="Price" aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                            <label class="form-label" for="price">{{ $errors->first('price') }}</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="input-group mb-3">

                                    <select class="custom-select" id="inputGroupSelect02" name="genre">
                                        <option selected hidden  value="">Select genre of your book</option>
                                        @foreach ($genres as $genre)

                                            <option value="{{$genre->id}}">{{$genre->genre}}</option>

                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="inputGroupSelect02">Options</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="textArea">Describe your book</label>
                                    <textarea class="form-control {{ $errors->first('textArea') ? 'border-danger' : ''}}" id="textArea" rows="5" name="textArea"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Upload your book main photo</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input {{ $errors->first('bookAvatar') ? 'border-danger' : ''}}" id="inputGroupFile02" name="bookAvatar">
                                        <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Upload your book (in PDF only)</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input {{ $errors->first('bookFile') ? 'border-danger' : ''}}" id="inputGroupFile01" name="bookFile">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>

                                <div class="mt-4 pt-2 text-center">
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Add book</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
