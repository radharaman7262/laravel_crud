<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Simple Laravel 11 CRUD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="bg-dark py-3">
    <h3 class="text-white text-center">Simple Laravel 11 CRUD</h3>
  </div>

  <div class="container">
    
     <div class="row justify-content-center mt-4">
      <div class="col-md-10 d-flex justify-content-end">
        <a href="{{ route( 'products.index' ) }}" class="btn btn-dark">Back</a>
      </div>
    </div>

    <div class="row d-flex justify-content-center">
      <div class="col-md-10">
        <div class="card border-0 shadow-lg my-4">
          <div class="card-header bg-dark">
            <h3 class="text-white">Edit Product</h3>
          </div>

          @if (session('success'))
            <div class="alert alert-success m-3">
              {{ session('success') }}
            </div>
          @endif

          <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
          @method('put')
            @csrf
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label h5">Name</label>
                <input type="text" name="name" value="{{ old('name',$product->name) }}" class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="Name">
                @error('name') <p class="invalid-feedback">{{ $message }}</p> @enderror
              </div>

              <div class="mb-3">
                <label class="form-label h5">Sku</label>
                <input type="text" name="sku" value="{{ old('sku',$product->sku) }}" class="form-control form-control-lg @error('sku') is-invalid @enderror" placeholder="Sku">
                @error('sku') <p class="invalid-feedback">{{ $message }}</p> @enderror
              </div>

              <div class="mb-3">
                <label class="form-label h5">Price</label>
                <input type="text" name="price" value="{{ old('price',$product->price) }}" class="form-control form-control-lg @error('price') is-invalid @enderror" placeholder="Price">
                @error('price') <p class="invalid-feedback">{{ $message }}</p> @enderror
              </div>

              <div class="mb-3">
                <label class="form-label h5">Description</label>
                <textarea name="description" class="form-control" placeholder="Description" cols="30" rows="5">{{ old('description',$product->description) }}</textarea>
              </div>

              <div class="mb-3">
                <label class="form-label h5">Image</label>
                <input type="file" name="image" class="form-control form-control-lg">

                 @if ($product->image != "")
                     <img class="w-50 my-3" src="{{ asset('uploads/products/'.$product->image) }}" alt="">
                  @endif
              </div>
              
              <div class="d-grid">
                <button class="btn btn-lg btn-primary">Update</button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</body>
</html>
