@extends('layouts.master')
<?php
$asset_controls = [
    'quill', 'sweetalert',
//    'bootstrap'
];
?>

@section('content')
    <section class="section">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <h2>{{ $product['title'] }}</h2>

                    <div class="card mb-3">
                        <img src="{{ $product['image']['src'] ?? env('APP_URL')."/css/appdesign/images/shopify-img.png" }}" class="card-img-top" alt="Product Thumbnail">
                        @if(count($product['images']))
                            <div class="card-body">
                                <h5 class="card-title">Product Images</h5>
                                @foreach ($product['images'] as $image)
                                    <img src="{{ $image['src'] }}" class="img-fluid" alt="Product Image">
                                @endforeach
                            </div>
                        @endif
                        <button class="btn btn-primary mt-3" onclick="generateImages()">Auto Generate Images From Title & Description</button>
                        <button class="btn btn-secondary mt-3" onclick="generateImages('{{ $product['image']['src'] ?? "" }}')">Auto Generate Images From Thumbnail</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Description</h5>
                            <div id="productDescription" style="height: 200px;">{!! $product['body_html'] !!}</div>
                        </div>
                    </div>

                    <button class="btn btn-primary mt-3" onclick="generateDescription()">Auto Generate Description</button>
                    <button class="btn btn-success mt-3" onclick="postToShopify()">Post to Shopify</button>
                </div>
            </div>
            <div id="generated_images" class="row">
            </div>
            <div class="row">
                <button class="btn btn-success mt-3" onclick="postImagesToShopify()">Upload Images to Shopify</button>
            </div>
        </div>
    </section>
@endsection

@section('last_scripts')
    <script type="text/javascript">
        // Initialize Quill editor
        var quill = new Quill('#productDescription', {
            theme: 'snow',
            readOnly: false
        });

        function generateDescription() {
            var generatedDescription = "This is an auto-generated description.";
            quill.root.innerHTML = generatedDescription;
        }

        function postToShopify() {
            var updatedDescription = quill.root.innerHTML;
            console.log("Updated Description: " + updatedDescription);
            // Perform necessary operations to post the updated product description to Shopify
            show_loading_img();
            $.ajax({
                url: '{{ route('update_product') }}',
                type: 'POST',
                data: {
                    _method: 'POST',
                    _token: "<?= Session::token() ?>",
                    id: {{ $product['id'] }},
                    body_html: updatedDescription,

                },
                cache: false,
                success: function (result) {
                    if (result && result.status == 'success') {
                        swal(result.status, result.message, 'success');
                    } else {
                        swal(result.status, result.message, 'error');
                    }
                    hide_loading_img();
                }, error: function (response) {
                    swal('Warning', 'Failed to update . Try again !!', 'warning');
                    hide_loading_img();
                },
                timeout: 15000
            }).fail(function (jqXHR, textStatus) {
                if (textStatus === 'timeout') {
                    swal("Sorry", 'Please Wait... Slow connection!', "error");

                }
                hide_loading_img();
            });
        }

        function postImagesToShopify() {
            @php
                $ids = [];
                foreach ($product['images'] as $image)
                    $ids[] = $image['id'];
            @endphp
            var existing_images = '{{ implode(',', $ids) }}';
            var selectedImages = [];

            // Get all the checked checkboxes
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');

            // Get the values (image URLs) from the checked checkboxes
            for (var i = 0; i < checkboxes.length; i++) {
                selectedImages.push(checkboxes[i].value);
            }

            // Log the selected images for testing
            console.log(existing_images, selectedImages);
            // Perform necessary operations to post the updated product description to Shopify
            show_loading_img();
            $.ajax({
                url: '{{ route('upload_images') }}',
                type: 'POST',
                data: {
                    _method: 'POST',
                    _token: "<?= Session::token() ?>",
                    id: {{ $product['id'] }},
                    existing_images: existing_images,
                    selected_images: selectedImages,

                },
                cache: false,
                success: function (result) {
                    if (result && result.status == 'success') {
                        swal(result.status, result.message, 'success');
                    } else {
                        swal(result.status, result.message, 'error');
                    }
                    hide_loading_img();
                }, error: function (response) {
                    swal('Warning', 'Failed to update . Try again !!', 'warning');
                    hide_loading_img();
                },
                timeout: 15000
            }).fail(function (jqXHR, textStatus) {
                if (textStatus === 'timeout') {
                    swal("Sorry", 'Please Wait... Slow connection!', "error");

                }
                hide_loading_img();
            });
        }

        function generateImages(src = "") {
            var updatedDescription = quill.root.innerHTML;
            console.log("Updated Description: " + updatedDescription);
            // Perform necessary operations to post the updated product description to Shopify
            show_loading_img();
            $.ajax({
                url: '{{ route('generate_images') }}',
                type: 'POST',
                data: {
                    _method: 'POST',
                    _token: "<?= Session::token() ?>",
                    id: {{ $product['id'] }},
                    title: '{{ $product['title'] }}',
                    body_html: updatedDescription,
                    img_src: src ?? false,
                },
                cache: false,
                success: function (result) {
                    if (result && result.status == 'success') {
                        var loop = 0;
                        var images = result.output.map(img => {
                            loop++;
                            return '<div class="col-md-4 mb-4">\
                            <div class="card">\
                                <img src="'+img+'" class="card-img-top" alt="Product Image">\
                                    <div class="card-body">\
                                        <div class="form-check">\
                                            <input class="form-check-input" type="checkbox" id="image-'+loop+'" value="'+img+'">\
                                                <label class="form-check-label" for="image-'+loop+'">Select</label>\
                                        </div>\
                                    </div>\
                            </div>\
                        </div>';
                        });
                        $('#generated_images').append(images);
                        swal(result.status, result.message, 'success');
                    } else {
                        swal(result.status, result.message, 'error');
                    }
                    hide_loading_img();
                }, error: function (response) {
                    swal('Warning', 'Failed to update . Try again !!', 'warning');
                    hide_loading_img();
                },
                timeout: 35000
            }).fail(function (jqXHR, textStatus) {
                if (textStatus === 'timeout') {
                    swal("Sorry", 'Please Wait... Slow connection!', "error");

                }
                hide_loading_img();
            });
        }
    </script>
@endsection