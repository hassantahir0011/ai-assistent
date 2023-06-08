@extends('layouts.master')
<?php
$asset_controls = [
    'quill', 'sweetalert',
//    'bootstrap'
];
?>

@section('content')
    <style>
        .modal-content .modal-footer {
             background: transparent;
             display: block;
        }
        .modal {
            z-index: 1050 !important;
        }
    </style>
    <main id="main">
        <section class="section productPage">
            <div class="container">
                <div class="text-right pb-5">
                    <button class="btn" onclick="postToShopify()">Post to Shopify</button>
                </div>
                <div class="mainbox">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="img-box">
                                <img src="{{ $product['image']['src'] ?? env('APP_URL')."/css/appdesign/images/shopify-img.png" }}" class="card-img-top" alt="Product Thumbnail">
                            </div>
                            <hr />
                            <div class="card mb-3 p-0">
                                @if(count($product['images']))
                                    <div class="card-body bg-transparent">
                                        <h5 class="card-title">Product Images</h5>
                                        <ul class="productList">
                                            @foreach ($product['images'] as $image)
                                                <li>
                                                    <div class="img-box">
                                                        <img src="{{ $image['src'] }}" class="img-fluid" alt="Product Image">
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Auto Generate Images From </label>
                                            <select class="form-select" id="imgSelector">
                                                <option onchange="generateImages()">Title & Description</option>
                                                <option onchange="generateImages('{{ $product['image']['src'] ?? "" }}')">Thumbnail</option>
                                                <option value="slideBoxDropdown">Custom Prompt</option>
                                            </select>
                                        </div>
                                        <div class="slideBoxSelect">
                                            <div class="p-3">
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label for="generateOptions" class="form-label">Generate Description:</label>
                                                        <select id="generateOptions" class="form-select" aria-label="Generate Description">
                                                            <option selected value="titleOnly">Title Only</option>
                                                            <option value="titleAndPrompt">Title and Custom Prompt</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label for="wordCount" class="form-label">Number of Words:</label>
                                                        <select id="wordCount" class="form-select" aria-label="Number of Words">
                                                            <option selected value="100">100 words</option>
                                                            <option value="250">250 words</option>
                                                            <option value="500">500 words</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label for="formatOptions" class="form-label">Format:</label>
                                                        <select id="formatOptions" class="form-select" aria-label="Format">
                                                            <option selected value="html">Formatted</option>
                                                            <option value="plainText">Plain Text</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="input-field form-group">
                                                    <label for="prompt">Enter Custom Prompt</label>
                                                    <textarea id="prompt" class="form-control" placeholder="Define your product and its key features..." type="text"> </textarea>
                                                </div>
                                                <button type="button" onclick="generateDescription()" class="btn">Generate Description</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary mt-3" onclick="generateImages()">Auto Generate Images From Title & Description</button>
                                        <button class="btn btn-secondary mt-3" onclick="generateImages('{{ $product['image']['src'] ?? "" }}')">Auto Generate Images From Thumbnail</button>
                                    </div>
                                </div>
                            </div>
                            <ul id="generated_images" class="genrateImg">
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h2>{{ $product['title'] }}</h2>
                            <button class="btn mt-3 slideButton test-action-btn">Auto Generate Description</button>
                            <div class="slideBox">
                                <div class="p-3">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="generateOptions" class="form-label">
                                                Generate Description:
                                                <button type="button" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?"><i class="fas fa-question-circle"></i></button>
                                            </label>
                                            <select id="generateOptions" class="form-select" aria-label="Generate Description">
                                                <option selected value="titleOnly">Title Only</option>
                                                <option value="titleAndPrompt">Title and Custom Prompt</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="wordCount" class="form-label">Number of Words:
                                                <button type="button" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?"><i class="fas fa-question-circle"></i></button>
                                            </label>
                                            <select id="wordCount" class="form-select" aria-label="Number of Words">
                                                <option selected value="100">100 words</option>
                                                <option value="250">250 words</option>
                                                <option value="500">500 words</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="formatOptions" class="form-label">Format:
                                                <button type="button" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?"><i class="fas fa-question-circle"></i></button>
                                            </label>
                                            <select id="formatOptions" class="form-select" aria-label="Format">
                                                <option selected value="html">Formatted</option>
                                                <option value="plainText">Plain Text</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input-field form-group">
                                        <label for="prompt">Enter Custom Prompt
                                            <button type="button" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?"><i class="fas fa-question-circle"></i></button>
                                        </label>
                                        <textarea id="prompt" class="form-control" placeholder="Define your product and its key features..." type="text"> </textarea>
                                    </div>
                                    <button type="button" onclick="generateDescription()" class="btn">Generate Description</button>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body  bg-transparent p-0">
                                    <h5 class="card-title pt-4">Description</h5>
                                    <div id="productDescription" style="height: 200px;">{!! $product['body_html'] !!}</div>
                                </div>
                            </div>
{{--                            <button class="btn mt-3 slideButton"  data-toggle="modal" data-target="#productModal">Auto Generate Description</button>--}}

{{--                            <button class="btn btn-success mt-3" onclick="postToShopify()">Post to Shopify</button>--}}
                        </div>
                    </div>

                    <div class="row">
                        <button class="btn btn-success mt-3" onclick="postImagesToShopify()">Upload Images to Shopify</button>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ $product['title'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-field">
                        <label for="prompt">Enter Custom Prompt</label>
                        <textarea id="prompt" placeholder="Define your product and its key features..." type="text"> </textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="generateOptions" class="form-label">Generate Description:</label>
                            <select id="generateOptions" class="form-select" aria-label="Generate Description">
                                <option selected value="titleOnly">Title Only</option>
                                <option value="titleAndPrompt">Title and Custom Prompt</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="wordCount" class="form-label">Number of Words:</label>
                            <select id="wordCount" class="form-select" aria-label="Number of Words">
                                <option selected value="100">100 words</option>
                                <option value="250">250 words</option>
                                <option value="500">500 words</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="formatOptions" class="form-label">Format:</label>
                            <select id="formatOptions" class="form-select" aria-label="Format">
                                <option selected value="html">Formatted</option>
                                <option value="plainText">Plain Text</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="generateDescription()" class="btn btn-primary">Generate Description</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('last_scripts')
    <script type="text/javascript">
        // Initialize Quill editor
        var quill = new Quill('#productDescription', {
            theme: 'snow',
            readOnly: false
        });

        function generateDescription(action = false) {
            $('#productModal').modal('hide');
            show_loading_img();
            $.ajax({
                url: '{{ route('generate_text') }}',
                type: 'POST',
                data: {
                    _method: 'POST',
                    _token: "<?= Session::token() ?>",
                    id: {{ $product['id'] }},
                    title: '{{ $product['title'] }}',
                    prompt: $('#prompt').val(),
                    wordCount : $('#wordCount').val(),
                    generateOption : $('#generateOptions').val(),
                    formatOption : $('#formatOptions').val()
                },
                cache: false,
                success: function (result) {
                    if (result && result.status == 'success') {
                        quill.root.innerHTML = '';
                        $('#prompt').val('');
                        quill.root.innerHTML = result.message;
                        swal(result.status, 'Content created', 'success');
                    } else {
                        swal(result.status, result.message, 'error');
                    }
                    hide_loading_img();
                }, error: function (response) {
                    swal('Warning', 'Failed to update . Try again !!', 'warning');
                    hide_loading_img();
                },
                timeout: 990000
            }).fail(function (jqXHR, textStatus) {
                if (textStatus === 'timeout') {
                    swal("Sorry", 'Please Wait... Slow connection!', "error");

                }
                hide_loading_img();
            });
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
                            return '<li>\
                                        <div class="form-check">\
                                            <input class="form-check-input" type="checkbox" id="image-'+loop+'" value="'+img+'">\
                                            <label class="form-check-label" for="image-'+loop+'">\
                                                <img src="'+img+'" class="card-img-top" alt="Product Image">\
                                            </label>\
                                        </div>\
                                    </li>';
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
    <script>
        $(document).ready(function() {
            $('.slideButton').click(function() {
                $('.slideBox').toggleClass('active');
            });
            $('#imgSelector').change(function() {
                var selectedOption = $(this).val();
                if (selectedOption === 'slideBoxDropdown') {
                    $('.slideBoxSelect').toggleClass('active');
                } else {
                    $('.slideBoxSelect').removeClass('active');
                }
            });

        });
    </script>
@endsection