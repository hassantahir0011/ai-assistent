<div class="item-details-control-root">
    <div class="ux-item-details" role="main">
        <div class="ux-section-banner static" id="section-banner"
             data-bind="style: { 'background-color': brandingColor }">
            <div class="ux-section-core gallery-centered-content">
                <table  class="overview-table overview-table-split-section">
                    <tbody>
                    <tr>
                        <td class="item-img" id="vss_2">
                            <img class="image-display" alt=""
                                 src="{{ $doc->thumbnail_url??'' }}"
                                 style="top: 1px; visibility: visible;">
                            <div class="bowtie-icon"
                                 style="display: none;"></div>
                        </td>

                        <td class="item-header">
                            <div class="item-header-content light" data-bind="css: brandingTheme">
                                <h1><span class="ux-item-name"
                                          data-bind="text: itemName">{{ $doc->title??'' }}</span></h1>

                                {{--<span class="ux-item-titleTag light"--}}
                                {{-->Preview</span>--}}

                                <div class="ux-item-second-row-wrapper">
                                    {{--<span class="item-price-category" data-bind="text: itemPriceCategory">{{ isset($doc->type) && $doc->type=='Premium'?'Paid Plan Snippet':'Free Snippet' }}</span>--}}

                                </div>
                                <div class="ux-item-shortdesc">
                                    {!! $doc->note??''  !!}
                                </div>


                                <div class="ux-item-action">
                                    <div class="installButtonContainer">
                                        <div class="ms-Fabric root-38">
                                            <span
                                                    class="ux-oneclick-install-button-container">
                                                <a id="install-webhook-btn"
                                                   href="javascript:"
                                                   class="ms-Button ux-button install ms-Button--default root-39"
                                                   data-is-focusable="true"><div
                                                            class="ms-Button-flexContainer flexContainer-40"><div
                                                                class="ms-Button-textContainer textContainer-41"><div
                                                                    class="ms-Button-label label-43"
                                                                    id="id__0">Setup Now</div>
                                                        </div></div></a>
                                            </span>
                                            {{--<span--}}
                                                    {{--class="installHelpInfo">--}}
                                                {{--<a href="javascript:"--}}
                                                   {{--target="_blank"--}}
                                                   {{--rel="noreferrer noopener">Trouble Installing?<i--}}
                                                            {{--class="fa fa-external-link"></i></a>--}}
                                            {{--</span>--}}
                                        </div>
                                    </div>
                                    <div style="display:none"><input type="text" id="FQN" readonly=""
                                                                     value="mrmlnc.vscode-scss">
                                        <input type="text"
                                               id="galleryUrl"
                                               readonly=""
                                               value="/"><input
                                                type="text" id="searchTarget" readonly="" value="VSCode"></div>
                                </div>


                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div id="snippet-video">
                    <div id="doc-view-player"></div>
                </div>
            </div>
        </div>

        <div class="gallery-centered-content">
            <div class="ux-section-details">
                <div data-bind="galleryReactElem: ItemDetailsComponent">
                    <div class="ms-Fabric ux-section-details-tabs root-38">
                        <div>

                            <div role="tabpanel" aria-labelledby="Pivot3-Tab0">
                                <div>
                                    <div class="details-tab itemdetails">
                                        <table class="ux-section-details-table">
                                            <tbody>
                                            <tr>
                                                <td class="ux-itemdetails-left">
                                                    <div class="itemDetails">
                                                        {{--snippet details in html format from backend crm--}}
                                                        <div id="html-formatted-description">

                                                            {!! html_entity_decode($doc->description??'') !!}
                                                        </div>
                                                        {{--media gallery html--}}
                                                        @if(isset($doc->media) && !empty($doc->media))
                                                            <div class="block app-listing__section">
                                                                <h3 class="block__heading heading--3">Media gallery</h3>
                                                                <div class="block__content">
                                                                    <ul  id="lightgallery" class="app-listing-media">
                                                                        @foreach($doc->media as $media_img)
                                                                            <li class="app-listing-media__thumbnail">
                                                                                <a class="item" data-rel="lightcase:myCollection:slideshow" href="{{ $media_img->media_url }}">
                                                                                    <img  height="180" width="320" src="{{ $media_img->media_url }}">
                                                                                </a>          </li>
                                                                        @endforeach

                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </td>
                                                <td class="ux-itemdetails-right" role="complementary">
                                                    <div class="itemDetails-right">
                                                        <div class="meta-data-list-container">
                                                            {{--<div class="ux-section-meta-data-list"><h3--}}
                                                                        {{--class="ux-section-header right">Category</h3>--}}
                                                                {{--<div class="meta-data-list" role="group">--}}
                                                                    {{--<a href="javascript:"--}}
                                                                       {{--class="meta-data-list-link">--}}
                                                                        {{--{{ $doc->category??'' }}--}}
                                                                    {{--</a>--}}
                                                                {{--@if(!empty($doc->subcategory))--}}
                                                                    {{--<!--&gt;--}}
                                                                        {{--<a href="javascript:"--}}
                                                                           {{--class="meta-data-list-link">--}}
                                                                            {{--{{ $doc->subcategory??'' }}--}}
                                                                            {{--</a>-->--}}
                                                                    {{--@endif--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            @if(!empty($doc->tags))
                                                                <div class="ux-section-meta-data-list"><h3
                                                                            class="ux-section-header right">Tags</h3>

                                                                    <div class="meta-data-list" role="group">
                                                                        @foreach(explode(',',$doc->tags) as $tag)
                                                                            <a class="meta-data-list-link"
                                                                               href="javascript:">{{ $tag }}</a>
                                                                        @endforeach

                                                                    </div>

                                                                </div>
                                                            @endif
                                                        </div>


                                                        <div class="ux-section-other">
                                                            <h3 class="itemdetails-section-header">More Info </h3>
                                                            <div>
                                                                <table class="ux-table-metadata">
                                                                    <tbody>
                                                                    <!--<tr>
                                                                        <td id="Version" aria-hidden="true">Version</td>
                                                                        <td role="definition" aria-labelledby="Version">
                                                                            0.1.0
                                                                        </td>
                                                                    </tr>-->
                                                                    <tr>
                                                                        <td id="Released_on" aria-hidden="true"><b>Released
                                                                                on &nbsp;&nbsp; :</b>
                                                                        </td>
                                                                        <td role="definition"
                                                                            aria-labelledby="Released_on">
                                                                            {{ $doc->created_at??'' }}
                                                                        </td>
                                                                    </tr>


                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $('#html-formatted-description').find('a').attr('target', '_blank');
    @if(isset($doc->media) && !empty($doc->media))
    $("#lightgallery").lightGallery({
        thumbnail:false,
        download:false,
        selector: '.item',
        share:false,
        autoplayControls:false,
        zooom:false,
        hideBarsDelay:60000
    });

    @endif
    @if(isset($doc->video_url) && !empty($doc->video_url))
    // Load the IFrame Player API code asynchronously.
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    var player;

    function onYouTubePlayerAPIReady() {
        player = new YT.Player('doc-view-player', {
            height: '220',
            width: "100%",
            videoId: '{{ $doc->video_url }}'
        });
    }

    @else
    $('#snippet-video').remove();
    $('.overview-table').removeClass('overview-table-split-section');

    @endif
</script>
